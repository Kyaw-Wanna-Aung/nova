@extends('layouts.admin')

@section('title', 'Promotions')
@section('page_title', 'Promotions')
@section('page_subtitle', 'Manage your promotional deals and seasonal routes.')

@push('styles')
<style>
    .price-tag .original { text-decoration: line-through; color: #94a3b8; font-weight: 400; margin-right: 6px; }
    .price-tag .discounted { color: #dc2626; font-weight: 700; }
    #modalPanel { transition: transform 0.2s ease, opacity 0.2s ease; transform: scale(0.95); opacity: 0; }
    #modalPanel.scale-100 { transform: scale(1); opacity: 1; }
</style>
@endpush

@section('content')
    @php
        $openCreateModal = $errors->any() && old('form_context') === 'create';
        $editPromoId = null;
        if ($errors->any() && old('form_context') && is_string(old('form_context')) && str_starts_with(old('form_context'), 'edit_')) {
            $editPromoId = (int) substr(old('form_context'), 5);
        }
    @endphp

    @include('admin.promotions.partials.hero-banner')


    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-4">
            <div>
                <h2 class="font-display font-bold text-xl text-[var(--navy)]">Seasonal Routes &amp; Deals</h2>
                <p class="text-sm text-slate-500">Explore Myanmar's most iconic journeys with special seasonal rates.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <form method="GET" action="{{ route('admin.promotions.index') }}" class="flex flex-wrap items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title, description, duration, or departures..." class="w-full sm:w-80 bg-white border border-slate-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-[var(--sky)] placeholder:text-slate-400" />
                    <select name="per_page" class="text-sm border border-slate-200 rounded-lg px-3 py-2.5 outline-none text-slate-600 bg-white">
                        @foreach ([6, 9, 12, 18] as $size)
                            <option value="{{ $size }}" {{ (int) request('per_page', 9) === $size ? 'selected' : '' }}>{{ $size }} / page</option>
                        @endforeach
                    </select>
                    <button type="submit" class="border border-slate-200 text-slate-600 text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-slate-50 transition">Filter</button>
                    <a href="{{ route('admin.promotions.index') }}" class="text-sm font-medium text-slate-400 hover:text-[var(--navy)] px-2">Clear</a>
                </form>
                <button type="button" onclick="openModal()" class="flex items-center gap-2 grad-a text-white text-sm font-semibold px-4 py-2.5 rounded-lg glow hover:opacity-90 transition">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                    Add Promotion
                </button>
            </div>
        </div>
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
            <div class="card p-4"><p class="text-xs text-slate-400 font-medium">Total Promotions</p><p class="text-xl font-display font-bold text-[var(--navy)] mt-1">{{ number_format($stats['total'] ?? 0) }}</p></div>
            <div class="card p-4"><p class="text-xs text-slate-400 font-medium">With Images</p><p class="text-xl font-display font-bold text-sky-600 mt-1">{{ number_format($stats['with_images'] ?? 0) }}</p></div>
            <div class="card p-4"><p class="text-xs text-slate-400 font-medium">Best Saving</p><p class="text-xl font-display font-bold text-emerald-600 mt-1">{{ number_format($stats['max_saving'] ?? 0, 2) }}</p></div>
            <div class="card p-4"><p class="text-xs text-slate-400 font-medium">Avg Discount</p><p class="text-xl font-display font-bold text-amber-600 mt-1">{{ round($stats['average_discount_percent'] ?? 0) }}%</p></div>
        </div>
    </div>


    @if ($promotions->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center card">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" class="mb-3"><path d="M20 12v9H4v-9M2 7l10-5 10 5-10 5z"/><path d="M12 22V12"/></svg>
            <p class="font-semibold text-slate-500">No promotions match your filters</p>
            <p class="text-sm text-slate-400 mt-1">Try a different search term or clear filters.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
            @foreach ($promotions as $promotion)
                @php
                    $isEditingThis = $editPromoId === $promotion->id;
                    $imageUrl = $promotion->image ? asset('storage/'.$promotion->image) : null;
                    $saving = max((float)$promotion->original_price - (float)$promotion->discounted_price, 0);
                @endphp

                <article class="card p-4 flex flex-col {{ $isEditingThis ? 'ring-2 ring-[var(--sky)]/30 border-[var(--sky)]' : '' }}">

                    <div class="promo-display {{ $isEditingThis ? 'hidden' : '' }}">
                        @if ($imageUrl)
                            <img src="{{ $imageUrl }}" alt="{{ $promotion->title }}" class="w-full h-36 object-cover rounded-xl" />
                        @else
                            <div class="w-full h-36 rounded-xl bg-[#F1F4F8] flex items-center justify-center text-slate-300">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                            </div>
                        @endif

                        <p class="font-display font-bold text-[16px] text-[var(--navy)] mt-3">{{ $promotion->title }}</p>
                        <p class="text-sm text-slate-500">{{ $promotion->description ?: 'No description added yet.' }}</p>

                        @if ($promotion->duration)
                            <p class="text-sm text-slate-500 mt-1">{{ $promotion->duration }}</p>
                        @endif

                        @if ($promotion->daily_departures)
                            <p class="text-sm text-slate-500 mt-1">Daily Departures: {{ $promotion->daily_departures }}</p>
                        @endif

                        <div class="price-tag text-base mt-2">
                            <span class="original">{{ number_format((float) $promotion->original_price, 2) }} MMK</span>
                            <span class="discounted">{{ number_format((float) $promotion->discounted_price, 2) }} MMK</span>
                        </div>

                        <div class="mt-3 flex items-center justify-between text-xs text-slate-400">
                            <span>Updated {{ optional($promotion->updated_at)->format('M j, Y') }}</span>
                            <span>{{ $saving > 0 ? number_format($saving, 2).' MMK saved' : 'No saving' }}</span>
                        </div>

                        <div class="mt-3 flex items-center justify-end gap-1">
                            <button type="button" onclick="enterEditMode({{ $promotion->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-[var(--navy)] hover:bg-slate-100 transition" title="Update">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                            </button>
                            <button type="button" onclick="confirmDelete({{ $promotion->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition" title="Delete">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6"/></svg>
                            </button>
                        </div>
                    </div>


                    <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}" class="promo-edit-form {{ $isEditingThis ? '' : 'hidden' }}" data-promotion-id="{{ $promotion->id }}" onsubmit="return validateInlineEdit(this)">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="form_context" value="edit_{{ $promotion->id }}" />

                        @if ($imageUrl)
                            <img src="{{ $imageUrl }}" alt="{{ $promotion->title }}" class="w-full h-36 object-cover rounded-xl" />
                        @else
                            <div class="w-full h-36 rounded-xl bg-[#F1F4F8] flex items-center justify-center text-slate-300">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                            </div>
                        @endif

                        <div class="mt-3 space-y-3">
                            <div>
                                <label class="text-xs font-medium text-slate-500">Title</label>
                                <input type="text" name="title" value="{{ old('title', $promotion->title) }}" class="edit-title-input mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm font-bold text-[var(--navy)] outline-none @error('title') border-rose-400 @enderror" placeholder="Promotion title" required />
                                @error('title')
                                    @if (old('form_context') === 'edit_' . $promotion->id)
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @endif
                                @enderror
                            </div>

                            <div>
                                <label class="text-xs font-medium text-slate-500">Description</label>
                                <textarea name="description" rows="2" class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none resize-none @error('description') border-rose-400 @enderror" placeholder="Describe the promotion...">{{ old('description', $promotion->description) }}</textarea>
                                @error('description')
                                    @if (old('form_context') === 'edit_' . $promotion->id)
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @endif
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-medium text-slate-500">Duration</label>
                                    <input type="text" name="duration" value="{{ old('duration', $promotion->duration) }}" class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none" placeholder="e.g. 8-9 Hours" />
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-slate-500">Daily Departures</label>
                                    <input type="text" name="daily_departures" value="{{ old('daily_departures', $promotion->daily_departures) }}" class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none" placeholder="e.g. 8:00 AM, 9:00 PM" />
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-medium text-slate-500">Original Price</label>
                                    <input type="number" name="original_price" value="{{ old('original_price', $promotion->original_price) }}" class="edit-original-input mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none @error('original_price') border-rose-400 @enderror" placeholder="45000" min="0" step="0.01" required />
                                    @error('original_price')
                                        @if (old('form_context') === 'edit_' . $promotion->id)
                                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                        @endif
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-slate-500">Discounted Price</label>
                                    <input type="number" name="discounted_price" value="{{ old('discounted_price', $promotion->discounted_price) }}" class="edit-discounted-input mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none @error('discounted_price') border-rose-400 @enderror" placeholder="38500" min="0" step="0.01" required />
                                    @error('discounted_price')
                                        @if (old('form_context') === 'edit_' . $promotion->id)
                                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                        @endif
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <button type="button" onclick="exitEditMode({{ $promotion->id }})" class="flex-1 border border-slate-200 text-slate-600 text-sm font-semibold py-2.5 rounded-lg hover:bg-slate-50 transition">Cancel</button>
                            <button type="submit" class="flex-1 grad-a text-white text-sm font-semibold py-2.5 rounded-lg glow hover:opacity-90 transition">Save</button>
                        </div>
                    </form>
                </article>
            @endforeach
        </div>


        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-6">
            <p class="text-sm text-slate-500">Showing {{ $promotions->firstItem() }}-{{ $promotions->lastItem() }} of {{ $promotions->total() }} promotions</p>
            <div>{{ $promotions->links() }}</div>
        </div>

        @foreach ($promotions as $promotion)
            <form id="delete-form-{{ $promotion->id }}" method="POST" action="{{ route('admin.promotions.destroy', $promotion) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif


    <div id="modalOverlay" class="fixed inset-0 z-50 items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm {{ $openCreateModal ? 'flex' : 'hidden' }}">
        <div id="modalPanel" class="bg-white rounded-2xl w-full max-w-lg shadow-2xl {{ $openCreateModal ? 'scale-100' : 'scale-95 opacity-0' }}">
            <div class="flex items-start justify-between px-6 pt-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl grad-a flex items-center justify-center shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M20 12v9H4v-9M2 7l10-5 10 5-10 5z"/><path d="M12 22V12"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-lg text-[var(--navy)]">Add Promotion</h3>
                        <p class="text-sm text-slate-500">Create a new seasonal route deal</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.promotions.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_context" value="create" />

                <div class="px-6 py-5 space-y-4 max-h-[70vh] overflow-y-auto scrollbar-thin">
                    <div>
                        <label class="text-sm font-medium text-slate-600">Image</label>
                        <div class="mt-1.5 flex items-center gap-4">
                            <img id="createImagePreview" src="" class="hidden w-20 h-20 rounded-xl object-cover border border-slate-200" />
                            <div id="createImagePlaceholder" class="w-20 h-20 rounded-xl bg-[#F1F4F8] flex items-center justify-center border border-dashed border-slate-300 text-slate-300">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                            </div>
                            <div class="flex-1">
                                <input id="createImageInput" name="image" type="file" accept="image/png,image/jpeg,image/jpg,image/webp" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none bg-white file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-[#E9F2FC] file:text-[var(--navy)] file:text-xs file:font-semibold @error('image') border-rose-400 @enderror" />
                                <p class="text-xs text-slate-400 mt-1">Upload a promotional banner image.</p>
                                @error('image')
                                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="create_title" class="text-sm font-medium text-slate-600">Promotion Title</label>
                        <input id="create_title" name="title" type="text" value="{{ old('title') }}" placeholder="e.g. Yangon to Mandalay" class="mt-1.5 w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none @error('title') border-rose-400 @enderror" />
                        @error('title')
                            @if (old('form_context') === 'create')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @endif
                        @enderror
                    </div>

                    <div>
                        <label for="create_description" class="text-sm font-medium text-slate-600">Description</label>
                        <textarea id="create_description" name="description" rows="3" placeholder="Describe the promotion..." class="mt-1.5 w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none resize-none @error('description') border-rose-400 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            @if (old('form_context') === 'create')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @endif
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-slate-600">Original Price (MMK)</label>
                            <input name="original_price" type="number" min="0" step="0.01" value="{{ old('original_price') }}" placeholder="45000" class="mt-1.5 w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none @error('original_price') border-rose-400 @enderror" />
                            @error('original_price')
                                @if (old('form_context') === 'create')
                                    <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                                @endif
                            @enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600">Discounted Price (MMK)</label>
                            <input name="discounted_price" type="number" min="0" step="0.01" value="{{ old('discounted_price') }}" placeholder="38500" class="mt-1.5 w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none @error('discounted_price') border-rose-400 @enderror" />
                            @error('discounted_price')
                                @if (old('form_context') === 'create')
                                    <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                                @endif
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-600">Duration</label>
                        <input name="duration" type="text" value="{{ old('duration') }}" placeholder="e.g. 8-9 Hours Journey" class="mt-1.5 w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none" />
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-600">Daily Departures</label>
                        <input name="daily_departures" type="text" value="{{ old('daily_departures') }}" placeholder="e.g. 8:00 AM, 9:00 PM" class="mt-1.5 w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm outline-none" />
                    </div>
                </div>

                <div class="flex items-center gap-3 px-6 py-4 border-t border-slate-100 bg-[#FBFCFD] rounded-b-2xl">
                    <button type="button" onclick="closeModal()" class="flex-1 border border-slate-200 text-slate-600 text-sm font-semibold py-2.5 rounded-lg hover:bg-slate-50 transition">Cancel</button>
                    <button type="submit" class="flex-1 grad-a text-white text-sm font-semibold py-2.5 rounded-lg glow hover:opacity-90 transition">Create</button>
                </div>
            </form>
        </div>
    </div>

@endsection


@push('scripts')
<script>
    const modalOverlay = document.getElementById('modalOverlay');
    const modalPanel = document.getElementById('modalPanel');

    function openModal() {
        modalOverlay.classList.remove('hidden');
        modalOverlay.classList.add('flex');
        requestAnimationFrame(() => {
            modalPanel.classList.add('scale-100');
            modalPanel.classList.remove('opacity-0');
        });
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('create_title').focus(), 150);
    }

    function closeModal() {
        modalPanel.classList.remove('scale-100');
        modalPanel.classList.add('opacity-0');
        document.body.style.overflow = '';
        setTimeout(() => {
            modalOverlay.classList.add('hidden');
            modalOverlay.classList.remove('flex');
        }, 200);
    }

    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) closeModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modalOverlay.classList.contains('hidden')) closeModal();
    });

    const createImageInput = document.getElementById('createImageInput');
    const createImagePreview = document.getElementById('createImagePreview');
    const createImagePlaceholder = document.getElementById('createImagePlaceholder');

    if (createImageInput) {
        createImageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => {
                createImagePreview.src = ev.target.result;
                createImagePreview.classList.remove('hidden');
                createImagePlaceholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        });
    }

    function enterEditMode(promoId) {
        const article = document.querySelector(`article:has(.promo-edit-form[data-promotion-id="${promoId}"])`);
        if (!article) return;

        const display = article.querySelector('.promo-display');
        const editForm = article.querySelector(`.promo-edit-form[data-promotion-id="${promoId}"]`);

        if (display) display.classList.add('hidden');
        if (editForm) editForm.classList.remove('hidden');

        article.classList.add('ring-2', 'ring-[var(--sky)]/30', 'border-[var(--sky)]');

        setTimeout(() => {
            const titleInput = editForm.querySelector('.edit-title-input');
            if (titleInput) titleInput.focus();
        }, 50);
    }

    function exitEditMode(promoId) {
        const article = document.querySelector(`article:has(.promo-edit-form[data-promotion-id="${promoId}"])`);
        if (!article) return;

        const display = article.querySelector('.promo-display');
        const editForm = article.querySelector(`.promo-edit-form[data-promotion-id="${promoId}"]`);

        if (display) display.classList.remove('hidden');
        if (editForm) editForm.classList.add('hidden');

        article.classList.remove('ring-2', 'ring-[var(--sky)]/30', 'border-[var(--sky)]');
    }

    function validateInlineEdit(form) {
        let valid = true;

        const titleInput = form.querySelector('input[name="title"]');
        const originalInput = form.querySelector('input[name="original_price"]');
        const discountedInput = form.querySelector('input[name="discounted_price"]');

        [titleInput, originalInput, discountedInput].forEach(input => {
            if (input) input.classList.remove('border-rose-400');
        });

        if (!titleInput || !titleInput.value.trim()) {
            if (titleInput) {
                titleInput.classList.add('border-rose-400');
                titleInput.focus();
            }
            valid = false;
        }

        if (!originalInput || !originalInput.value || Number(originalInput.value) <= 0) {
            if (originalInput) {
                originalInput.classList.add('border-rose-400');
                if (valid) originalInput.focus();
            }
            valid = false;
        }

        if (!discountedInput || !discountedInput.value || Number(discountedInput.value) <= 0) {
            if (discountedInput) {
                discountedInput.classList.add('border-rose-400');
                if (valid) discountedInput.focus();
            }
            valid = false;
        }

        if (valid && originalInput && discountedInput) {
            if (Number(discountedInput.value) > Number(originalInput.value)) {
                discountedInput.classList.add('border-rose-400');
                discountedInput.focus();
                alert('Discounted price must be less than or equal to the original price.');
                valid = false;
            }
        }

        return valid;
    }

    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this promotion? This action cannot be undone.")) {
            const form = document.getElementById(`delete-form-${id}`);
            if (form) form.submit();
        }
    }

    @if ($openCreateModal)
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.overflow = 'hidden';
            requestAnimationFrame(() => {
                modalPanel.classList.add('scale-100');
                modalPanel.classList.remove('opacity-0');
            });
        });
    @endif
</script>
@endpush

