@extends('userlayout.app')

@section('title', 'Download Our App - Nova Mobility')

@push('styles')
<style>
    header{border-bottom:1px solid #e5e7eb}.logo span{color:#53a7db}nav a{color:#4b5563}
    
    /* ===== HERO SECTION ANIMATIONS ===== */
    .hero{
        background:linear-gradient(135deg,#073b63 0%,#073b63 50%,#073b63 100%);
        color:#fff;
        padding:90px 0;
        overflow:hidden;
        margin:0;
        border-radius:0;
        height:auto;
        position:relative;
    }

    /* Background pulse effect */
    .hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(ellipse, rgba(255,255,255,0.05), transparent 70%);
        animation: heroPulse 6s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes heroPulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 1; }
    }

    .hero-grid{display:grid;grid-template-columns:1.1fr .9fr;align-items:center;gap:60px}
    
    .badge{
        display:inline-block;
        background:#7fb6e4;
        color:#083a5a;
        font-size:13px;
        font-weight:700;
        padding:8px 16px;
        border-radius:999px;
        margin-bottom:26px;
        letter-spacing:.5px;
        text-transform:uppercase;
        animation: fadeInDown 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        display:inline-flex;
        align-items:center;
        gap:8px;
    }

    .badge .material-symbols-outlined {
        font-size: 20px;
    }

    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .hero h1{
        font-size:64px;
        line-height:1.05;
        font-weight:800;
        margin-bottom:24px;
        animation: fadeInUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s both;
    }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .hero p{
        font-size:20px;
        color:#d7e7f5;
        max-width:620px;
        margin-bottom:40px;
        animation: fadeInUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
    }

    .store-buttons{display:flex;gap:18px;flex-wrap:wrap}
    .store-btn{
        background:#fff;
        color:#111827;
        border-radius:14px;
        padding:16px 22px;
        display:flex;
        align-items:center;
        gap:14px;
        min-width:220px;
        box-shadow:0 10px 24px rgba(0,0,0,.12);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-decoration:none;
        position:relative;
        overflow:hidden;
        animation: fadeInUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.5s both;
    }

    .store-btn:first-child { animation-delay: 0.5s; }
    .store-btn:last-child { animation-delay: 0.6s; }

    /* Button shine effect */
    .store-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        pointer-events: none;
    }

    .store-btn:hover::before {
        left: 100%;
    }

    .store-btn:hover{
        transform: translateY(-4px) scale(1.02);
        box-shadow:0 20px 40px rgba(0,0,0,.2);
    }

    .store-btn .icon{
        width:auto;
        height:auto;
        border-radius:0;
        background:transparent;
        display:block;
        font-size:34px;
        line-height:1;
        color:inherit;
        margin:0;
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .store-btn .icon i {
        font-size: 34px;
    }

    .store-btn:hover .icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .store-btn .icon svg{width:34px;height:34px;display:block}
    .store-btn small{display:block;color:#6b7280;font-size:11px;text-transform:uppercase;letter-spacing:.5px}
    .store-btn strong{font-size:24px;line-height:1.1}
    
    /* ===== HERO IMAGE ANIMATIONS ===== */
    .hero-image{
        position:relative;
        display:flex;
        justify-content:center;
        animation: imageFloat 6s ease-in-out infinite;
    }

    @keyframes imageFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    .hero-image::before {
        content: '';
        position: absolute;
        width: 440px;
        height: 440px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.75) 0%, rgba(255, 255, 255, 0.25) 45%, rgba(255, 255, 255, 0) 75%);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 0;
        pointer-events: none;
        filter: blur(25px);
        animation: glowPulse 3s ease-in-out infinite;
    }

    @keyframes glowPulse {
        0%, 100% { opacity: 0.8; transform: translate(-50%, -50%) scale(1); }
        50% { opacity: 1; transform: translate(-50%, -50%) scale(1.1); }
    }

    .hero-image img{
        width:100%;
        max-width:420px;
        border-radius:10px;
        transform:rotate(8deg);
        box-shadow: -15px 25px 50px rgba(0, 0, 0, 0.3), 0 0 40px rgba(255, 255, 255, 0.8);
        position:relative;
        z-index:1;
        margin-top: 30px;
        margin-right: 20px;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .hero-image:hover img {
        transform: rotate(6deg) scale(1.02);
        box-shadow: -20px 30px 60px rgba(0, 0, 0, 0.4), 0 0 60px rgba(255, 255, 255, 0.9);
    }
    
    /* ===== PARTNER SECTION ANIMATIONS ===== */
    .partner{padding:90px 0}

    .section-title{text-align:center;margin-bottom:54px}
    .section-title h2{
        font-size:54px;
        color:#0b4b73;
        margin-bottom:12px;
        animation: fadeInUp 0.8s ease-out 0.3s both;
    }
    .section-title p{
        color:#6b7280;
        font-size:20px;
        animation: fadeInUp 0.8s ease-out 0.4s both;
    }

    .partner-grid{display:grid;grid-template-columns:1fr 1fr;gap:38px;align-items:center}

    .partner-image img{
        width:100%;
        border-radius:26px;
        display:block;
        box-shadow:0 18px 40px rgba(0,0,0,.12);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        animation: imageSlideIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;
    }

    @keyframes imageSlideIn {
        0% { opacity: 0; transform: translateX(-40px); }
        100% { opacity: 1; transform: translateX(0); }
    }

    .partner-image img:hover {
        transform: scale(1.02) rotate(-1deg);
        box-shadow: 0 25px 60px rgba(11,75,115,0.15);
    }

    .partner-card{
        background:#fff;
        border:1px solid #e5e7eb;
        border-radius:22px;
        padding:40px;
        box-shadow:0 12px 32px rgba(0,0,0,.06);
        animation: modalSlideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.4s both;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes modalSlideUp {
        0% { opacity: 0; transform: translateY(40px) scale(0.95); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .partner-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(11,75,115,0.1);
        border-color: rgba(11,75,115,0.1);
    }

    .partner-card h3{
        font-size:40px;
        color:#0b4b73;
        margin-bottom:16px;
        line-height:1.1;
        transition: transform 0.3s ease;
    }

    .partner-card:hover h3 {
        transform: translateX(4px);
    }

    .partner-card p{
        color:#6b7280;
        margin-bottom:30px;
        font-size:18px;
        transition: transform 0.3s ease;
    }

    .partner-card:hover p {
        transform: translateX(3px);
    }

    .partner-card .store-buttons .store-btn{
        background:#111827;
        color:#fff;
        min-width:190px;
        box-shadow:none;
        animation: none;
    }

    .partner-card .store-buttons .store-btn::before {
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
    }

    .partner-card .store-buttons .store-btn:hover {
        background: #1a2438;
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }

    .partner-card .store-btn small{color:#cbd5e1}

    footer h3{font-size:36px}
    footer p,footer li{color:#c8d6e4}.footer-bottom{color:#c8d6e4}

    /* ===== KEYFRAME ANIMATIONS ===== */
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* ===== RESPONSIVE ===== */
    @media(max-width:992px){
        .hero-grid,.partner-grid{grid-template-columns:1fr}
        .hero{padding:70px 0}
        .hero h1{font-size:48px}
        .hero-image{order:-1}
        .hero-image img{max-width:360px}
        .section-title h2{font-size:38px}
        .partner-card h3{font-size:32px}
        .partner-image img {
            animation: fadeIn 0.8s ease-out 0.2s both;
        }
        .partner-card { animation-delay: 0.3s; }
        .store-btn:first-child { animation-delay: 0.4s; }
        .store-btn:last-child { animation-delay: 0.5s; }
    }
    @media(max-width:576px){
        .hero h1{font-size:38px}
        .hero p{font-size:18px}
        .store-btn{width:100%}
        .section-title h2{font-size:30px}
        .partner-card{padding:28px}
        .hero-image img{max-width:280px}
        .hero-image::before {
            width: 280px;
            height: 280px;
        }
        .store-btn:hover {
            transform: translateY(-3px) scale(1.01);
        }
        .partner-card:hover {
            transform: translateY(-4px);
        }
    }
</style>
@endpush

@section('content')
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="badge">
                    <span class="material-symbols-outlined">download</span>
                    The App is Here
                </span>
                <h1>Experience the Future of Mobility</h1>
                <p>Nova Mobility brings the luxury of premium intercity travel to your fingertips. Download now and redefine your journey across Myanmar.</p>
                <div class="store-buttons">
                    <!-- App Store Button -->
                    <a href="{{ $iosAppUrl }}" class="store-btn" target="_blank" rel="noopener noreferrer">
                        <div class="icon">
                            <i class="fa-brands fa-apple"></i>
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
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&amp;fit=crop&amp;w=900&amp;q=80" alt="Nova App" />
            </div>
        </div>
    </section>
    
    <section class="partner">
        <div class="container">
            <div class="section-title">
                <h2>Interested to partner with us?</h2>
                <p>Get steady income from your vehicle</p>
            </div>
            <div class="partner-grid">
                <div class="partner-image">
                    <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&amp;fit=crop&amp;w=1200&amp;q=80" alt="Driver Partner" />
                </div>
                <div class="partner-card">
                    <h3>Nova for Owners &amp; Drivers</h3>
                    <p>Manage your fleet and maximize earnings. Comprehensive dashboard, automated payouts, and route optimization.</p>
                    <div class="store-buttons">
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
                                <i class="fa-brands fa-apple"></i>
                            </div>
                            <div>
                                <small>Download on the</small>
                                <strong>App Store</strong>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection