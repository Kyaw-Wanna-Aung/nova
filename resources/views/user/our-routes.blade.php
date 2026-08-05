@extends('userlayout.app')

@section('title', 'Our Routes - Nova Mobility')

@push('styles')
<style>
body{background:#f3f4f6;color:#1f2937}.logo span{color:#53a7db}.hero{background:linear-gradient(135deg,#0b4b73,#1d5f90,#2b6da0);color:#fff;padding:90px 0 120px;text-align:center;margin:0;border-radius:0;height:auto}.hero h1{font-size:64px;line-height:1.08;font-weight:800;max-width:900px;margin:0 auto 22px}.hero p{color:#d7e7f5;font-size:20px;max-width:760px;margin:0 auto}.search-card{background:#fff;border-radius:24px;padding:26px;box-shadow:0 20px 50px rgba(0,0,0,.12);margin-top:-60px;position:relative;z-index:2}.search-grid{display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:16px;align-items:end}.field label{display:block;font-size:12px;font-weight:700;color:#6b7280;text-transform:uppercase;margin-bottom:8px}.field input,.field select{width:100%;padding:16px;border:1px solid #d1d5db;border-radius:14px;background:#f8fafc;font-size:15px;outline:none}.search-btn{background:#0b4b73;color:#fff;border:0;padding:16px 26px;border-radius:14px;font-weight:700;min-width:170px}.section{padding:80px 0}.section-head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:30px}.section-head h2,.steps-head h2,.testimonials h2,.cta-box h2{color:#0b4b73;font-size:48px;line-height:1.1}.section-head p,.steps-head p,.step p,.cta-box p{color:#6b7280;margin-top:10px}.trip-grid,.steps-grid,.testimonial-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}.trip-card,.testimonial{background:#fff;border:1px solid #e5e7eb;border-radius:22px;padding:24px;box-shadow:0 10px 24px rgba(0,0,0,.05);display:flex;flex-direction:column;gap:14px}.trip-top{display:flex;justify-content:space-between;color:#0b4b73;font-size:12px;font-weight:700;text-transform:uppercase}.trip-card h3{color:#0b4b73;font-size:28px}.trip-meta{color:#6b7280;font-size:14px;display:grid;gap:6px}.trip-bottom{display:flex;justify-content:space-between;align-items:center;margin-top:10px}.fare small{display:block;color:#6b7280;text-transform:uppercase}.fare strong{font-size:30px;color:#0b4b73}.arrow{width:44px;height:44px;border-radius:50%;background:#eef2f7;display:flex;align-items:center;justify-content:center;color:#0b4b73;font-weight:700}.steps{background:#fff}.steps-head{text-align:center;margin-bottom:48px}.eyebrow{display:inline-block;color:#0b4b73;font-size:12px;font-weight:700;text-transform:uppercase}.step{text-align:center;padding:12px}.step .icon,.cta-box .icon{width:72px;height:72px;border-radius:18px;background:#eaf3fb;color:#0b4b73;display:flex;align-items:center;justify-content:center;font-size:30px;margin:0 auto 18px}.step h3{color:#0b4b73;font-size:24px}.testimonials h2{text-align:center;margin-bottom:34px}.testimonial p{color:#4b5563;font-style:italic}.testimonial-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px}.stars{font-size:22px;color:#2563eb;letter-spacing:2px;line-height:1}.stars .empty-star{opacity:.25;color:#93c5fd}.rating-badge{background:#f3f4f6;color:#374151;font-weight:700;font-size:13px;padding:2px 12px;border-radius:20px;min-width:32px;text-align:center;display:inline-block;border:1px solid #e5e7eb}.person{display:flex;gap:14px;align-items:center;margin-top:auto}.avatar{width:52px;height:52px;border-radius:50%;background:#dbeafe;display:grid;place-items:center;color:#0b4b73;font-weight:800}.name{color:#0b4b73;font-weight:700}.cta{background:#fff}.cta-box{background:#f8fafc;border:1px solid #e5e7eb;border-radius:30px;padding:56px;text-align:center}.cta-actions{display:flex;justify-content:center;gap:16px}.btn-outline{border:2px solid #0b4b73;color:#0b4b73;padding:14px 24px;border-radius:12px;font-weight:700;background:#fff}@media(max-width:992px){.hero h1{font-size:44px}.search-grid,.trip-grid,.steps-grid,.testimonial-grid{grid-template-columns:1fr}.section-head{flex-direction:column;align-items:flex-start}.section-head h2,.steps-head h2,.testimonials h2,.cta-box h2{font-size:36px}}@media(max-width:576px){.hero{padding:64px 0 100px}.hero h1{font-size:34px}.search-card{margin-top:-48px;padding:18px}.cta-box{padding:34px}}
</style>
@endpush

@section('content')
<section class="hero">
    <div class="container">
        <h1>Premium Intercity Mobility for Myanmar</h1>
        <p>Experience the future of travel with our state-of-the-art electric fleet. Ride-pooling redefined for comfort, sustainability, and absolute reliability.</p>
    </div>
</section>
<section class="container search-card">
    <form method="GET" class="search-grid">
        <div class="field">
            <label>From</label>
            <select name="from">
                <option value="">Any departure</option>
                @foreach($origins as $origin)
                    <option value="{{ $origin }}" @selected(request('from')===$origin)>{{ $origin }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>To</label>
            <select name="to">
                <option value="">Any destination</option>
                @foreach($destinations as $destination)
                    <option value="{{ $destination }}" @selected(request('to')===$destination)>{{ $destination }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>Date</label>
            <input type="date" name="date" value="{{ request('date') }}">
        </div>
        <div class="field">
            <label>Passengers</label>
            <input type="number" min="1" name="passengers" value="{{ request('passengers') }}" placeholder="Passengers">
        </div>
        <button class="search-btn">Search Trip</button>
    </form>
</section>
<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <h2>Available Trips</h2>
                <p>Find and book your next intercity journey. Real-time availability for all major routes.</p>
            </div>
        </div>
        <div class="trip-grid">
            @forelse($routes as $route)
                <article class="trip-card">
                    <div class="trip-top">
                        <span>{{ $route->category }}</span>
                        <span>{{ $route->available_seats }} Seats Available</span>
                    </div>
                    <h3>{{ $route->from_location }} &rarr; {{ $route->to_location }}</h3>
                    <div class="trip-meta">
                        <span>{{ $route->departure_date?->isToday() ? 'Today' : ($route->departure_date?->isTomorrow() ? 'Tomorrow' : $route->departure_date?->format('d M')) }}</span>
                        <span>{{ $route->departure_time ? \Carbon\Carbon::parse($route->departure_time)->format('h:i A') : '--' }}</span>
                    </div>
                    <div class="trip-bottom">
                        <div class="fare">
                            <small>Fare</small>
                            <strong>MMK {{ number_format((float) $route->fare) }}</strong>
                        </div>
                        <div class="arrow">&rarr;</div>
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
            @foreach([
                ['📱', '1. Book your ticket', 'Select your route, date, and preferred seat through our mobile app or website.'],
                ['💳', '2. Make Payment', 'Securely pay using your preferred digital wallet or mobile banking service.'],
                ['🔔', '3. Get notified', 'Receive a reminder and driver details exactly 1 hour before departure.'],
                ['📍', '4. Track your driver', 'Watch your driver\'s real-time location as they approach your pickup point.'],
                ['🚗', '5. Enjoy your ride', 'Relax in our premium electric vehicles with spacious seating and climate control.'],
                ['👤', '6. Share your location', 'Keep loved ones informed by sharing your live trip status before you arrive.']
            ] as $stepItem)
                <div class="step">
                    <div class="icon">{{ $stepItem[0] }}</div>
                    <h3>{{ $stepItem[1] }}</h3>
                    <p>{{ $stepItem[2] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="section testimonials">
    <div class="container">
        <h2>Trusted by Thousands</h2>
        <div class="testimonial-grid">
            @forelse($testimonials as $testimonial)
                <article class="testimonial">
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
        <div class="cta-box">
            <div class="icon">🚀</div>
            <h2>Be ready for your next journey</h2>
            <p>Find and book your next intercity journey. Real-time availability for all major routes.</p>
            <div class="cta-actions">
                <a href="{{ route('download-app') }}" class="btn">Download the App</a>
                <a href="{{ route('support') }}" class="btn-outline">Become a Partner</a>
            </div>
        </div>
    </div>
</section>
@endsection