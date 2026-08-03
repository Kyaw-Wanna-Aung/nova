<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FaqController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.faqs.index', $this->indexData($request));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['display_order'] = $data['display_order'] ?? $this->nextDisplayOrder();
        Faq::create($data);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully.');
    }

    public function edit(Request $request, Faq $faq): View
    {
        return view('admin.faqs.index', $this->indexData($request, $faq));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $faq->update($this->validatedData($request));

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully.');
    }

    public function changeStatus(Request $request, Faq $faq): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', 'in:Published,Draft,Archived']]);
        $faq->update($data);

        return back()->with('success', 'FAQ status updated successfully.');
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:faqs,id'],
            'action' => ['required', 'in:archive,delete'],
        ]);

        $faqs = Faq::query()->whereIn('id', $data['ids']);
        $data['action'] === 'delete'
            ? $faqs->delete()
            : $faqs->update(['status' => 'Archived']);

        return back()->with('success', 'Bulk action completed successfully.');
    }

    public function export(Request $request): StreamedResponse
    {
        $filename = 'faqs-'.now()->format('Y-m-d-His').'.csv';
        $query = $this->filteredQuery($request)->orderBy('display_order')->latest('id');

        return response()->streamDownload(function () use ($query): void {
            $stream = fopen('php://output', 'w');
            fputcsv($stream, ['Question', 'Answer', 'Category', 'Status', 'Created Date']);

            $query->chunkById(200, function ($faqs) use ($stream): void {
                foreach ($faqs as $faq) {
                    fputcsv($stream, [$faq->question, $faq->answer, $faq->category, $faq->status, $faq->created_at?->format('Y-m-d')]);
                }
            });

            fclose($stream);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function indexData(Request $request, ?Faq $selectedFaq = null): array
    {
        $sort = $request->query('sort', 'question');
        $direction = $request->query('direction', 'asc');
        $sortColumns = ['question' => 'question', 'category' => 'category', 'status' => 'status', 'created' => 'created_at'];
        $sortColumn = $sortColumns[$sort] ?? 'question';
        $direction = $direction === 'desc' ? 'desc' : 'asc';

        $faqs = $this->filteredQuery($request)
            ->orderBy($sortColumn, $direction)
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return [
            'faqs' => $faqs,
            'selectedFaq' => $selectedFaq,
            'categories' => Faq::query()->whereNotNull('category')->distinct()->orderBy('category')->pluck('category'),
            'stats' => [
                'total' => Faq::count(),
                'published' => Faq::query()->where('status', 'Published')->count(),
                'draft' => Faq::query()->where('status', 'Draft')->count(),
                'archived' => Faq::query()->where('status', 'Archived')->count(),
            ],
            'sort' => $sort,
            'direction' => $direction,
        ];
    }

    private function filteredQuery(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status');
        $category = $request->query('category');

        return Faq::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('question', 'like', "%{$search}%")->orWhere('answer', 'like', "%{$search}%");
                });
            })
            ->when(in_array($status, ['Published', 'Draft', 'Archived'], true), fn ($query) => $query->where('status', $status))
            ->when(is_string($category) && $category !== '', fn ($query) => $query->where('category', $category));
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string', 'max:5000'],
            'category' => ['required', 'string', 'max:100'],
            'status' => ['required', 'in:Published,Draft,Archived'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function nextDisplayOrder(): int
    {
        return (int) Faq::max('display_order') + 1;
    }
}
