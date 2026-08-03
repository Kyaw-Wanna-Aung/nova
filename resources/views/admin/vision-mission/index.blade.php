@extends('layouts.admin')

@section('title', 'Vision & Mission')
@section('page_title', 'Vision & Mission')
@section('page_subtitle', 'Manage the vision and mission statements shown on your site.')

@push('styles')
<style>
    .input-field { transition: all .18s ease; }
    .input-field:focus { border-color: var(--sky); box-shadow: 0 0 0 4px rgba(122,185,236,.25); outline: none; }
</style>
@endpush

@section('content')
    @php
        $hasContent = filled($visionMission->vision) || filled($visionMission->mission);
        $lastUpdated = $hasContent ? 'Last updated '.$visionMission->updated_at?->format('M j, Y \a\t g:i A') : 'Not updated yet.';
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl grad-a flex items-center justify-center shrink-0"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
                <div><h3 class="font-display font-bold text-lg text-[var(--navy)]">Our Vision</h3><p class="text-sm text-slate-500">The long-term future NOVA is working toward.</p></div>
            </div>
            <form method="POST" action="{{ route('admin.vision-mission.update') }}" class="p-5 sm:p-6 space-y-4">
                @csrf @method('PUT')<input type="hidden" name="section" value="vision">
                <div><label for="visionText" class="text-sm font-medium text-slate-600">Vision statement</label><textarea id="visionText" name="vision" rows="8" placeholder="Write your vision statement here..." class="input-field mt-1.5 w-full border {{ $errors->has('vision') ? 'border-rose-400' : 'border-slate-200' }} rounded-xl px-3.5 py-2.5 text-sm outline-none resize-none scrollbar-thin">{{ old('section') === 'vision' ? old('vision') : $visionMission->vision }}</textarea>@error('vision')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
                <div class="flex items-center justify-between"><p class="text-xs text-slate-400">{{ $lastUpdated }}</p><button type="submit" class="grad-a text-white text-sm font-semibold px-5 py-2.5 rounded-xl glow hover:opacity-90 transition flex items-center gap-2"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8M7 3v5h8"/></svg>Update Vision</button></div>
            </form>
        </div>

        <div class="card overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl grad-a flex items-center justify-center shrink-0"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M12 2l3 7h7l-5.5 4.5L18.5 22 12 17l-6.5 5 2-8.5L2 9h7z"/></svg></div>
                <div><h3 class="font-display font-bold text-lg text-[var(--navy)]">Our Mission</h3><p class="text-sm text-slate-500">What NOVA does every day to get there.</p></div>
            </div>
            <form method="POST" action="{{ route('admin.vision-mission.update') }}" class="p-5 sm:p-6 space-y-4">
                @csrf @method('PUT')<input type="hidden" name="section" value="mission">
                <div><label for="missionText" class="text-sm font-medium text-slate-600">Mission statement</label><textarea id="missionText" name="mission" rows="8" placeholder="Write your mission statement here..." class="input-field mt-1.5 w-full border {{ $errors->has('mission') ? 'border-rose-400' : 'border-slate-200' }} rounded-xl px-3.5 py-2.5 text-sm outline-none resize-none scrollbar-thin">{{ old('section') === 'mission' ? old('mission') : $visionMission->mission }}</textarea>@error('mission')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
                <div class="flex items-center justify-between"><p class="text-xs text-slate-400">{{ $lastUpdated }}</p><button type="submit" class="grad-a text-white text-sm font-semibold px-5 py-2.5 rounded-xl glow hover:opacity-90 transition flex items-center gap-2"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8M7 3v5h8"/></svg>Update Mission</button></div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    @if (session('success')) showToast(@json(session('success'))); @endif
</script>
@endpush
