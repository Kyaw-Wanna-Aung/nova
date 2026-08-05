@extends('userlayout.app')

@section('title', 'Promotions - Nova Mobility')

@push('styles')
<style>
    body{background:#f3f4f6;color:#1f2937}.logo span{color:#53a7db}nav a{color:#4b5563}.hero{padding:40px 0;margin:0;border-radius:0;height:auto;background:none}.hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:32px}.promo-card{background:#1e5b8d;color:#fff;border-radius:28px;padding:42px;min-height:520px;display:flex;flex-direction:column;justify-content:space-between;box-shadow:0 20px 50px rgba(0,0,0,.08)}.promo-badge{display:inline-flex;align-items:center;gap:8px;color:#b7d5ef;font-size:13px;letter-spacing:1px;text-transform:uppercase;margin-bottom:20px}.promo-card h1{font-size:58px;line-height:1.05;font-weight:800;margin-bottom:22px}.promo-card p{color:#d7e7f5;font-size:18px;margin-bottom:26px}.promo-card strong{color:#fff;letter-spacing:1px}.features{display:flex;gap:28px;margin:10px 0 34px;flex-wrap:wrap}.feature{display:flex;align-items:center;gap:12px;color:#d7e7f5}.feature .icon{width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,.12);display:flex;align-items:center;justify-content:center;font-size:20px;margin:0;color:inherit}.feature h4{color:#fff;font-size:16px;margin-bottom:2px}.feature span{font-size:13px;color:#d7e7f5}.claim-btn{align-self:flex-start;background:#fff;color:#0b4b73;padding:14px 28px;border-radius:999px;font-weight:700;transition:.3s}.claim-btn:hover{transform:translateY(-2px)}.hero-image{position:relative;border-radius:28px;overflow:hidden;min-height:520px;box-shadow:0 20px 50px rgba(0,0,0,.12)}.hero-image img{width:100%;height:100%;object-fit:cover;display:block}.image-overlay{position:absolute;right:22px;bottom:22px;background:rgba(255,255,255,.94);padding:24px;border-radius:20px;max-width:300px;box-shadow:0 10px 24px rgba(0,0,0,.12)}.image-overlay h3{color:#0b4b73;font-size:34px;margin-bottom:10px;line-height:1.1}.image-overlay p{color:#4b5563;font-size:16px}
    .deals{padding:10px 0 30px}.section-header{display:flex;align-items:flex-end;justify-content:space-between;gap:20px;margin-bottom:24px}.section-header h2{font-size:54px;color:#0b4b73;line-height:1.1}.section-header p{color:#6b7280;font-size:18px;margin-top:10px}.view-all{color:#0b4b73;font-weight:700;white-space:nowrap}.route-card{background:#fff;border:1px solid #e5e7eb;border-radius:22px;padding:20px;display:grid;grid-template-columns:240px 1fr auto;gap:24px;align-items:center;margin-bottom:22px;box-shadow:0 10px 24px rgba(0,0,0,.04)}.route-image{position:relative;border-radius:18px;overflow:hidden;height:140px}.route-image img{width:100%;height:100%;object-fit:cover;display:block}.tag{position:absolute;top:14px;left:14px;background:#0b4b73;color:#fff;font-size:12px;font-weight:700;padding:6px 10px;border-radius:10px}.route-info h3{color:#0b4b73;font-size:38px;margin-bottom:8px;line-height:1.1}.route-info p{color:#6b7280;margin-bottom:8px}.price{text-align:right;min-width:180px}.old-price{color:#9ca3af;text-decoration:line-through;font-size:18px;margin-bottom:6px}.new-price{color:#0b4b73;font-size:36px;font-weight:800}
    .newsletter{padding:40px 0 80px}.newsletter-box{background:#073b63;color:#fff;border-radius:32px;padding:56px 48px;text-align:center}.newsletter-box h3{font-size:18px;color:#c7d8e8;margin-bottom:12px;font-weight:600}.newsletter-box p{color:#d7e7f5;max-width:720px;margin:0 auto 30px;font-size:18px}.subscribe{display:flex;justify-content:center;gap:16px;flex-wrap:wrap;margin-bottom:18px}.subscribe input{width:380px;max-width:100%;padding:16px 18px;border-radius:14px;border:1px solid rgba(255,255,255,.15);background:rgba(255,255,255,.08);color:#fff;font-size:16px;outline:none}.subscribe input::placeholder{color:#cbd5e1}.subscribe button{background:#8ec5f3;color:#083a5a;border:none;padding:16px 28px;border-radius:14px;font-weight:700;cursor:pointer}.newsletter-box small{color:#cbd5e1}footer h3{font-size:36px}footer p,footer li,.footer-bottom{color:#c8d6e4}
    @media(max-width:992px){.hero-grid{grid-template-columns:1fr}.section-header{flex-direction:column;align-items:flex-start}.route-card{grid-template-columns:1fr}.price{text-align:left}.promo-card h1{font-size:44px}.section-header h2{font-size:38px}.route-info h3{font-size:30px}}@media(max-width:576px){.promo-card{padding:28px}.promo-card h1{font-size:36px}.section-header h2{font-size:30px}.image-overlay h3{font-size:28px}.subscribe{flex-direction:column}.subscribe input,.subscribe button{width:100%}}
</style>
@endpush

@section('content')
    @php
        $heroImage = $heroBanner?->image ? asset('storage/'.$heroBanner->image) : 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80';
    @endphp
    <section class="hero">
        <div class="container hero-grid">
            <div class="promo-card">
                <div>
                    <div class="promo-badge">🌿 {{ $heroBanner?->category ?? 'Sustainable Travel' }}</div>
                    <h1>{{ $heroBanner?->title ?? 'No banner available' }}</h1>
                    <p>{{ $heroBanner?->description }}</p>
                    <div class="features">
                        @if($heroBanner?->badge_1_title)
                        <div class="feature">
                            <div class="icon">⚡</div>
                            <div>
                                <h4>{{ $heroBanner->badge_1_title }}</h4>
                                <span>{{ $heroBanner->badge_1_sub }}</span>
                            </div>
                        </div>
                        @endif
                        @if($heroBanner?->badge_2_title)
                        <div class="feature">
                            <div class="icon">🛋</div>
                            <div>
                                <h4>{{ $heroBanner->badge_2_title }}</h4>
                                <span>{{ $heroBanner->badge_2_sub }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <a href="#" class="claim-btn">{{ $heroBanner?->promo_code ? 'Code: ' . $heroBanner->promo_code : 'Claim Discount' }}</a>
            </div>
            <div class="hero-image">
                <img src="{{ $heroImage }}" alt="{{ $heroBanner?->title ?? 'Nova Electric Vehicle' }}" />
                <div class="image-overlay">
                    <h3>{{ $heroBanner?->card_title ?? 'Sustainable Luxury' }}</h3>
                    <p>{{ $heroBanner?->card_description }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="deals">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2>Seasonal Routes &amp; Deals</h2>
                    <p>Explore Myanmar's most iconic journeys with special seasonal rates.</p>
                </div>
                <a href="#" class="view-all">View All Routes →</a>
            </div>
            @foreach ($promotions as $promotion)
                @php $imageUrl = $promotion->image ? asset('storage/'.$promotion->image) : 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=900&q=80'; @endphp
                <article class="route-card">
                    <div class="route-image">
                        <img src="{{ $imageUrl }}" alt="{{ $promotion->title }}" />
                        @if ($loop->first)<span class="tag">Best Seller</span>@endif
                    </div>
                    <div class="route-info">
                        <h3>{{ $promotion->title }}</h3>
                        @if ($promotion->duration)<p>{{ $promotion->duration }}</p>@endif 
                        @if ($promotion->daily_departures)<p>Daily Departures: {{ $promotion->daily_departures }}</p>@endif
                    </div>
                    <div class="price">
                        <div class="old-price">{{ number_format((float) $promotion->original_price) }} MMK</div>
                        <div class="new-price">{{ number_format((float) $promotion->discounted_price) }} MMK</div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="newsletter">
        <div class="container">
            <div class="newsletter-box">
                <h3>Stay Updated on New Routes</h3>
                <p>Join our newsletter to receive exclusive flash deals, early-bird membership invites, and Myanmar travel insights directly in your inbox.</p>
                <form method="POST" action="{{ route('newsletter.subscribe') }}" class="subscribe">
                    @csrf
                    <input name="email" type="email" value="{{ old('email') }}" placeholder="Enter your business email" required />
                    <button type="submit">Subscribe Now</button>
                </form>
                @error('email')<small>{{ $message }}</small>@enderror 
                @if (session('success') || session('error'))
                    <small>{{ session('success') ?? session('error') }}</small>
                @else
                    <small>We respect your privacy. Unsubscribe at any time.</small>
                @endif
            </div>
        </div>
    </section>
@endsection