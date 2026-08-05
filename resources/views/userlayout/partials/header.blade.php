<header>
    <div class="container navbar">
        <a href="{{ route('home') }}" class="logo"><img src="{{ asset('image/logo.png') }}" alt="Nova Mobility"></a>
        <nav><ul>
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('our-routes') }}" class="{{ request()->routeIs('our-routes') ? 'active' : '' }}">Our Routes</a></li>
            <li><a href="{{ route('promotions.index') }}" class="{{ request()->routeIs('promotions.*') ? 'active' : '' }}">Promotions</a></li>
            <li><a href="{{ route('support') }}" class="{{ request()->routeIs('support') ? 'active' : '' }}">Support</a></li>
            <li><a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a></li>
        </ul></nav>
        <a href="{{ route('download-app') }}" class="btn {{ request()->routeIs('download-app') ? 'active' : '' }}">Download App</a>
    </div>
</header>
