@extends('userlayout.app')

@section('title', 'Support - Nova Mobility')

@push('styles')
<style>
    body{background:#f3f4f6;color:#1f2937}.logo span{color:#53a7db}nav a{color:#4b5563}

    /* ===== MATERIAL SYMBOLS SETUP ===== */
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;
        font-size: inherit;
        line-height: 1;
        display: inline-flex;
        vertical-align: middle;
    }

    /* ===== HERO SECTION ANIMATIONS ===== */
    .hero{
        background:linear-gradient(135deg,#073b63,#094776,#357cb1);
        color:#fff;
        padding:90px 0;
        text-align:center;
        margin:0;
        border-radius:0;
        height:auto;
        min-height:500px;
        position:relative;
        overflow:hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at center, rgba(255,255,255,0.03), transparent 60%);
        animation: heroPulse 6s ease-in-out infinite;
        pointer-events: none;
        z-index: 0;
    }

    @keyframes heroPulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 1; }
    }

    .hero h1{
        font-size:72px;
        font-weight:800;
        margin-bottom:18px;
        animation: heroTitle 1s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        opacity: 0;
        transform: translateY(-30px);
        position:relative;
        z-index:2;
    }

    @keyframes heroTitle {
        0% { opacity: 0; transform: translateY(-30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .hero p{
        max-width:720px;
        margin:0 auto 40px;
        color:#d7e7f5;
        font-size:20px;
        animation: heroDesc 1s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s forwards;
        opacity: 0;
        transform: translateY(20px);
        position:relative;
        z-index:2;
    }

    @keyframes heroDesc {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .search-box{
        max-width:620px;
        margin:0 auto;
        display:flex;
        background:#fff;
        border-radius:16px;
        overflow:hidden;
        box-shadow:0 12px 30px rgba(0,0,0,.18);
        animation: searchBox 1s cubic-bezier(0.34, 1.56, 0.64, 1) 0.4s forwards;
        opacity: 0;
        transform: translateY(30px);
        position:relative;
        z-index:2;
    }

    @keyframes searchBox {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .search-box input{
        flex:1;
        border:none;
        padding:18px 22px;
        font-size:16px;
        outline:none;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        background: #f8fafc;
    }

    .search-box button{
        width:70px;
        border:none;
        background:#0b4b73;
        color:#fff;
        font-size:22px;
        cursor:pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position:relative;
        overflow:hidden;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .search-box button .material-symbols-outlined {
        font-size: 28px;
    }

    .search-box button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .search-box button:hover::before {
        left: 100%;
    }

    .search-box button:hover {
        transform: scale(1.05);
        background: #063857;
    }

    /* ===== TAXI CAR ANIMATIONS ===== */
    .taxi-container {
        position: absolute;
        top: 10px;
        left: 0;
        width: 100%;
        height: 200px;
        z-index: 1;
        pointer-events: none;
        overflow: hidden;
    }

    .taxi {
        position: absolute;
        font-size: 48px;
        animation-duration: 15s;
        animation-timing-function: linear;
        animation-fill-mode: forwards;
        animation-iteration-count: 1;
        filter: drop-shadow(0 4px 12px rgba(0,0,0,0.3));
        opacity: 0;
        color: #194464;
    }

    /* Car 1: Left to Right - Car faces Right */
    .taxi-1 {
        top: 5px;
        animation-name: taxiLeftToRight;
        animation-delay: 0s;
    }
    .taxi-1 i {
        transform: scaleX(1);
    }

    /* Car 2: Right to Left - Car faces Left */
    .taxi-2 {
        top: 50px;
        animation-name: taxiRightToLeft;
        animation-delay: 1.5s;
    }
    .taxi-2 i {
        transform: scaleX(-1);
    }

    /* Car 3: Left to Right - Car faces Right */
    .taxi-3 {
        top: 95px;
        animation-name: taxiLeftToRight;
        animation-delay: 3s;
    }
    .taxi-3 i {
        transform: scaleX(1);
    }

    /* Car 4: Right to Left - Car faces Left */
    .taxi-4 {
        top: 140px;
        animation-name: taxiRightToLeft;
        animation-delay: 4.5s;
    }
    .taxi-4 i {
        transform: scaleX(-1);
    }

    @keyframes taxiLeftToRight {
        0% { 
            left: -80px; 
            opacity: 0;
        }
        3% { 
            opacity: 1; 
        }
        90% { 
            opacity: 1; 
        }
        100% { 
            left: calc(100% + 20px); 
            opacity: 0;
        }
    }

    @keyframes taxiRightToLeft {
        0% { 
            right: -80px; 
            opacity: 0;
        }
        3% { 
            opacity: 1; 
        }
        90% { 
            opacity: 1; 
        }
        100% { 
            right: calc(100% + 20px); 
            opacity: 0;
        }
    }

    /* ===== SUPPORT CARDS ===== */
    .support-cards{padding:70px 0 30px; position:relative; overflow:hidden;}
    .card-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}

    .card{
        background:#fff;
        border-radius:22px;
        padding:36px;
        box-shadow:0 12px 32px rgba(0,0,0,.06);
        text-align:center;
        border:1px solid #e5e7eb;
        animation: modalSlideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        opacity: 0;
        transform: translateY(40px) scale(0.95);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position:relative;
        overflow:hidden;
        cursor:default;
        min-height: 380px;
    }

    .card:nth-child(1) { animation-delay: 0s; }
    .card:nth-child(2) { animation-delay: 0.1s; }
    .card:nth-child(3) { animation-delay: 0.2s; }

    @keyframes modalSlideUp {
        0% { opacity: 0; transform: translateY(40px) scale(0.95); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(7, 59, 99, 0.1);
        border-color: rgba(7, 59, 99, 0.15);
    }

    .card::before {
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

    .card:hover::before {
        left: 100%;
    }

    .icon{
        width:72px;
        height:72px;
        border-radius:50%;
        background:#e8f1fa;
        color:#0b4b73;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:32px;
        margin:0 auto 20px;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        position:relative;
        z-index:2;
    }

    .icon .material-symbols-outlined {
        font-size: 36px;
    }

    .card:hover .icon {
        transform: scale(1.1) rotate(-5deg);
        background: #0b4b73;
        color: #fff;
        box-shadow: 0 10px 30px rgba(7, 59, 99, 0.2);
    }

    .card h3{
        color:#0b4b73;
        font-size:34px;
        margin-bottom:14px;
        transition: transform 0.3s ease;
        position:relative;
        z-index:2;
    }

    .card:hover h3 {
        transform: translateY(-2px);
    }

    .card p{
        color:#6b7280;
        margin-bottom:22px;
        font-size:16px;
        transition: transform 0.3s ease;
        position:relative;
        z-index:2;
    }

    .card:hover p {
        transform: translateY(-2px);
    }

    .support-btn{
        display:block;
        padding:14px 18px;
        border-radius:12px;
        margin-bottom:12px;
        font-weight:600;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position:relative;
        overflow:hidden;
        text-decoration:none;
        z-index:2;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:10px;
    }

    .support-btn .material-symbols-outlined {
        font-size: 22px;
    }

    .support-btn::before {
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

    .support-btn:hover::before {
        left: 100%;
    }

    .support-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .viber{background:#efeafe;color:#4f46e5}
    .viber:hover{background:#e0d9f5}
    .whatsapp{background:#e8f8ef;color:#047857}
    .whatsapp:hover{background:#d0f0df}

    .email{
        color:#0b4b73;
        font-weight:700;
        font-size:18px;
        transition: all 0.3s ease;
        display:inline-flex;
        align-items:center;
        gap:8px;
        text-decoration:none;
        position:relative;
        z-index:2;
    }

    .email .material-symbols-outlined {
        font-size: 24px;
    }

    .email:hover {
        color: #063857;
        transform: translateX(4px);
    }

    .address{
        color:#374151;
        font-weight:500;
        margin:18px 0 22px;
        transition: all 0.3s ease;
        position:relative;
        z-index:2;
    }

    .card:hover .address {
        color: #0b4b73;
    }

    .map-box{
        background:#eef2f7;
        border-radius:16px;
        height:140px;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#6b7280;
        font-weight:600;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        overflow:hidden;
        position:relative;
        z-index:2;
    }

    .map-box::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(11,75,115,0.05), transparent);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .map-box:hover::before {
        opacity: 1;
    }

    .map-box:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 30px rgba(11,75,115,0.08);
    }

    .map-btn{
        background:#fff;
        color:#0b4b73;
        padding:12px 20px;
        border-radius:999px;
        font-weight:700;
        box-shadow:0 6px 16px rgba(0,0,0,.08);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-decoration:none;
        position:relative;
        z-index:1;
        display:inline-flex;
        align-items:center;
        gap:8px;
    }

    .map-btn .material-symbols-outlined {
        font-size: 22px;
    }

    .map-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 12px 30px rgba(11,75,115,0.15);
        background: #0b4b73;
        color: #fff;
    }

    /* ===== ICON DROP ANIMATIONS - Only on hover, but don't stop ===== */
    .drop-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
        z-index: 0;
        border-radius: 22px;
    }

    .drop-icon {
        position: absolute;
        font-size: 22px;
        opacity: 0;
        top: -30px;
        animation: none;
    }

    .drop-icon .material-symbols-outlined {
        font-size: inherit;
    }

    /* Icons animate only when card is hovered */
    .card:hover .drop-icon {
        animation: dropDown 3.5s ease-in infinite;
    }

    @keyframes dropDown {
        0% {
            transform: translateY(0px) scale(0.5) rotate(0deg);
            opacity: 0;
        }
        10% {
            opacity: 1;
            transform: translateY(10px) scale(1) rotate(5deg);
        }
        90% {
            opacity: 1;
        }
        100% {
            transform: translateY(calc(100% + 50px)) scale(0.8) rotate(-10deg);
            opacity: 0;
        }
    }

    /* Different colors for different cards */
    .card:nth-child(1) .drop-icon {
        color: #0b4b73;
        font-size: 20px;
    }

    .card:nth-child(2) .drop-icon {
        color: #0b4b73;
        font-size: 20px;
    }

    .card:nth-child(3) .drop-icon {
        color: #0b4b73;
        font-size: 22px;
    }

    /* ===== FAQ SECTION ===== */
    .faq{
        background:#eef2f5;
        padding:80px 0;
        position:relative;
        overflow:hidden;
        animation: fadeIn 0.8s ease-out forwards;
        opacity: 0;
    }

    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    .faq::after{
        content:"";
        position:absolute;
        top:-120px;
        right:-140px;
        width:420px;
        height:900px;
        background:rgba(255,255,255,.4);
        transform:rotate(12deg);
        border-radius:120px;
        animation: floatBg 10s ease-in-out infinite;
    }

    @keyframes floatBg {
        0%, 100% { transform: rotate(12deg) translateX(0); }
        50% { transform: rotate(14deg) translateX(20px); }
    }

    .faq .container{
        position:relative;
        z-index:1;
        max-width:900px;
    }

    .faq h2{
        text-align:center;
        color:#0b4b73;
        font-size:60px;
        margin-bottom:40px;
        animation: fadeInUp 0.8s ease-out 0.3s both;
    }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .faq-section{
        margin-bottom:34px;
        animation: fadeInUp 0.8s ease-out 0.5s both;
    }

    .faq-section:nth-child(1) { animation-delay: 0.3s; }
    .faq-section:nth-child(2) { animation-delay: 0.4s; }
    .faq-section:nth-child(3) { animation-delay: 0.5s; }

    .faq-section h3{
        color:#0b4b73;
        font-size:28px;
        margin-bottom:18px;
        display:flex;
        align-items:center;
        gap:10px;
        transition: transform 0.3s ease;
    }

    .faq-section h3 .material-symbols-outlined {
        font-size: 32px;
    }

    .faq-section:hover h3 {
        transform: translateX(6px);
    }

    details{
        background:#fff;
        border-radius:16px;
        margin-bottom:16px;
        border:1px solid #e5e7eb;
        overflow:hidden;
        box-shadow:0 6px 18px rgba(0,0,0,.04);
        transition: all 0.3s ease;
    }

    details:hover {
        box-shadow: 0 10px 30px rgba(11,75,115,0.06);
        border-color: rgba(11,75,115,0.1);
    }

    summary{
        list-style:none;
        cursor:pointer;
        padding:20px 22px;
        font-weight:600;
        color:#0b4b73;
        position:relative;
        transition: all 0.3s ease;
    }

    summary::-webkit-details-marker{display:none}
    summary::after{
        content:"+";
        position:absolute;
        right:22px;
        top:20px;
        font-size:24px;
        color:#6b7280;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    details[open] summary::after{
        content:"−";
        transform: rotate(0deg);
    }

    summary:hover {
        background: #f8fafc;
    }

    details[open] summary {
        background: #f0f4f8;
    }

    details p{
        padding:0 22px 22px;
        color:#6b7280;
        animation: answerFade 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes answerFade {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .agent{
        text-align:center;
        margin-top:34px;
        animation: fadeInUp 0.8s ease-out 0.7s both;
    }

    .agent p{
        color:#6b7280;
        margin-bottom:18px;
        transition: transform 0.3s ease;
    }

    .agent:hover p {
        transform: translateY(-2px);
    }

    .agent-btn{
        display:inline-flex;
        align-items:center;
        gap:10px;
        background:#0b4b73;
        color:#fff;
        padding:16px 34px;
        border-radius:12px;
        font-weight:700;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-decoration:none;
        position:relative;
        overflow:hidden;
    }

    .agent-btn .material-symbols-outlined {
        font-size: 24px;
    }

    .agent-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .agent-btn:hover::before {
        left: 100%;
    }

    .agent-btn:hover{
        background:#063857;
        transform: translateY(-4px) scale(1.03);
        box-shadow: 0 15px 40px rgba(11,75,115,0.25);
    }

    footer h3{font-size:36px}
    footer p,footer li,.footer-bottom{color:#c8d6e4}

    /* ===== RESPONSIVE ===== */
    @media(max-width:992px){
        .card-grid{grid-template-columns:1fr}
        .hero h1{font-size:48px}
        .faq h2{font-size:40px}
        .card h3{font-size:28px}
        .card:nth-child(1) { animation-delay: 0s; }
        .card:nth-child(2) { animation-delay: 0.08s; }
        .card:nth-child(3) { animation-delay: 0.16s; }
        .taxi { font-size: 36px !important; }
        .taxi-container { height: 160px; top: 5px; }
        .taxi-1 { top: 5px; }
        .taxi-2 { top: 42px; }
        .taxi-3 { top: 78px; }
        .taxi-4 { top: 114px; }
        .taxi i { font-size: 36px !important; }
        .drop-icon { font-size: 18px !important; }
    }
    @media(max-width:576px){
        .hero{padding:70px 0; min-height:400px;}
        .hero h1{font-size:38px}
        .hero p{font-size:18px}
        .search-box{flex-direction:column}
        .search-box button{width:100%;padding:14px 0}
        .faq h2{font-size:32px}
        .card:hover {
            transform: translateY(-5px);
        }
        .support-btn:hover {
            transform: translateY(-2px) scale(1.01);
        }
        .agent-btn:hover {
            transform: translateY(-3px) scale(1.02);
        }
        .taxi-container { height: 120px; top: 5px; }
        .taxi-1 { top: 5px; }
        .taxi-2 { top: 32px; }
        .taxi-3 { top: 58px; }
        .taxi-4 { top: 84px; }
        .taxi i { font-size: 26px !important; }
        .drop-icon { font-size: 14px !important; }
        .card { min-height: 320px; padding: 24px; }
    }
</style>
@endpush
    
@section('content')
    <section class="hero">
        <!-- ===== 4 TAXI CARS ===== -->
        <div class="taxi-container">
            <!-- Car 1: Left to Right - White, faces Right -->
            <div class="taxi taxi-1">
                <i class="fa-solid fa-car-side"></i>
            </div>
            
            <!-- Car 2: Right to Left - White, faces Left -->
            <div class="taxi taxi-2">
                <i class="fa-solid fa-car-side"></i>
            </div>
            
            <!-- Car 3: Left to Right - White, faces Right -->
            <div class="taxi taxi-3">
                <i class="fa-solid fa-car-side"></i>
            </div>
            
            <!-- Car 4: Right to Left - White, faces Left -->
            <div class="taxi taxi-4">
                <i class="fa-solid fa-car-side"></i>
            </div>
        </div>

        <div class="container" style="position:relative;z-index:2;">
            <h1>Help Center</h1>
            <p>We're here to ensure your journey is seamless. Find answers or reach out to our dedicated support team.</p>
            <form method="GET" action="{{ route('support') }}" class="search-box">
                <input name="search" value="{{ $search }}" type="search" placeholder="How can we help you today?" />
                <button type="submit" aria-label="Search FAQs">
                    <span class="material-symbols-outlined">search</span>
                </button>
            </form>
        </div>
    </section>

    <section class="support-cards">
        <div class="container card-grid">
            <!-- ===== CARD 1: Live Support - Icons drop on hover, don't stop ===== -->
            <div class="card">
                <div class="drop-container">
                    <span class="drop-icon" style="left:15%;animation-delay:0s;"><span class="material-symbols-outlined">chat</span></span>
                    <span class="drop-icon" style="left:40%;animation-delay:0.7s;"><span class="material-symbols-outlined">forum</span></span>
                    <span class="drop-icon" style="left:65%;animation-delay:1.4s;"><span class="material-symbols-outlined">chat</span></span>
                    <span class="drop-icon" style="left:30%;animation-delay:2.1s;"><span class="material-symbols-outlined">call</span></span>
                    <span class="drop-icon" style="left:80%;animation-delay:2.8s;"><span class="material-symbols-outlined">forum</span></span>
                    <span class="drop-icon" style="left:20%;animation-delay:3.5s;"><span class="material-symbols-outlined">chat</span></span>
                    <span class="drop-icon" style="left:55%;animation-delay:4.2s;"><span class="material-symbols-outlined">call</span></span>
                    <span class="drop-icon" style="left:90%;animation-delay:4.9s;"><span class="material-symbols-outlined">chat</span></span>
                </div>
                <div class="icon" style="position:relative;z-index:2;">
                    <span class="material-symbols-outlined">chat</span>
                </div>
                <h3 style="position:relative;z-index:2;">Live Support</h3>
                <p style="position:relative;z-index:2;">Connect with us instantly via Viber or WhatsApp for real-time assistance.</p>
                <a href="{{ route('support') }}#contact" class="support-btn viber" style="position:relative;z-index:2;">
                    <span class="material-symbols-outlined">chat</span>
                    Viber Support
                </a>
                <a href="{{ route('support') }}#contact" class="support-btn whatsapp" style="position:relative;z-index:2;">
                    <span class="material-symbols-outlined">forum</span>
                    WhatsApp Support
                </a>
            </div>

            <!-- ===== CARD 2: Email Inquiry - Icons drop on hover, don't stop ===== -->
            <div class="card">
                <div class="drop-container">
                    <span class="drop-icon" style="left:20%;animation-delay:0.3s;"><span class="material-symbols-outlined">mail</span></span>
                    <span class="drop-icon" style="left:50%;animation-delay:1.0s;"><span class="material-symbols-outlined">mail</span></span>
                    <span class="drop-icon" style="left:75%;animation-delay:1.7s;"><span class="material-symbols-outlined">mail</span></span>
                    <span class="drop-icon" style="left:35%;animation-delay:2.4s;"><span class="material-symbols-outlined">mail</span></span>
                    <span class="drop-icon" style="left:60%;animation-delay:3.1s;"><span class="material-symbols-outlined">mail</span></span>
                    <span class="drop-icon" style="left:85%;animation-delay:3.8s;"><span class="material-symbols-outlined">mail</span></span>
                    <span class="drop-icon" style="left:45%;animation-delay:4.5s;"><span class="material-symbols-outlined">mail</span></span>
                    <span class="drop-icon" style="left:15%;animation-delay:5.2s;"><span class="material-symbols-outlined">mail</span></span>
                </div>
                <div class="icon" style="position:relative;z-index:2;">
                    <span class="material-symbols-outlined">mail</span>
                </div>
                <h3 style="position:relative;z-index:2;">Email Inquiry</h3>
                <p style="position:relative;z-index:2;">Prefer writing? Our team typically responds within 2 business hours.</p>
                <a href="mailto:support@novamobility.com" class="email" style="position:relative;z-index:2;">
                    <span class="material-symbols-outlined">mail</span>
                    support@novamobility.com
                </a>
            </div>

            <!-- ===== CARD 3: Location - Icons drop on hover, don't stop ===== -->
            <div class="card" id="contact">
                <div class="drop-container">
                    <span class="drop-icon" style="left:25%;animation-delay:0.6s;"><span class="material-symbols-outlined">security</span></span>
                    <span class="drop-icon" style="left:55%;animation-delay:1.3s;"><span class="material-symbols-outlined">payments</span></span>
                    <span class="drop-icon" style="left:85%;animation-delay:2.0s;"><span class="material-symbols-outlined">security</span></span>
                    <span class="drop-icon" style="left:45%;animation-delay:2.7s;"><span class="material-symbols-outlined">payments</span></span>
                    <span class="drop-icon" style="left:70%;animation-delay:3.4s;"><span class="material-symbols-outlined">security</span></span>
                    <span class="drop-icon" style="left:35%;animation-delay:4.1s;"><span class="material-symbols-outlined">payments</span></span>
                    <span class="drop-icon" style="left:65%;animation-delay:4.8s;"><span class="material-symbols-outlined">security</span></span>
                    <span class="drop-icon" style="left:90%;animation-delay:5.5s;"><span class="material-symbols-outlined">payments</span></span>
                </div>
                <div class="icon" style="position:relative;z-index:2;">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <h3 style="position:relative;z-index:2;">Main Hub</h3>
                <p style="position:relative;z-index:2;">Visit our flagship terminal for ticketing and premium lounge services.</p>
                <div class="address" style="position:relative;z-index:2;">No. 124, Pyay Road,<br>Mayangone Township, Yangon.</div>
                <div class="map-box" style="position:relative;z-index:2;">
                    <a href="{{ route('support') }}#contact" class="map-btn">
                        <span class="material-symbols-outlined">location_on</span>
                        View on Map
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="faq">
        <div class="container">
            <h2>Frequently Asked Questions</h2>
            @forelse ($faqs->groupBy('category') as $category => $categoryFaqs)
                <div class="faq-section">
                    <h3>
                        @if($category === 'Billing')
                            <span class="material-symbols-outlined">payments</span>
                        @elseif($category === 'Technical')
                            <span class="material-symbols-outlined">security</span>
                        @else
                            <span class="material-symbols-outlined">chat</span>
                        @endif
                        {{ $category }}
                    </h3>
                    @foreach ($categoryFaqs as $faq)
                        <details>
                            <summary>{{ $faq->question }}</summary>
                            <p>{{ $faq->answer }}</p>
                        </details>
                    @endforeach
                </div>
            @empty
                <div class="faq-section"><h3>No FAQs found</h3></div>
            @endforelse
            <div class="agent">
                <p>Can't find what you're looking for?</p>
                <a href="{{ route('support') }}#contact" class="agent-btn">
                    <span class="material-symbols-outlined">chat</span>
                    Talk to an Agent
                </a>
            </div>
        </div>
    </section>

    <!-- ===== JavaScript to restart taxi animation ===== -->
    <script>
        function restartTaxiAnimation() {
            const taxis = document.querySelectorAll('.taxi');
            taxis.forEach(taxi => {
                // Reset animation
                taxi.style.animation = 'none';
                taxi.style.opacity = '0';
                // Force reflow
                void taxi.offsetWidth;
                // Reapply animation
                taxi.style.animation = '';
                taxi.style.opacity = '';
            });
        }

        // Initial start after page loads
        setTimeout(restartTaxiAnimation, 500);

        // Restart every 30 seconds (15s drive + 15s stop)
        let restartInterval = setInterval(restartTaxiAnimation, 30000);
    </script>
@endsection