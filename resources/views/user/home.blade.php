@extends('userlayout.app')

@section('title', 'Nova Mobility')

@section('content')
    <div class="container">
        <section class="hero" id="download-app"><div class="hero-content"><h1>Redefining Travel Across Myanmar</h1><p>Experience the pinnacle of intercity transport with our premium, 100% electric fleet. Comfort, safety, and sustainability, seamlessly connected.</p></div></section>
        <section class="cards">
            <div class="card"><div class="icon">👁</div><h3>Our Vision</h3><p>{{ $visionMission?->vision }}</p></div>
            <div class="card dark"><div class="icon">🚩</div><h3>Our Mission</h3><p>{{ $visionMission?->mission }}</p></div>
        </section>
    </div>
    <section class="stats"><div class="container"><h2>The Nova Standard</h2><div class="stats-grid"><div class="stat"><h3>50k+</h3><p>Safe Trips Completed</p></div><div class="stat"><h3>100%</h3><p>Comfortable Trips</p></div><div class="stat"><h3>4</h3><p>Major Cities Connected</p></div><div class="stat"><h3>24/7</h3><p>Premium Support</p></div></div></div></section>
    <div class="container"><section class="network" id="network"><div><h2>Our Network</h2><p>Operating from strategic hubs across the country, our terminals are designed as premium lounges, ensuring your journey begins in comfort long before you board.</p><div class="branch"><div class="branch-icon">📍</div><div><h4>Yangon Branch (HQ)</h4><span>Downtown Financial District</span></div></div><div class="branch"><div class="branch-icon">📍</div><div><h4>Mandalay Branch</h4><span>Central Station Terminal</span></div></div><div class="branch"><div class="branch-icon">📍</div><div><h4>Naypyidaw Hub</h4><span>Capital Access Point</span></div></div></div><div class="network-image"><img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&amp;fit=crop&amp;w=1200&amp;q=80" alt="Nova Vehicle" /></div></section></div>
@endsection
