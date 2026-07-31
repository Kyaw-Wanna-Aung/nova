@php $heroImageUrl = !empty($heroBanner?->image) ? \Illuminate\Support\Facades\Storage::url($heroBanner->image) : null; @endphp
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="font-display font-bold text-xl text-[var(--navy)]">Homepage Promo Banner</h2>
            <p class="text-sm text-slate-500">Hero Banner and Promotions are combined here like your template.</p>
        </div>
        <span class="hidden sm:flex items-center gap-1.5 text-xs font-medium text-[var(--navy)] bg-[#EAF3FC] px-3 py-1.5 rounded-full">Live Preview</span>
    </div>
    <div class="card overflow-hidden p-3 mb-4">
        <div class="grid lg:grid-cols-2 gap-3">
            <div class="rounded-2xl p-6 sm:p-8" style="background:var(--navy);">
                <p class="text-[11px] font-bold tracking-wider uppercase text-sky-300">{{ old('hero_category', $heroBanner?->category ?: 'SUSTAINABLE TRAVEL') }}</p>
                <h3 class="font-display font-extrabold text-3xl text-white mt-3 leading-tight">{{ old('hero_title', $heroBanner?->title ?: '20% OFF YOUR FIRST RIDE') }}</h3>
                <p class="text-white/70 text-sm mt-4 leading-relaxed">{{ old('hero_description', $heroBanner?->description ?: 'Edit your homepage promotional banner in the same premium style.') }}</p>
                <button type="button" class="mt-6 bg-white text-[var(--navy)] text-sm font-bold px-6 py-3 rounded-full">{{ old('hero_promo_code', $heroBanner?->promo_code ?: 'Claim Discount') }}</button>
            </div>
            <div class="relative rounded-2xl overflow-hidden min-h-[280px] bg-slate-100 border border-slate-200">
                @if ($heroImageUrl)
                    <img src="{{ $heroImageUrl }}" alt="Hero banner image" class="w-full h-full object-cover absolute inset-0" />
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-sm font-medium text-slate-400">No hero banner image uploaded</div>
                @endif
            </div>
        </div>
    </div>
    <div class="card p-5 mb-6">
        <form method="POST" action="{{ route('admin.hero-banner.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid lg:grid-cols-2 gap-4">
                <div><label for="hero_category" class="text-sm font-medium text-slate-600">Category Badge</label><input id="hero_category" name="hero_category" type="text" value="{{ old('hero_category', $heroBanner?->category) }}" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('hero_category') border-rose-400 @enderror" />@error('hero_category')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
                <div><label for="hero_title" class="text-sm font-medium text-slate-600">Headline</label><input id="hero_title" name="hero_title" type="text" value="{{ old('hero_title', $heroBanner?->title) }}" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('hero_title') border-rose-400 @enderror" />@error('hero_title')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
            </div>
            <div class="grid lg:grid-cols-2 gap-4">
                <div><label for="hero_promo_code" class="text-sm font-medium text-slate-600">Button Text / Promo Label</label><input id="hero_promo_code" name="hero_promo_code" type="text" value="{{ old('hero_promo_code', $heroBanner?->promo_code) }}" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('hero_promo_code') border-rose-400 @enderror" />@error('hero_promo_code')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
                <div><label for="hero_image" class="text-sm font-medium text-slate-600">Hero Image</label><input id="hero_image" name="hero_image" type="file" accept="image/png,image/jpeg,image/jpg,image/webp" class="mt-1.5 block w-full text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-[#EAF3FC] file:px-4 file:py-2 file:font-medium file:text-[var(--navy)] hover:file:bg-[#dcecff]" />@error('hero_image')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
            </div>            <div><label for="hero_description" class="text-sm font-medium text-slate-600">Description</label><textarea id="hero_description" name="hero_description" rows="3" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('hero_description') border-rose-400 @enderror">{{ old('hero_description', $heroBanner?->description) }}</textarea>@error('hero_description')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div><label for="hero_badge_1_title" class="text-sm font-medium text-slate-600">Badge 1 Title</label><input id="hero_badge_1_title" name="hero_badge_1_title" type="text" value="{{ old('hero_badge_1_title', $heroBanner?->badge_1_title) }}" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('hero_badge_1_title') border-rose-400 @enderror" />@error('hero_badge_1_title')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
                <div><label for="hero_badge_1_sub" class="text-sm font-medium text-slate-600">Badge 1 Subtitle</label><input id="hero_badge_1_sub" name="hero_badge_1_sub" type="text" value="{{ old('hero_badge_1_sub', $heroBanner?->badge_1_sub) }}" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('hero_badge_1_sub') border-rose-400 @enderror" />@error('hero_badge_1_sub')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div><label for="hero_badge_2_title" class="text-sm font-medium text-slate-600">Badge 2 Title</label><input id="hero_badge_2_title" name="hero_badge_2_title" type="text" value="{{ old('hero_badge_2_title', $heroBanner?->badge_2_title) }}" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('hero_badge_2_title') border-rose-400 @enderror" />@error('hero_badge_2_title')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
                <div><label for="hero_badge_2_sub" class="text-sm font-medium text-slate-600">Badge 2 Subtitle</label><input id="hero_badge_2_sub" name="hero_badge_2_sub" type="text" value="{{ old('hero_badge_2_sub', $heroBanner?->badge_2_sub) }}" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('hero_badge_2_sub') border-rose-400 @enderror" />@error('hero_badge_2_sub')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
            </div>
            <div class="grid lg:grid-cols-2 gap-4">
                <div><label for="hero_card_title" class="text-sm font-medium text-slate-600">Overlay Card Title</label><input id="hero_card_title" name="hero_card_title" type="text" value="{{ old('hero_card_title', $heroBanner?->card_title) }}" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('hero_card_title') border-rose-400 @enderror" />@error('hero_card_title')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
                <div><label for="hero_card_description" class="text-sm font-medium text-slate-600">Overlay Card Description</label><textarea id="hero_card_description" name="hero_card_description" rows="3" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('hero_card_description') border-rose-400 @enderror">{{ old('hero_card_description', $heroBanner?->card_description) }}</textarea>@error('hero_card_description')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
            </div>
            <div class="flex justify-end"><button type="submit" class="grad-a text-white text-sm font-semibold px-5 py-3 rounded-xl glow hover:opacity-90 transition">Update Hero Banner</button></div>
        </form>
    </div>
</div>

