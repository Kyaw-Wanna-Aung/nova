<aside id="sidebar" class="sidebar-grad fixed inset-y-0 left-0 z-40 w-72 min-h-screen text-white flex flex-col transition-transform duration-300 ease-out border-r border-white/10">
    
    {{-- Brand & Dismiss Button --}}
    <div class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
        <div class="w-10 h-10 rounded-xl grad-b flex items-center justify-center font-display font-bold text-[var(--navy)] text-lg shadow-lg shrink-0">N</div>
        <div class="min-w-0">
            <p class="font-display font-bold text-lg leading-none">NOVA</p>
            <p class="text-xs text-white/50 mt-1">EV Transport</p>
        </div>
        
        {{-- Close / Dismiss Bubble Button --}}
        <button onclick="toggleSidebar()" class="ml-auto w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-all shadow-sm shrink-0" title="Close Menu">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto scrollbar-thin">
        <p class="text-[11px] uppercase tracking-wider text-white/40 px-3 mb-2 font-semibold">Overview</p>

        {{-- Home / Dashboard --}}
        @php $routeExists = Route::has('admin.dashboard'); @endphp
        <a href="{{ $routeExists ? route('admin.dashboard') : '#' }}"
           @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
           class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.dashboard') ? 'active text-white bg-white/10' : 'text-white/80' }}
                  {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></svg>
            Home
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>

        {{-- Analytics --}}
        @php $routeExists = Route::has('admin.analytics.index'); @endphp
        <a href="{{ $routeExists ? route('admin.analytics.index') : '#' }}"
           @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
           class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.analytics.*') ? 'active text-white bg-white/10' : 'text-white/80' }}
                  {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M18 17V9M13 17V5M8 17v-4"/></svg>
            Analytics
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>

        {{-- Notification --}}
        @php $routeExists = Route::has('admin.notifications.index'); @endphp
        <a href="{{ $routeExists ? route('admin.notifications.index') : '#' }}"
           @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
           class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.notifications.*') ? 'active text-white bg-white/10' : 'text-white/80' }}
                  {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8v13H3V8M1 3h22v5H1zM10 12h4"/></svg>
            Notification
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>

        {{-- Promotion --}}
        @php $routeExists = Route::has('admin.promotions.index'); @endphp
        <a href="{{ $routeExists ? route('admin.promotions.index') : '#' }}"
           @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
           class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.promotions.*') ? 'active text-white bg-white/10' : 'text-white/80' }}
                  {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12v9H4v-9M2 7l10-5 10 5-10 5z"/><path d="M12 22V12"/></svg>
            Promotion
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>

        <p class="text-[11px] uppercase tracking-wider text-white/40 px-3 mb-2 mt-6 font-semibold">General</p>

        {{-- Routes --}}
        @php $routeExists = Route::has('admin.route-management.index'); @endphp
        <a href="{{ $routeExists ? route('admin.route-management.index') : '#' }}"
        @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
        class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium
                {{ $routeExists && request()->routeIs('admin.route-management.*') ? 'active text-white bg-white/10' : 'text-white/80' }}
                {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12h16"/><path d="M5 7l-2 2 2 2"/><path d="M19 13l2 2-2 2"/></svg>
            Routes
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>

        {{-- Drivers --}}
        @php $routeExists = Route::has('admin.drivers.index'); @endphp
        <a href="{{ $routeExists ? route('admin.drivers.index') : '#' }}"
           @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
           class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.drivers.*') ? 'active text-white bg-white/10' : 'text-white/80' }}
                  {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Drivers
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>

        {{-- Vehicles --}}
        @php $routeExists = Route::has('admin.vehicles.index'); @endphp
        <a href="{{ $routeExists ? route('admin.vehicles.index') : '#' }}"
           @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
           class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.vehicles.*') ? 'active text-white bg-white/10' : 'text-white/80' }}
                  {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 7h-9M14 17H5M17 20l3-3-3-3M7 4L4 7l3 3"/></svg>
            Vehicles
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>

        {{-- Route Schedule --}}
        @php $routeExists = Route::has('admin.route-schedules.index'); @endphp
        <a href="{{ $routeExists ? route('admin.route-schedules.index') : '#' }}"
        @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
        class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium
                {{ $routeExists && request()->routeIs('admin.route-schedules.*') ? 'active text-white bg-white/10' : 'text-white/80' }}
                {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Route Schedule
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>

        <p class="text-[11px] uppercase tracking-wider text-white/40 px-3 mb-2 mt-6 font-semibold">Manage</p>
        <div>
            <button type="button" onclick="toggleDropdown('navDropdown2', this)" class="nav-link w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-white/80">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 8h18"/><path d="M8 12h8"/><path d="M8 16h8"/></svg>
                Website
                <svg class="dropdown-chevron ml-auto transition-transform duration-200 {{ request()->routeIs('admin.testimonials.*', 'admin.faqs.*', 'admin.subscriptions.*', 'admin.vision-mission.*') ? 'rotated' : '' }}" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </button>
            <div id="navDropdown2" class="{{ request()->routeIs('admin.testimonials.*', 'admin.faqs.*', 'admin.subscriptions.*', 'admin.vision-mission.*') ? '' : 'hidden' }} pl-9 pr-1 mt-1 space-y-1">
                @php $websiteLinks = [
                    'admin.vision-mission.index' => 'Vision & Mission',
                    'admin.blog.index' => 'Blogs',
                    'admin.subscriptions.index' => 'Subscriptions',
                    'admin.faqs.index' => 'FAQ',
                    'admin.testimonials.index' => 'Testimonials',
                ]; @endphp
                @foreach ($websiteLinks as $routeName => $label)
                    @php $routeExists = Route::has($routeName); @endphp
                    <a href="{{ $routeExists ? route($routeName) : '#' }}"
                       @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
                       class="nav-link flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium
                              {{ $routeExists && request()->routeIs($routeName) ? 'active text-white' : 'text-white/70' }}
                              {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-white/40"></span>
                        {{ $label }}
                        @unless ($routeExists)
                            <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
                        @endunless
                    </a>
                @endforeach
            </div>
        </div>

        <p class="text-[11px] uppercase tracking-wider text-white/40 px-3 mb-2 mt-6 font-semibold">System</p>

        {{-- User Management Link Added Here --}}
        @php $routeExists = Route::has('admin.users.index'); @endphp
        <a href="{{ $routeExists ? route('admin.users.index') : '#' }}"
           @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
           class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.users.*') ? 'active text-white bg-white/10' : 'text-white/80' }}
                  {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            User Management
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>

        {{-- Settings --}}
        @php $routeExists = Route::has('admin.settings.index'); @endphp
        <a href="{{ $routeExists ? route('admin.settings.index') : '#' }}"
           @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
           class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.settings.*') ? 'active text-white bg-white/10' : 'text-white/80' }}
                  {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06-.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 .51 1z"/></svg>
            Settings
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>
    </nav>
</aside>