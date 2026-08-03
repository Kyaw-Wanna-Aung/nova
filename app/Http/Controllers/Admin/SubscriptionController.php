<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        $sort = $request->query('sort', 'date');
        $direction = $request->query('direction', 'desc') === 'asc' ? 'asc' : 'desc';
        $subscriptions = $this->filteredQuery($request);

        if ($sort === 'email') {
            $subscriptions->orderBy('email', $direction);
        } elseif ($sort === 'time') {
            $subscriptions->orderByRaw('TIME(subscribed_at) '.$direction)->orderByDesc('subscribed_at');
        } else {
            $sort = 'date';
            $subscriptions->orderBy('subscribed_at', $direction);
        }

        return view('admin.subscriptions.index', [
            'subscriptions' => $subscriptions->paginate(10)->withQueryString(),
            'stats' => [
                'total' => Subscription::count(),
                'today' => Subscription::query()->whereDate('subscribed_at', today())->count(),
                'week' => Subscription::query()->whereBetween('subscribed_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'month' => Subscription::query()->whereBetween('subscribed_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
            ],
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    public function destroy(Subscription $subscription): RedirectResponse
    {
        $subscription->delete();

        return back()->with('success', 'Subscriber deleted successfully.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:subscriptions,id'],
        ]);

        $count = Subscription::query()->whereIn('id', $data['ids'])->delete();

        return back()->with('success', $count.' subscriber(s) deleted successfully.');
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        return response()->streamDownload(function () use ($request): void {
            $stream = fopen('php://output', 'w');
            fputcsv($stream, ['Email', 'Subscription Date', 'Subscription Time']);
            $this->filteredQuery($request)->orderByDesc('subscribed_at')->chunkById(200, function ($subscriptions) use ($stream): void {
                foreach ($subscriptions as $subscription) {
                    fputcsv($stream, [$subscription->email, $subscription->subscribed_at?->format('M j, Y'), $subscription->subscribed_at?->format('g:i A')]);
                }
            });
            fclose($stream);
        }, 'subscriptions-'.now()->format('Y-m-d-His').'.csv', ['Content-Type' => 'text/csv']);
    }

    private function filteredQuery(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $period = $request->query('period');

        return Subscription::query()
            ->when($search !== '', fn ($query) => $query->where('email', 'like', "%{$search}%"))
            ->when($period === 'today', fn ($query) => $query->whereDate('subscribed_at', today()))
            ->when($period === 'week', fn ($query) => $query->whereBetween('subscribed_at', [now()->startOfWeek(), now()->endOfWeek()]))
            ->when($period === 'month', fn ($query) => $query->whereBetween('subscribed_at', [now()->startOfMonth(), now()->endOfMonth()]));
    }
}
