@extends('layouts.admin')

@section('title', 'Testimonials')
@section('page_title', 'Testimonials')
@section('page_subtitle', 'Collect and showcase feedback from your customers.')

@push('styles')
<style>
    .star-btn{transition:transform .1s ease;}
    .star-btn:hover{transform:scale(1.15);}
</style>
@endpush

@section('content')
    @php
        $isEditing = isset($selectedTestimonial);
        $formTestimonial = $selectedTestimonial ?? new \App\Models\Testimonial(['status' => 'Active']);
        $selectedRating = (int) old('rating', $formTestimonial->rating ?? 0);
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="card p-6 lg:col-span-1 h-fit">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl grad-a flex items-center justify-center shrink-0">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div>
                    <h3 class="font-display font-bold text-lg text-[var(--navy)]">{{ $isEditing ? 'Edit Testimonial' : 'Add Testimonial' }}</h3>
                    <p class="text-sm text-slate-500">Share what a customer said.</p>
                </div>
            </div>

            <form method="POST" action="{{ $isEditing ? route('admin.testimonials.update', $formTestimonial) : route('admin.testimonials.store') }}" novalidate>
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif

                <div class="space-y-4">
                    <div>
                        <label for="tName" class="text-sm font-medium text-slate-600">Name</label>
                        <input id="tName" name="name" type="text" value="{{ old('name', $formTestimonial->name) }}" placeholder="e.g. Priya Nair" class="input-field mt-1.5 w-full border {{ $errors->has('name') ? 'border-rose-400' : 'border-slate-200' }} rounded-xl px-3.5 py-2.5 text-sm outline-none" />
                        @error('name')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="tRole" class="text-sm font-medium text-slate-600">Role</label>
                        <input id="tRole" name="role" type="text" value="{{ old('role', $formTestimonial->role) }}" placeholder="e.g. Daily Commuter" class="input-field mt-1.5 w-full border {{ $errors->has('role') ? 'border-rose-400' : 'border-slate-200' }} rounded-xl px-3.5 py-2.5 text-sm outline-none" />
                        @error('role')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-600">Star rating</label>
                        <div id="starPicker" class="mt-1.5 flex items-center gap-1" role="radiogroup" aria-label="Star rating">
                            @foreach (range(1, 5) as $star)
                                <button type="button" class="star-btn" data-star="{{ $star }}" aria-label="{{ $star }} star{{ $star > 1 ? 's' : '' }}">
                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="{{ $star <= $selectedRating ? '#f59e0b' : 'none' }}" stroke="#f59e0b" stroke-width="1.5"><polygon points="12 2 15 9 22 9.5 17 14.5 18.5 22 12 18 5.5 22 7 14.5 2 9.5 9 9"/></svg>
                                </button>
                            @endforeach
                            <span id="ratingLabel" class="ml-2 text-sm font-semibold text-slate-500">{{ $selectedRating }} / 5</span>
                        </div>
                        <input id="tRating" name="rating" type="hidden" value="{{ $selectedRating }}" />
                        @error('rating')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="tMessage" class="text-sm font-medium text-slate-600">Message</label>
                        <textarea id="tMessage" name="message" rows="5" placeholder="What did the customer say?" class="input-field mt-1.5 w-full border {{ $errors->has('message') ? 'border-rose-400' : 'border-slate-200' }} rounded-xl px-3.5 py-2.5 text-sm outline-none resize-none">{{ old('message', $formTestimonial->message) }}</textarea>
                        @error('message')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-5">
                    @if ($isEditing)
                        <a href="{{ route('admin.testimonials.index', request()->only('search', 'page')) }}" class="flex-1 border border-slate-200 text-center text-slate-600 text-sm font-semibold py-2.5 rounded-xl hover:bg-slate-50 transition">Cancel</a>
                    @endif
                    <button type="submit" class="flex-1 grad-a text-white text-sm font-semibold py-2.5 rounded-xl glow hover:opacity-90 transition">{{ $isEditing ? 'Save changes' : 'Add Testimonial' }}</button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-2">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <p class="text-sm font-medium text-slate-500">{{ $testimonials->total() }} testimonial(s)</p>
                <form method="GET" action="{{ route('admin.testimonials.index') }}" class="relative w-full sm:w-64">
                    <input name="search" value="{{ $search }}" type="search" placeholder="Search name or role..." class="input-field w-full border border-slate-200 rounded-xl pl-9 pr-3 py-2 text-sm outline-none" />
                    <svg class="absolute left-3 top-2.5 text-slate-400" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                </form>
            </div>

            @if ($testimonials->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @foreach ($testimonials as $testimonial)
                        <article class="card p-5 flex flex-col {{ $testimonial->status === 'Inactive' ? 'opacity-70' : '' }}">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="font-display font-bold text-[var(--navy)] truncate">{{ $testimonial->name }}</p>
                                    <p class="text-sm text-slate-500 truncate">{{ $testimonial->role }}</p>
                                </div>
                                <div class="flex items-center gap-0.5 shrink-0" aria-label="{{ $testimonial->rating }} out of 5 stars">
                                    @foreach (range(1, 5) as $star)
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="{{ $star <= $testimonial->rating ? '#f59e0b' : 'none' }}" stroke="#f59e0b" stroke-width="1.5"><polygon points="12 2 15 9 22 9.5 17 14.5 18.5 22 12 18 5.5 22 7 14.5 2 9.5 9 9"/></svg>
                                    @endforeach
                                </div>
                            </div>
                            <p class="text-sm text-slate-600 mt-3 leading-relaxed flex-1">&ldquo;{{ $testimonial->message }}&rdquo;</p>
                            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                                <form method="POST" action="{{ route('admin.testimonials.status', $testimonial) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1.5 rounded-lg {{ $testimonial->status === 'Active' ? 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }} transition" title="Change status">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $testimonial->status === 'Active' ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>{{ $testimonial->status }}
                                    </button>
                                </form>
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.testimonials.edit', array_merge([$testimonial], request()->only('search', 'page'))) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-[var(--navy)] hover:bg-slate-100" title="Edit" aria-label="Edit {{ $testimonial->name }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/></svg></a>
                                    <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Are you sure you want to delete this testimonial? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50" title="Delete" aria-label="Delete {{ $testimonial->name }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6"/></svg></button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $testimonials->links() }}
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-16 text-center card mt-2">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" class="mb-3"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <p class="font-semibold text-slate-500">{{ $search !== '' ? 'No matching testimonials' : 'No testimonials yet' }}</p>
                    <p class="text-sm text-slate-400 mt-1">{{ $search !== '' ? 'Try a different name or role.' : 'Use the form to add your first testimonial.' }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('#starPicker .star-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const rating = Number(this.dataset.star);
            document.querySelectorAll('#starPicker .star-btn svg').forEach(function (star, index) {
                star.setAttribute('fill', index < rating ? '#f59e0b' : 'none');
            });
            document.getElementById('tRating').value = rating;
            document.getElementById('ratingLabel').textContent = rating + ' / 5';
        });
    });

    @if (session('success'))
        showToast(@json(session('success')));
    @endif
</script>
@endpush
