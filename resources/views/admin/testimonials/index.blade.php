@extends('layouts.admin')

@section('content')
<div class="flex gap-6">
<div class="flex-1 space-y-6">
<header class="flex items-center justify-between flex-wrap gap-3">
    <div>
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Testimonials</h1>
        <p class="mt-2 text-slate-500">Manage customer stories, reviews, and featured endorsements.</p>
    </div>
    <button id="newTestimonialBtn" class="flex items-center gap-2 grad-a text-white text-sm font-semibold px-4 py-2.5 rounded-lg glow hover:opacity-90 transition">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        Add Testimonial
    </button>
</header>

@if(session('success'))
<div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 flex items-center gap-3 shadow-sm"><span class="text-xl">✓</span><div>{{ session('success') }}</div></div>
@endif

<div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-5 border-b border-slate-200">
        <form method="GET" class="flex flex-wrap items-center gap-3">
            <input name="search" value="{{ request('search') }}" placeholder="Search by customer name or role..." class="w-72 rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500">
            <select name="status" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500">
                <option value="">All Statuses</option>
                <option value="Active" @selected(request('status')==='Active')>Active</option>
                <option value="Inactive" @selected(request('status')==='Inactive')>Inactive</option>
            </select>
            <div class="flex items-center gap-2">
                <button class="btn-secondary rounded-xl px-4 py-2.5 text-sm font-semibold border border-slate-300">Filter</button>
                <a href="{{ route('admin.testimonials.index') }}" class="text-sm text-slate-600 underline-offset-4 hover:underline">Reset</a>
            </div>
        </form>
        <p class="text-sm text-slate-500">{{ $testimonials->total() }} total</p>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500 font-semibold uppercase tracking-wide text-xs">
                <tr>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Rating</th>
                    <th class="px-6 py-4">Message</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Order</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($testimonials as $testimonial)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-4"><div class="flex items-center gap-3">
                        @if($testimonial->photo_url)
                            <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="h-11 w-11 rounded-full object-cover ring-1 ring-slate-200">
                        @else
                            <div class="h-11 w-11 rounded-full bg-sky-100 text-sky-800 grid place-items-center font-bold">{{ mb_strtoupper(mb_substr($testimonial->name, 0, 1)) }}</div>
                        @endif
                        <div class="font-semibold text-slate-900">{{ $testimonial->name }}</div>
                    </div></td>
                    <td class="px-6 py-4">{{ $testimonial->role }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-amber-500">
                            @for($s = 1; $s <= 5; $s++)
                                @if($s <= $testimonial->rating)
                                    ★
                                @else
                                    <span class="text-slate-200">★</span>
                                @endif
                            @endfor
                        </span>
                        <span class="ml-2 text-xs text-slate-500">({{ $testimonial->rating }}/5)</span>
                    </td>
                    <td class="px-6 py-4 max-w-md"><p class="line-clamp-2 italic text-slate-600">{{ str($testimonial->message)->limit(90) }}</p></td>
                    <td class="px-6 py-4">
                        <form method="POST" action="{{ route('admin.testimonials.status', $testimonial) }}">@csrf @method('PATCH')
                            <button type="submit" class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $testimonial->status === 'Active' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-slate-100 text-slate-600 ring-1 ring-slate-200' }}">{{ $testimonial->status }}</button>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-slate-500">{{ $testimonial->display_order ?? '-' }}</td>
                    <td class="px-6 py-4 text-right"><div class="inline-flex items-center gap-2 justify-end">
                        <button type="button" onclick='editTestimonial(@json($testimonial))' class="inline-flex items-center rounded-lg px-3 py-2 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700">Edit</button>
                        <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Delete testimonial from {{ $testimonial->name }}?')">@csrf @method('DELETE')
                            <button class="inline-flex items-center rounded-lg px-3 py-2 text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 ring-1 ring-rose-200/60">Delete</button>
                        </form>
                    </div></td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-16 text-center text-slate-500">No testimonials found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-slate-200">{{ $testimonials->withQueryString()->links() }}</div>
</div>
</div>

</div>

<div id="tModal" class="fixed inset-0 z-50 hidden"><div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" data-close-t></div><div class="fixed inset-0 grid place-items-center p-4"><div class="relative w-full max-w-2xl rounded-2xl bg-white shadow-2xl">
    <form method="POST" action="{{ route('admin.testimonials.store') }}" id="tForm" enctype="multipart/form-data" class="max-h-[88vh] overflow-y-auto">
        @csrf
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 sticky top-0 bg-white">
            <h3 id="tModalTitle" class="text-lg font-bold text-slate-900">Add Testimonial</h3>
            <button type="button" data-close-t class="text-slate-400 hover:text-slate-700 text-2xl leading-none">&times;</button>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-1"><label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-2">Customer Name</label><input id="tName" name="name" value="{{ old('name') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500" required>@error('name')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
            <div class="md:col-span-1"><label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-2">Role / Designation</label><input id="tRole" name="role" value="{{ old('role') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500" required>@error('role')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
            <div class="md:col-span-1"><label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-2">Customer Photo</label><input id="tImage" name="image" type="file" accept="image/*" class="w-full text-sm text-slate-700 file:mr-3 file:rounded-xl file:border-0 file:bg-sky-50 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-sky-800">
                <div id="tImagePreview" class="mt-3 flex items-center gap-3 text-xs text-slate-500"></div>
                @error('image')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-1"><label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-2">Rating</label>
                <div id="tRatingPicker" class="flex items-center gap-2 text-3xl text-amber-400 select-none cursor-pointer" data-value="{{ old('rating', 5) }}"></div>
                <input type="hidden" id="tRating" name="rating" value="{{ old('rating', 5) }}">
                @error('rating')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2"><label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-2">Testimonial Message</label><textarea id="tMessage" name="message" rows="5" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500" required>{{ old('message') }}</textarea>@error('message')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
            <div class="md:col-span-1"><label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-2">Status</label>
                <select name="status" id="tStatus" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500">
                    <option value="Active" @selected(old('status', 'Active') === 'Active')>Active</option>
                    <option value="Inactive" @selected(old('status', 'Active') === 'Inactive')>Inactive</option>
                </select>
                @error('status')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-1"><label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-2">Display Order</label><input id="tOrder" name="display_order" type="number" min="0" value="{{ old('display_order') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500" placeholder="Optional">@error('display_order')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
        </div>
        <div class="flex items-center justify-end gap-3 border-t border-slate-100 px-6 py-4 bg-slate-50/60 sticky bottom-0">
            <button type="button" data-close-t class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-white">Cancel</button>
            <button type="submit" id="tSubmitBtn" class="grad-a text-white text-sm font-semibold px-5 py-2.5 rounded-lg glow hover:opacity-90 transition">Save Testimonial</button>
        </div>
    </form>
</div></div></div>
@endsection

@push('scripts')
<script>
const tModal = document.getElementById('tModal');
const tForm = document.getElementById('tForm');
const tTitle = document.getElementById('tModalTitle');
const tSubmit = document.getElementById('tSubmitBtn');
const tFields = {
    name: document.getElementById('tName'),
    role: document.getElementById('tRole'),
    image: document.getElementById('tImage'),
    imagePreview: document.getElementById('tImagePreview'),
    message: document.getElementById('tMessage'),
    rating: document.getElementById('tRating'),
    status: document.getElementById('tStatus'),
    order: document.getElementById('tOrder'),
};

function openTestimonial() {
    resetTestimonial();
    tTitle.textContent = 'Add Testimonial';
    tSubmit.textContent = 'Save Testimonial';
    tForm.method = 'POST';
    tForm.action = '{{ route('admin.testimonials.store') }}';
    var m = tForm.querySelector('input[name="_method"]'); if (m) m.remove();
    tModal.classList.remove('hidden');
}

function editTestimonial(t) {
    resetTestimonial();
    tTitle.textContent = 'Edit Testimonial';
    tSubmit.textContent = 'Update Testimonial';
    tForm.action = '/admin/testimonials/' + t.id;
    var m = tForm.querySelector('input[name="_method"]');
    if (!m) { m = document.createElement('input'); m.type='hidden'; m.name='_method'; tForm.prepend(m); }
    m.value = 'PUT';
    tFields.name.value = t.name || '';
    tFields.role.value = t.role || '';
    tFields.message.value = t.message || '';
    tFields.rating.value = t.rating || 5;
    renderStars(Number(tFields.rating.value));
    tFields.status.value = t.status || 'Active';
    tFields.order.value = t.display_order || '';
    if (t.photo_url) {
        tFields.imagePreview.innerHTML = '<img src="' + t.photo_url + '" class="h-12 w-12 rounded-lg object-cover ring-1 ring-slate-200" alt="current"><span>Current photo (leave blank to keep)</span>';
    }
    tModal.classList.remove('hidden');
}

function resetTestimonial() {
    tForm.reset();
    tFields.rating.value = 5;
    renderStars(5);
    tFields.imagePreview.innerHTML = '';
    var es = tForm.querySelectorAll('.text-rose-600');
    for (var i=0; i<es.length; i++) es[i].remove();
}

document.getElementById('newTestimonialBtn').addEventListener('click', openTestimonial);
var cls = document.querySelectorAll('[data-close-t]');
for (var j=0; j<cls.length; j++) cls[j].addEventListener('click', function(){ tModal.classList.add('hidden'); });

var picker = document.getElementById('tRatingPicker');
function renderStars(value) {
    picker.innerHTML = '';
    for (var i=1;i<=5;i++) {
        var btn = document.createElement('span');
        btn.className = 'star-btn transition-transform hover:scale-110';
        btn.style.color = i <= value ? '#f59e0b' : '#e2e8f0';
        btn.textContent = '★';
        (function(idx){ btn.addEventListener('click', function(){ tFields.rating.value = idx; renderStars(idx); }); })(i);
        picker.appendChild(btn);
    }
}
renderStars(Number(picker.dataset.value || 5));
</script>
@endpush