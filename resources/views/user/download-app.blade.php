@extends('userlayout.app')

@section('title', 'Download Our App - Nova Mobility')

@push('styles')
<style>
    header{border-bottom:1px solid #e5e7eb}.logo span{color:#53a7db}nav a{color:#4b5563}.hero{background:linear-gradient(135deg,#174f80,#0a4570,#06365a);color:#fff;padding:90px 0;overflow:hidden;margin:0;border-radius:0;height:auto}.hero-grid{display:grid;grid-template-columns:1.1fr .9fr;align-items:center;gap:60px}.badge{display:inline-block;background:#7fb6e4;color:#083a5a;font-size:13px;font-weight:700;padding:8px 16px;border-radius:999px;margin-bottom:26px;letter-spacing:.5px;text-transform:uppercase}.hero h1{font-size:64px;line-height:1.05;font-weight:800;margin-bottom:24px}.hero p{font-size:20px;color:#d7e7f5;max-width:620px;margin-bottom:40px}.store-buttons{display:flex;gap:18px;flex-wrap:wrap}.store-btn{background:#fff;color:#111827;border-radius:14px;padding:16px 22px;display:flex;align-items:center;gap:14px;min-width:220px;box-shadow:0 10px 24px rgba(0,0,0,.12);transition:.3s;text-decoration:none}.store-btn:hover{transform:translateY(-2px);box-shadow:0 16px 32px rgba(0,0,0,.18)}.store-btn .icon{width:auto;height:auto;border-radius:0;background:transparent;display:block;font-size:34px;line-height:1;color:inherit;margin:0}.store-btn .icon svg{width:34px;height:34px;display:block}.store-btn small{display:block;color:#6b7280;font-size:11px;text-transform:uppercase;letter-spacing:.5px}.store-btn strong{font-size:24px;line-height:1.1}.hero-image{position:relative;display:flex;justify-content:center}.hero-image img{width:100%;max-width:460px;border-radius:10px;transform:rotate(6deg);box-shadow:0 24px 60px rgba(0,0,0,.28)}
    .partner{padding:90px 0}.section-title{text-align:center;margin-bottom:54px}.section-title h2{font-size:54px;color:#0b4b73;margin-bottom:12px}.section-title p{color:#6b7280;font-size:20px}.partner-grid{display:grid;grid-template-columns:1fr 1fr;gap:38px;align-items:center}.partner-image img{width:100%;border-radius:26px;display:block;box-shadow:0 18px 40px rgba(0,0,0,.12)}.partner-card{background:#fff;border:1px solid #e5e7eb;border-radius:22px;padding:40px;box-shadow:0 12px 32px rgba(0,0,0,.06)}.partner-card h3{font-size:40px;color:#0b4b73;margin-bottom:16px;line-height:1.1}.partner-card p{color:#6b7280;margin-bottom:30px;font-size:18px}.partner-card .store-buttons .store-btn{background:#111827;color:#fff;min-width:190px;box-shadow:none}.partner-card .store-btn small{color:#cbd5e1}footer h3{font-size:36px}footer p,footer li{color:#c8d6e4}.footer-bottom{color:#c8d6e4}
    @media(max-width:992px){.hero-grid,.partner-grid{grid-template-columns:1fr}.hero{padding:70px 0}.hero h1{font-size:48px}.hero-image{order:-1}.hero-image img{max-width:360px}.section-title h2{font-size:38px}.partner-card h3{font-size:32px}}@media(max-width:576px){.hero h1{font-size:38px}.hero p{font-size:18px}.store-btn{width:100%}.section-title h2{font-size:30px}.partner-card{padding:28px}}
</style>
@endpush

@section('content')
    <section class="hero"><div class="container hero-grid"><div><span class="badge">The App is Here</span><h1>Experience the Future of Mobility</h1><p>Nova Mobility brings the luxury of premium intercity travel to your fingertips. Download now and redefine your journey across Myanmar.</p><div class="store-buttons">
        <!-- App Store Button -->
        <a href="{{ $iosAppUrl }}" class="store-btn" target="_blank" rel="noopener noreferrer">
            <div class="icon">
                <svg viewBox="0 0 384 512" width="34" height="34" fill="currentColor">
                    <path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 126.7 25.2 0 43.2-19.9 75.8-19.9 31.4 0 47.5 19.9 76.5 19.9 48.3 0 92.9-86.9 103.8-123.9-49.5-25.7-50.6-80.8-50.6-89.8zm-65.6-48.8c-19.2 14.5-28.1 34.6-27.7 57.9 20.7 1.6 42.6-11.4 55.6-29.8 13.4-19.1 17.2-44.8 15.5-65.9-24.1 1.1-43.4 14.8-56.5 37.8z"/>
                </svg>
            </div>
            <div>
                <small>Download on the</small>
                <strong>App Store</strong>
            </div>
        </a>
        <!-- Google Play Button -->
        <a href="{{ $androidAppUrl }}" class="store-btn" target="_blank" rel="noopener noreferrer">
            <div class="icon">
                <svg viewBox="0 0 512 512" width="34" height="34" fill="currentColor">
                    <path d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"/>
                </svg>
            </div>
            <div>
                <small>Get it on</small>
                <strong>Google Play</strong>
            </div>
        </a>
    </div></div><div class="hero-image"><img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&amp;fit=crop&amp;w=900&amp;q=80" alt="Nova App" /></div></div></section>
    <section class="partner"><div class="container"><div class="section-title"><h2>Interested to partner with us?</h2><p>Get steady income from your vehicle</p></div><div class="partner-grid"><div class="partner-image"><img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&amp;fit=crop&amp;w=1200&amp;q=80" alt="Driver Partner" /></div><div class="partner-card"><h3>Nova for Owners &amp; Drivers</h3><p>Manage your fleet and maximize earnings. Comprehensive dashboard, automated payouts, and route optimization.</p><div class="store-buttons">
        <!-- Google Play Button (Dark) -->
        <a href="{{ $androidAppUrl }}" class="store-btn" target="_blank" rel="noopener noreferrer">
            <div class="icon">
                <svg viewBox="0 0 512 512" width="34" height="34" fill="currentColor">
                    <path d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"/>
                </svg>
            </div>
            <div>
                <small>Get it on</small>
                <strong>Google Play</strong>
            </div>
        </a>
        <!-- App Store Button (Dark) -->
        <a href="{{ $iosAppUrl }}" class="store-btn" target="_blank" rel="noopener noreferrer">
            <div class="icon">
                <svg viewBox="0 0 384 512" width="34" height="34" fill="currentColor">
                    <path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 126.7 25.2 0 43.2-19.9 75.8-19.9 31.4 0 47.5 19.9 76.5 19.9 48.3 0 92.9-86.9 103.8-123.9-49.5-25.7-50.6-80.8-50.6-89.8zm-65.6-48.8c-19.2 14.5-28.1 34.6-27.7 57.9 20.7 1.6 42.6-11.4 55.6-29.8 13.4-19.1 17.2-44.8 15.5-65.9-24.1 1.1-43.4 14.8-56.5 37.8z"/>
                </svg>
            </div>
            <div>
                <small>Download on the</small>
                <strong>App Store</strong>
            </div>
        </a>
    </div></div></div></div></section>
@endsection