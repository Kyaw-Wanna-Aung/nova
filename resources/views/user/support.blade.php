@extends('userlayout.app')

@section('title', 'Support - Nova Mobility')

@push('styles')
<style>
    body{background:#f3f4f6;color:#1f2937}.logo span{color:#53a7db}nav a{color:#4b5563}

    /* ===== HERO SECTION ANIMATIONS ===== */
    .hero{
        background:linear-gradient(135deg,#073b63,#094776,#357cb1);
        color:#fff;
        padding:90px 0;
        text-align:center;
        margin:0;
        border-radius:0;
        height:auto;
        position:relative;
        overflow:hidden;
    }

    /* Hero background pulse animation */
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
        z-index:1;
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
        z-index:1;
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
        z-index:1;
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
    }

    /* Button shine effect */
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

    /* ===== SUPPORT CARDS ===== */
    .support-cards{padding:70px 0 30px}
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
    }

    /* Stagger delays for cards */
    .card:nth-child(1) { animation-delay: 0s; }
    .card:nth-child(2) { animation-delay: 0.1s; }
    .card:nth-child(3) { animation-delay: 0.2s; }

    @keyframes modalSlideUp {
        0% { opacity: 0; transform: translateY(40px) scale(0.95); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Card hover effects */
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(11,75,115,0.1);
        border-color: rgba(11,75,115,0.15);
    }

    /* Shine effect on card */
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
    }

    .card:hover .icon {
        transform: scale(1.1) rotate(-5deg);
        background: #0b4b73;
        color: #fff;
        box-shadow: 0 10px 30px rgba(11,75,115,0.2);
    }

    .card h3{
        color:#0b4b73;
        font-size:34px;
        margin-bottom:14px;
        transition: transform 0.3s ease;
    }

    .card:hover h3 {
        transform: translateY(-2px);
    }

    .card p{
        color:#6b7280;
        margin-bottom:22px;
        font-size:16px;
        transition: transform 0.3s ease;
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
    }

    /* Button shine effect for support buttons */
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
        display:inline-block;
        text-decoration:none;
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
    }

    .map-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 12px 30px rgba(11,75,115,0.15);
        background: #0b4b73;
        color: #fff;
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
        display:inline-block;
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

    /* Button shine effect */
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
    }
    @media(max-width:576px){
        .hero{padding:70px 0}
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
    }
</style>
@endpush
    
@section('content')
    <section class="hero">
        <div class="container">
            <h1>Help Center</h1>
            <p>We're here to ensure your journey is seamless. Find answers or reach out to our dedicated support team.</p>
            <form method="GET" action="{{ route('support') }}" class="search-box">
                <input name="search" value="{{ $search }}" type="search" placeholder="How can we help you today?" />
                <button type="submit" aria-label="Search FAQs">🔍</button>
            </form>
        </div>
    </section>

    <section class="support-cards">
        <div class="container card-grid">
            <div class="card">
                <div class="icon">💬</div>
                <h3>Live Support</h3>
                <p>Connect with us instantly via Viber or WhatsApp for real-time assistance.</p>
                <a href="{{ route('support') }}#contact" class="support-btn viber">📱 Viber Support</a>
                <a href="{{ route('support') }}#contact" class="support-btn whatsapp">📞 WhatsApp Support</a>
            </div>
            <div class="card">
                <div class="icon">✉️</div>
                <h3>Email Inquiry</h3>
                <p>Prefer writing? Our team typically responds within 2 business hours.</p>
                <a href="mailto:support@novamobility.com" class="email">support@novamobility.com</a>
            </div>
            <div class="card" id="contact">
                <div class="icon">📍</div>
                <h3>Main Hub</h3>
                <p>Visit our flagship terminal for ticketing and premium lounge services.</p>
                <div class="address">No. 124, Pyay Road,<br>Mayangone Township, Yangon.</div>
                <div class="map-box">
                    <a href="{{ route('support') }}#contact" class="map-btn">View on Map</a>
                </div>
            </div>
        </div>
    </section>

    <section class="faq">
        <div class="container">
            <h2>Frequently Asked Questions</h2>
            @forelse ($faqs->groupBy('category') as $category => $categoryFaqs)
                <div class="faq-section">
                    <h3>{{ $category === 'Billing' ? '💳' : ($category === 'Technical' ? '🚌' : '🛡️') }} {{ $category }}</h3>
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
                <a href="{{ route('support') }}#contact" class="agent-btn">Talk to an Agent</a>
            </div>
        </div>
    </section>
@endsection