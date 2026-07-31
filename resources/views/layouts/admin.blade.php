<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NOVA') | Route Management</title>

    {{-- Third-party assets (CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">

    {{-- Local assets, served from /public via asset() --}}
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}">

    <style>
        :root{
            --sky:#7ab9ec;
            --navy:#1F4E79;
            --paper:#F8F9FA;
            --grad-a-start:#005AA7;
            --grad-a-end:#FFFDE4;
            --grad-b-start:#1c92d2;
            --grad-b-end:#f2fcfe;
        }
        *{font-family:'Manrope',sans-serif;}
        .font-display{font-family:'Sora',sans-serif;}
        body{background:var(--paper);}
        .grad-a{background:linear-gradient(135deg,var(--grad-a-start) 0%,var(--grad-a-end) 100%);}
        .grad-b{background:linear-gradient(135deg,var(--grad-b-start) 0%,var(--grad-b-end) 100%);}
        .sidebar-grad{background:linear-gradient(200deg,var(--navy) 0%,#123452 100%);}
        .scrollbar-thin::-webkit-scrollbar{width:6px;height:6px;}
        .scrollbar-thin::-webkit-scrollbar-thumb{background:#c9dcee;border-radius:10px;}
        .card{background:#fff;border:1px solid #E7ECF1;border-radius:18px;}
        .nav-link{transition:all .18s ease;}
        .nav-link:hover{background:rgba(122,185,236,0.14);}
        .nav-link.active{background:rgba(122,185,236,0.22);border-left:3px solid var(--sky);}
        .dropdown-chevron.rotated{transform:rotate(180deg);}
        .glow{box-shadow:0 8px 24px -8px rgba(31,78,121,0.25);}
        ::selection{background:var(--sky);color:#fff;}
        .toast{transition:transform .3s ease, opacity .3s ease;}
        th.sortable{cursor:pointer;user-select:none;}
        th.sortable:hover{color:var(--navy);}
        .sort-icon{opacity:.3;transition:opacity .15s, transform .15s;}
        th.sort-asc .sort-icon{opacity:1;transform:rotate(0deg);}
        th.sort-desc .sort-icon{opacity:1;transform:rotate(180deg);}
        tr.row-selected{background:rgba(122,185,236,0.10);}
        .checkbox{accent-color:var(--navy);}
        #bulkBar{transition:transform .25s ease, opacity .25s ease;}
        .input-field{transition:all .18s ease;}
        .input-field:focus{border-color:var(--sky);box-shadow:0 0 0 4px rgba(122,185,236,0.25);}
        @media (max-width: 1024px){
            #sidebar{transform:translateX(-100%);}
            #sidebar.open{transform:translateX(0);}
        }
    </style>

    @stack('styles')
</head>
<body class="text-[#1F2937]">
<div class="flex min-h-screen">

    @include('layouts.partials.sidebar')

    <div id="overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-black/30 z-30 lg:hidden"></div>

    <div class="flex-1 min-w-0 flex flex-col">

        @include('layouts.partials.header')

        <main class="flex-1 px-4 sm:px-8 py-6 max-w-[1400px] w-full mx-auto">
            @if (session('success'))
                <div class="mb-4 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-medium px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-xl bg-rose-50 text-rose-700 text-sm font-medium px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

{{-- Toast notification --}}
<div id="toast" class="toast fixed bottom-6 right-6 translate-y-24 opacity-0 bg-[var(--navy)] text-white text-sm font-medium px-5 py-3 rounded-xl shadow-xl z-50 flex items-center gap-2">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--sky)" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
    <span id="toastMsg">Done</span>
</div>

{{-- Global JS shared across admin pages --}}
<script src="{{ asset('assets/js/app.js') }}"></script>
<script>
    function toggleSidebar(){
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('overlay').classList.toggle('hidden');
    }
    function toggleDropdown(id, btn){
        const panel = document.getElementById(id);
        const chevron = btn.querySelector('.dropdown-chevron');
        panel.classList.toggle('hidden');
        chevron.classList.toggle('rotated');
    }
    let toastTimer;
    function showToast(msg){
        const toast = document.getElementById('toast');
        document.getElementById('toastMsg').textContent = msg || 'Done';
        toast.classList.remove('translate-y-24','opacity-0');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => toast.classList.add('translate-y-24','opacity-0'), 2400);
    }
    // Expose CSRF token for fetch()-based AJAX calls in child views
    window.CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>

@stack('scripts')
</body>
</html>