@extends('userlayout.app')

@section('title', 'Our Routes - Nova Mobility')

@push('styles')
<style>
body{background:#f3f4f6;color:#1f2937}
.logo span{color:#53a7db}

/* ===== MATERIAL SYMBOLS SETUP ===== */
.material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;
    font-size: inherit;
    line-height: 1;
    display: inline-block;
    vertical-align: middle;
}

/* Hero background gradient from #073b63 (top-left) to white (bottom-right) */
.hero{
    background: linear-gradient(135deg, #073b63 0%, #1d5f90 50%, #f6f8f9 100%);
    color:#fff;
    padding:90px 0 280px;
    text-align:center;
    margin:0;
    border-radius:0;
    height:auto;
    position:relative;
}
.hero h1{font-size:64px;line-height:1.08;font-weight:800;max-width:900px;margin:0 auto 22px}
.hero p{color:#d7e7f5;font-size:20px;max-width:760px;margin:0 auto}

/* Container width restriction for content sections so they aren't too wide */
.container{max-width:1200px;margin:0 auto;padding:0 20px}

/* Search card with transparent/frosted background and wider layout */
.search-card{
    background: rgba(240, 244, 248, 0.88);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    border-radius:24px;
    padding:28px;
    box-shadow:0 20px 50px rgba(0,0,0,.15);
    margin:-190px auto 0;
    position:relative;
    z-index:2;
    max-width:1250px;
}
.search-grid{display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:16px;align-items:end}

.field {
    position: relative;
}

.field label{display:block;font-size:12px;font-weight:700;color:#4b5563;text-transform:uppercase;margin-bottom:8px}

.field .material-symbols-outlined {
    position: absolute;
    bottom: 16px;
    left: 14px;
    font-size: 20px;
    color: #6b7280;
    pointer-events: none;
    z-index: 1;
}

.field input,.field select{
    width:100%;
    padding:16px 16px 16px 44px;
    border:1px solid #cbd5e1;
    border-radius:14px;
    background:#ffffff;
    font-size:15px;
    outline:none;
}

.search-btn{
    background:#0b4b73;
    color:#fff;
    border:0;
    padding:16px 26px;
    border-radius:14px;
    font-weight:700;
    min-width:170px;
    cursor:pointer;
    transition:background .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.search-btn:hover{background:#063857}

.search-btn .material-symbols-outlined {
    font-size: 22px;
}

/* Balanced section padding and width */
.section{padding:80px 0;    padding-top: 120px;}
.section-head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:30px}
.section-head h2,.steps-head h2,.testimonials h2,.cta-box h2{color:#27292b;font-size:40px;line-height:1.1}
.section-head p,.steps-head p,.step p,.cta-box p{color:#6b7280;margin-top:10px}

/* View All Trips Link styling */
.view-all-link{
    color: #0b4b73;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    transition: opacity 0.2s;
}
.view-all-link:hover{opacity: 0.8;}

.trip-grid,.steps-grid,.testimonial-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}

/* ===== TRIP CARD ===== */
.trip-card{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:22px;
    padding:24px;
    box-shadow:0 10px 24px rgba(0,0,0,.05);
    display:flex;
    flex-direction:column;
    gap:14px;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position:relative;
    overflow:hidden;
    cursor:pointer;
    animation: modalSlideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

/* Modal Slide Up Animation */
@keyframes modalSlideUp {
    0% {
        opacity: 0;
        transform: translateY(40px) scale(0.95);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Stagger delays for trip cards */
.trip-card:nth-child(1) { animation-delay: 0s; }
.trip-card:nth-child(2) { animation-delay: 0.08s; }
.trip-card:nth-child(3) { animation-delay: 0.16s; }

/* Hover effect - gradient background + translateY + blue shadow */
.trip-card:hover {
    background: linear-gradient(135deg, #073b63 0%, #1d5f90 50%, #f6f8f9 100%);
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(7, 59, 99, 0.35);
    border-color: rgba(7, 59, 99, 0.2);
}

/* All text turns white on hover */
.trip-card:hover .trip-top,
.trip-card:hover .trip-top .category-badge,
.trip-card:hover h3,
.trip-card:hover .trip-meta,
.trip-card:hover .trip-meta span,
.trip-card:hover .fare small,
.trip-card:hover .fare strong,
.trip-card:hover .trip-top span {
    color: #ffffff !important;
}

.trip-card:hover .trip-meta .material-symbols-outlined {
    color: #ffffff !important;
}

/* Category badge on hover */
.trip-card:hover .category-badge {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff !important;
}

/* Arrow on hover */
.trip-card:hover .arrow {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff !important;
    border-color: rgba(255, 255, 255, 0.3);
    transform: translateX(4px);
}

/* Trip bottom border on hover */
.trip-card:hover .trip-bottom {
    border-top-color: rgba(255, 255, 255, 0.2);
}

/* Shine effect */
.trip-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.7s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
    z-index: 1;
}

.trip-card:hover::before {
    left: 100%;
}

.trip-top{display:flex;justify-content:space-between;align-items:center;color:#0b4b73;font-size:12px;font-weight:700;text-transform:uppercase}
.trip-top .category-badge{
    background: #eaf3fb;
    color: #0b4b73;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 700;
    transition: all 0.3s ease;
}
.trip-card h3{color:#1b1d1e;font-size:24px;transition: color 0.3s ease}
.trip-meta{color:#6b7280;font-size:14px;display:flex;align-items:center;gap:8px;transition: color 0.3s ease}

.trip-meta .material-symbols-outlined {
    font-size: 18px;
}

.trip-bottom{display:flex;justify-content:space-between;align-items:center;margin-top:10px;border-top:2px solid #eeeff1;padding-top:16px;transition: border-color 0.3s ease}
.fare small{display:block;color:#6b7280;text-transform:uppercase;font-size:11px;transition: color 0.3s ease}
.fare strong{font-size:24px;color:#0b4b73;transition: color 0.3s ease}
.arrow{width:40px;height:40px;border-radius:50%;background:#f8fafc;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;color:#0b4b73;font-weight:700;text-decoration:none;transition:all .3s ease}

/* ===== STEP CARD ===== */
.steps{background:#fff}
.steps-head{text-align:center;margin-bottom:40px}
.eyebrow{display:inline-block;color:#0b4b73;font-size:12px;font-weight:700;text-transform:uppercase}

.step{
    text-align:center;
    padding:16px;
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.03);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position:relative;
    overflow:hidden;
    cursor:pointer;
    animation: modalSlideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

/* Stagger delays for step cards */
.step:nth-child(1) { animation-delay: 0s; }
.step:nth-child(2) { animation-delay: 0.08s; }
.step:nth-child(3) { animation-delay: 0.16s; }
.step:nth-child(4) { animation-delay: 0.24s; }
.step:nth-child(5) { animation-delay: 0.32s; }
.step:nth-child(6) { animation-delay: 0.40s; }

/* Hover effect - gradient background + translateY + blue shadow */
.step:hover {
    background: linear-gradient(135deg, #073b63 0%, #1d5f90 50%, #f6f8f9 100%);
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(7, 59, 99, 0.30);
    border-color: rgba(7, 59, 99, 0.2);
}

/* All text turns white on hover */
.step:hover h3,
.step:hover p {
    color: #ffffff !important;
}

/* Icon on hover */
.step:hover .icon {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff !important;
    transform: scale(1.1) rotate(-5deg);
}

.step .icon{
    width:64px;
    height:64px;
    border-radius:18px;
    background:#eaf3fb;
    color:#0b4b73;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    margin:0 auto 16px;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.step .icon .material-symbols-outlined {
    font-size: 32px;
}

.step:hover .icon .material-symbols-outlined {
    color: #ffffff !important;
}

.step h3{color:#0b4b73;font-size:20px;transition: color 0.3s ease}
.step p{transition: color 0.3s ease}

/* Glow effect */
.step::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 70%);
    border-radius: 50%;
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
    opacity: 0;
}

.step:hover::after {
    opacity: 1;
    transform: scale(1.5);
}

/* ===== TESTIMONIAL CARD ===== */
.testimonial{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:22px;
    padding:24px;
    box-shadow:0 10px 24px rgba(0,0,0,.05);
    display:flex;
    flex-direction:column;
    gap:14px;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    cursor:pointer;
    animation: modalSlideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

/* Stagger delays for testimonial cards */
.testimonial:nth-child(1) { animation-delay: 0s; }
.testimonial:nth-child(2) { animation-delay: 0.12s; }
.testimonial:nth-child(3) { animation-delay: 0.24s; }

/* Hover effect - gradient background + translateY + blue shadow */
.testimonial:hover {
    background: linear-gradient(135deg, #073b63 0%, #1d5f90 50%, #f6f8f9 100%);
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(7, 59, 99, 0.30);
    border-color: rgba(7, 59, 99, 0.2);
}

/* All text turns white on hover */
.testimonial:hover p,
.testimonial:hover .name,
.testimonial:hover small,
.testimonial:hover .rating-badge {
    color: #ffffff !important;
}

/* Stars on hover */
.testimonial:hover .stars {
    color: #ffffff !important;
    transform: scale(1.05);
}

.testimonial:hover .stars .empty-star {
    color: rgba(255, 255, 255, 0.3) !important;
}

/* Avatar on hover */
.testimonial:hover .avatar {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff !important;
    transform: scale(1.05);
}

/* Rating badge on hover */
.testimonial:hover .rating-badge {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.2);
}

.testimonials h2{text-align:center;margin-bottom:34px}
.testimonial p{color:#4b5563;font-style:italic;font-size:15px;transition: color 0.3s ease}
.testimonial-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px}
.stars{font-size:20px;color:#2563eb;letter-spacing:2px;line-height:1;transition: all 0.3s ease}
.stars .empty-star{opacity:.25;color:#93c5fd;transition: color 0.3s ease}
.rating-badge{background:#f3f4f6;color:#374151;font-weight:700;font-size:13px;padding:2px 12px;border-radius:20px;min-width:32px;text-align:center;display:inline-block;border:1px solid #e5e7eb;transition: all 0.3s ease}
.person{display:flex;gap:14px;align-items:center;margin-top:auto}
.avatar{width:48px;height:48px;border-radius:50%;background:#dbeafe;display:grid;place-items:center;color:#0b4b73;font-weight:800;transition: all 0.3s ease}
.name{color:#0b4b73;font-weight:700;font-size:15px;transition: color 0.3s ease}

/* ===== CTA BOX ===== */
.cta{background:#fff;position:relative;overflow:hidden}

/* Background pulse animation */
.cta::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at center, rgba(7,59,99,0.03), transparent 60%);
    animation: ctaPulse 8s ease-in-out infinite;
    pointer-events: none;
}

@keyframes ctaPulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.2); opacity: 1; }
}

.cta-box{
    background:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:30px;
    padding:48px 24px;
    text-align:center;
    max-width:900px;
    margin:0 auto;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    position:relative;
    z-index:1;
    animation: modalSlideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    animation-delay: 0.2s;
}

.cta-box:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow: 0 30px 70px rgba(7,59,99,0.15);
    border-color: rgba(7,59,99,0.15);
}

/* CTA icon with float animation */
.cta-box .icon{
    width:64px;
    height:64px;
    border-radius:18px;
    background:#eaf3fb;
    color:#0b4b73;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    margin:0 auto 16px;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    animation: ctaIconFloat 3s ease-in-out infinite;
}

.cta-box .icon .material-symbols-outlined {
    font-size: 32px;
}

@keyframes ctaIconFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.cta-box:hover .icon {
    transform: scale(1.15) rotate(-8deg);
    animation-play-state: paused;
}

/* CTA heading with underline animation */
.cta-box h2 {
    position: relative;
    display: inline-block;
}

.cta-box h2::after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 0;
    width: 0;
    height: 3px;
    background: linear-gradient(90deg, #073b63, #1d5f90, #073b63);
    border-radius: 3px;
    transition: width 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.cta-box:hover h2::after {
    width: 100%;
}

/* CTA paragraph with slide effect */
.cta-box p {
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.cta-box:hover p {
    transform: translateY(-2px);
}

.cta-actions{display:flex;justify-content:center;gap:16px;margin-top:20px}

/* CTA Buttons with enhanced animations */
.btn,.btn-outline{
    display:inline-block;
    padding:14px 28px;
    border-radius:12px;
    font-weight:700;
    text-decoration:none;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position:relative;
    overflow:hidden;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn .material-symbols-outlined,
.btn-outline .material-symbols-outlined {
    font-size: 22px;
}

.btn{
    background:#0b4b73;
    color:#fff;
}

/* Button shine effect */
.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.btn:hover::before {
    left: 100%;
}

.btn:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 15px 40px rgba(11,75,115,0.3);
    background: #063857;
}

.btn-outline{
    border:2px solid #0b4b73;
    color:#0b4b73;
    background:#fff;
}

.btn-outline::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.btn-outline:hover::before {
    left: 100%;
}

.btn-outline:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 15px 40px rgba(11,75,115,0.15);
    background: #0b4b73;
    color: #fff;
}

/* ===== SCROLL REVEAL ANIMATIONS ===== */
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

/* Hero text animation */
.hero h1, .hero p {
    opacity: 0;
    animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.hero p {
    animation-delay: 0.3s;
}

/* Search card animation */
.search-card {
    opacity: 0;
    animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) 0.5s forwards;
}

/* Section heading animations */
.section-head h2, .steps-head h2, .testimonials h2, .cta-box h2 {
    opacity: 0;
    animation: fadeIn 0.8s ease-out forwards;
}

.section-head p, .steps-head p, .cta-box p {
    opacity: 0;
    animation: fadeIn 0.8s ease-out 0.2s forwards;
}

.section-head .view-all-link {
    opacity: 0;
    animation: fadeIn 0.8s ease-out 0.3s forwards;
}

/* ===== RESPONSIVE MEDIA QUERIES (ORIGINAL - UNCHANGED) ===== */
@media(max-width:1024px){
    .steps-grid{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:992px){
    .hero h1{font-size:40px}
    .hero p{font-size:16px}
    .search-grid,.trip-grid,.testimonial-grid{grid-template-columns:1fr}
    .section-head{flex-direction:column;align-items:flex-start}
    .section-head h2,.steps-head h2,.testimonials h2,.cta-box h2{font-size:32px}
}
@media(max-width:768px){
    .steps-grid{grid-template-columns:1fr}
}
@media(max-width:576px){
    .hero{padding:64px 0 160px}
    .hero h1{font-size:28px}
    .search-card{margin-top:-100px;padding:16px}
    .cta-box{padding:30px 16px}
    .cta-actions{flex-direction:column}
}
</style>
@endpush

@section('content')
<section class="hero">
    <div class="container">
        <h1>Premium Intercity Mobility for Myanmar</h1>
        <p>Experience the future of travel with our state-of-the-art electric fleet. Ride-pooling redefined for comfort, sustainability, and absolute reliability.</p>
    </div>
</section>

<div class="container">
    <section class="search-card">
        <form method="GET" class="search-grid">
            <div class="field">
                <label>From</label>
                <span class="material-symbols-outlined">pin_drop</span>
                <select name="from">
                    <option value="">Any departure</option>
                    @foreach($origins as $origin)
                        <option value="{{ $origin }}" @selected(request('from')===$origin)>{{ $origin }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label>To</label>
                <span class="material-symbols-outlined">location_on</span>
                <select name="to">
                    <option value="">Any destination</option>
                    @foreach($destinations as $destination)
                        <option value="{{ $destination }}" @selected(request('to')===$destination)>{{ $destination }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label>Date</label>
                <span class="material-symbols-outlined">schedule</span>
                <input type="date" name="date" value="{{ request('date') }}">
            </div>
            <div class="field">
                <label>Passengers</label>
                <span class="material-symbols-outlined">person</span>
                <input type="number" min="1" name="passengers" value="{{ request('passengers') }}" placeholder="Passengers">
            </div>
            <button class="search-btn">
                <span class="material-symbols-outlined">search</span>
                Search Trip
            </button>
        </form>
    </section>
</div>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <h2>Available Trips</h2>
                <p>Find and book your next intercity journey. Real-time availability for all major routes.</p>
            </div>
            <a href="{{ route('our-routes') }}" class="view-all-link">
                View All Trips &rarr;
            </a>
        </div>
        <div class="trip-grid">
            @forelse($routes as $route)
                <article class="trip-card scroll-animate">
                    <div class="trip-top">
                        <span class="category-badge"><span>{{ $route->category }}</span></span>
                        <span>{{ $route->available_seats }} Seats Available</span>
                    </div>
                    <h3>{{ $route->from_location }} &rarr; {{ $route->to_location }}</h3>
                    
                    <div class="trip-meta">
                        <span class="material-symbols-outlined">schedule</span>
                        <span>
                            {{ $route->departure_date?->isToday() ? 'Today' : ($route->departure_date?->isTomorrow() ? 'Tomorrow' : $route->departure_date?->format('d M')) }}, 
                            {{ $route->departure_time ? \Carbon\Carbon::parse($route->departure_time)->format('h:i A') : '--' }}
                        </span>
                    </div>

                    <div class="trip-bottom">
                        <div class="fare">
                            <small>Fare</small>
                            <strong>MMK {{ number_format((float) $route->fare) }}</strong>
                        </div>
                        <a href="{{ route('our-routes') }}" class="arrow" title="View Route Details">&rarr;</a>
                    </div>
                </article>
            @empty
                <p class="text-slate-500">No active routes match your search.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="section steps">
    <div class="container">
        <div class="steps-head">
            <span class="eyebrow">Seamless Experience</span>
            <h2>How it Works</h2>
            <p>Your journey with Nova Mobility is designed to be effortless from start to finish.</p>
        </div>
        <div class="steps-grid">
            <div class="step scroll-animate">
                <div class="icon"><span class="material-symbols-outlined">confirmation_number</span></div>
                <h3>1. Book your ticket</h3>
                <p>Select your route, date, and preferred seat through our mobile app or website.</p>
            </div>
            <div class="step scroll-animate">
                <div class="icon"><span class="material-symbols-outlined">payments</span></div>
                <h3>2. Make Payment</h3>
                <p>Securely pay using your preferred digital wallet or mobile banking service.</p>
            </div>
            <div class="step scroll-animate">
                <div class="icon"><span class="material-symbols-outlined">notifications_active</span></div>
                <h3>3. Get notified</h3>
                <p>Receive a reminder and driver details exactly 1 hour before departure.</p>
            </div>
            <div class="step scroll-animate">
                <div class="icon"><span class="material-symbols-outlined">near_me</span></div>
                <h3>4. Track your driver</h3>
                <p>Watch your driver's real-time location as they approach your pickup point.</p>
            </div>
            <div class="step scroll-animate">
                <div class="icon"><span class="material-symbols-outlined">directions_car</span></div>
                <h3>5. Enjoy your ride</h3>
                <p>Relax in our premium electric vehicles with spacious seating and climate control.</p>
            </div>
            <div class="step scroll-animate">
                <div class="icon"><span class="material-symbols-outlined">share_location</span></div>
                <h3>6. Share your location</h3>
                <p>Keep loved ones informed by sharing your live trip status before you arrive.</p>
            </div>
        </div>
    </div>
</section>

<section class="section testimonials">
    <div class="container">
        <h2>Trusted by Thousands</h2>
        <div class="testimonial-grid">
            @forelse($testimonials as $testimonial)
                <article class="testimonial scroll-animate">
                    <div class="testimonial-header">
                        <div class="stars">
                            @for($ratingStar = 1; $ratingStar <= 5; $ratingStar++)
                                @if($ratingStar <= $testimonial->rating)
                                    ★
                                @else
                                    <span class="empty-star">★</span>
                                @endif
                            @endfor
                        </div>
                        <span class="rating-badge">{{ $testimonial->rating }}</span>
                    </div>
                    <p>&ldquo;{{ $testimonial->message }}&rdquo;</p>
                    <div class="person">
                        @if($testimonial->photo_url)
                            <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="avatar" style="object-fit:cover;">
                        @else
                            <div class="avatar">{{ mb_strtoupper(mb_substr($testimonial->name, 0, 1)) }}</div>
                        @endif
                        <div>
                            <div class="name">{{ $testimonial->name }}</div>
                            <small>{{ $testimonial->role }}</small>
                        </div>
                    </div>
                </article>
            @empty
                <p style="grid-column:1/-1;text-align:center;color:#64748b;padding:28px 0">No testimonials yet — check back soon!</p>
            @endforelse
        </div>
    </div>
</section>

<section class="section cta">
    <div class="container">
        <div class="cta-box scroll-animate">
            <div class="icon"><span class="material-symbols-outlined">mobile</span></div>
            <h2>Be ready for your next journey</h2>
            <p>Find and book your next intercity journey. Real-time availability for all major routes.</p>
            <div class="cta-actions">
                <a href="{{ route('download-app') }}" class="btn">
                    <span class="material-symbols-outlined">download</span>
                    Download the App
                </a>
                <a href="{{ route('support') }}" class="btn-outline">
                    <span class="material-symbols-outlined">handshake</span>
                    Become a Partner
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // ===== SCROLL ANIMATION INTERSECTION OBSERVER =====
        const observerOptions = {
            threshold: 0.12,
            rootMargin: '0px 0px -20px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all elements with scroll-animate class
        document.querySelectorAll('.scroll-animate').forEach(element => {
            observer.observe(element);
        });

        // Also observe trip cards, steps, testimonials, and cta-box
        document.querySelectorAll('.trip-card, .step, .testimonial, .cta-box').forEach(element => {
            observer.observe(element);
        });
    });
</script>
@endsection