<header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-[#E7ECF1] px-4 sm:px-8 py-4 flex items-center gap-4">
    <button onclick="toggleSidebar()" class="lg:hidden text-[var(--navy)]">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
    </button>

    <div>
        <h1 class="font-display font-bold text-xl sm:text-2xl text-[var(--navy)]">@yield('page_title', 'Dashboard')</h1>
        @hasSection('page_subtitle')
            <p class="text-sm text-slate-500 hidden sm:block">@yield('page_subtitle')</p>
        @endif
    </div>

    <div class="ml-auto flex items-center gap-3">
        <button class="relative w-10 h-10 rounded-full bg-[#F1F4F8] flex items-center justify-center hover:bg-[#e7edf5] transition">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            @if (($unreadNotificationsCount ?? 0) > 0)
                <span class="absolute top-1.5 right-2 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
            @endif
        </button>

        <img src="{{ auth()->user()->avatar_url ?? 'https://i.pravatar.cc/64?img=32' }}" class="w-9 h-9 rounded-full ring-2 ring-[var(--sky)]/50" alt="{{ auth()->user()->name ?? 'User' }}" />

        <div class="relative">
            <button onclick="toggleDropdown('userDropdown', this)" class="flex items-center gap-2 text-sm font-medium text-[var(--navy)] hover:text-[var(--sky)] transition">
                <span>{{ auth()->user()->name ?? 'Guest' }}</span>
                <svg class="dropdown-chevron transition-transform duration-200" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </button>
            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-lg shadow-lg py-2 z-10">
                <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-[#F1F4F8]">Profile</a>
                @php $settingsRouteExists = Route::has('admin.settings.index'); @endphp
                <a href="{{ $settingsRouteExists ? route('admin.settings.index') : '#' }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-[#F1F4F8]">Settings</a>
                @php $billingRouteExists = Route::has('admin.billing.index'); @endphp
                <a href="{{ $billingRouteExists ? route('admin.billing.index') : '#' }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-[#F1F4F8]">Billing</a>
                <div class="border-t border-slate-100 my-1"></div>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-slate-600 hover:bg-[#F1F4F8]">
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
