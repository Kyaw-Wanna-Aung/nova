<aside id="sidebar" class="sidebar-grad fixed lg:static z-40 w-72 min-h-screen text-white flex flex-col transition-transform duration-300 ease-out">
    <div class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
        <div class="w-10 h-10 rounded-xl grad-b flex items-center justify-center font-display font-bold text-[var(--navy)] text-lg shadow-lg">N</div>
        <div>
            <p class="font-display font-bold text-lg leading-none">NOVA</p>
            <p class="text-xs text-white/50 mt-1">EV Transport</p>
        </div>
        <button onclick="toggleSidebar()" class="ml-auto lg:hidden text-white/70 hover:text-white">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto scrollbar-thin">
        <p class="text-[11px] uppercase tracking-wider text-white/40 px-3 mb-2 font-semibold">Overview</p>

        {{-- Home / Dashboard --}}
        @php $routeExists = Route::has('admin.dashboard'); @endphp
        <a href="{{ $routeExists ? route('admin.dashboard') : '#' }}"
           @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
           class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.dashboard') ? 'active text-white' : 'text-white/80' }}
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
           class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.analytics.*') ? 'active text-white' : 'text-white/80' }}
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
           class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.notifications.*') ? 'active text-white' : 'text-white/80' }}
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
           class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.promotions.*') ? 'active text-white' : 'text-white/80' }}
                  {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12v9H4v-9M2 7l10-5 10 5-10 5z"/><path d="M12 22V12"/></svg>
            Promotion
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>

        <p class="text-[11px] uppercase tracking-wider text-white/40 px-3 mb-2 mt-6 font-semibold">General</p>

        {{-- Routes --}}
        @php $routeExists = Route::has('admin.routes.index'); @endphp
        <a href="{{ $routeExists ? route('admin.routes.index') : '#' }}"
           @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
           class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.routes.*') ? 'active text-white' : 'text-white/80' }}
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
           class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.drivers.*') ? 'active text-white' : 'text-white/80' }}
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
           class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.vehicles.*') ? 'active text-white' : 'text-white/80' }}
                  {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 7h-9M14 17H5M17 20l3-3-3-3M7 4L4 7l3 3"/></svg>
            Vehicles
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>

        {{-- Hero Banner --}}
        @php $routeExists = Route::has('admin.hero-banner.edit'); @endphp
        <a href="{{ $routeExists ? route('admin.hero-banner.edit') : '#' }}"
           @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
           class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.hero-banner.*') ? 'active text-white' : 'text-white/80' }}
                  {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18"/></svg>
            Hero Banner
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>

        <p class="text-[11px] uppercase tracking-wider text-white/40 px-3 mb-2 mt-6 font-semibold">Manage</p>
        <div>
            <button type="button" onclick="toggleDropdown('navDropdown2', this)" class="nav-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/80">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 8h18"/><path d="M8 12h8"/><path d="M8 16h8"/></svg>
                Website
                <svg class="dropdown-chevron ml-auto transition-transform duration-200" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </button>
            <div id="navDropdown2" class="hidden pl-9 pr-1 mt-1 space-y-1">
                @php $websiteLinks = [
                    'admin.website.vision' => 'Vision & Mission',
                    'admin.website.blogs' => 'Blogs',
                    'admin.website.subscriptions' => 'Subscriptions',
                    'admin.website.faq' => 'FAQ',
                    'admin.website.testimonials' => 'Testimonials',
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

        {{-- Settings --}}
        @php $routeExists = Route::has('admin.settings.index'); @endphp
        <a href="{{ $routeExists ? route('admin.settings.index') : '#' }}"
           @unless ($routeExists) aria-disabled="true" title="Coming soon" @endunless
           class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                  {{ $routeExists && request()->routeIs('admin.settings.*') ? 'active text-white' : 'text-white/80' }}
                  {{ ! $routeExists ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 .51 1z"/></svg>
            Settings
            @unless ($routeExists)
                <span class="ml-auto text-[9px] uppercase tracking-wide text-white/50 bg-white/10 px-1.5 py-0.5 rounded-full">Soon</span>
            @endunless
        </a>
    </nav>

    <div class="p-4 border-t border-white/10">
        <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5">
            <img src="{{ auth()->user()->avatar_url ?? 'https://i.pravatar.cc/64?img=32' }}" class="w-9 h-9 rounded-full ring-2 ring-[var(--sky)]/50" alt="{{ auth()->user()->name ?? 'User' }}" />
            <div class="min-w-0">
                <p class="text-sm font-semibold truncate">{{ auth()->user()->name ?? 'Guest' }}</p>
                <p class="text-xs text-white/50 truncate">{{ auth()->user()->role_label ?? 'Admin' }}</p>
            </div>
        </div>
    </div>
</aside>