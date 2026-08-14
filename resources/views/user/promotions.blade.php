@extends('userlayout.app')

@section('title', 'Promotions - Nova Mobility')

@push('styles')
<style>
    body{background:#f3f4f6;color:#1f2937}.logo span{color:#53a7db}nav a{color:#4b5563}.hero{padding:40px 0;margin:0;border-radius:0;height:auto;background:none}.hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:32px}

    /* ===== MATERIAL SYMBOLS SETUP ===== */
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;
        font-size: inherit;
        line-height: 1;
        display: inline-block;
        vertical-align: middle;
    }

    /* ===== PROMO CARD WITH FLASHLIGHT EFFECT (MORE BRIGHT) ===== */
    .promo-card{
        background:#1b517d;
        color:#fff;
        border-radius:28px;
        padding:42px;
        min-height:520px;
        display:flex;
        flex-direction:column;
        justify-content:space-between;
        box-shadow:0 20px 50px rgba(0,0,0,.08);
        animation: modalSlideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position:relative;
        overflow:hidden;
        cursor:pointer;
    }

    /* Flashlight effect - appears from top (MORE BRIGHT) */
    .promo-card::before {
        content: '';
        position: absolute;
        top: -100%;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, 
            rgba(255,255,255,0.5) 0%, 
            rgba(255,255,255,0.3) 30%, 
            rgba(255,255,255,0.1) 60%, 
            transparent 100%
        );
        pointer-events: none;
        opacity: 0;
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        z-index: 2;
        border-radius: 28px;
    }

    .promo-card:hover::before {
        opacity: 1;
        top: 0;
    }

    /* Second flashlight layer - angled for flashlight effect (MORE BRIGHT) */
    .promo-card::after {
        content: '';
        position: absolute;
        top: -150%;
        left: -20%;
        width: 140%;
        height: 200%;
        background: radial-gradient(ellipse at 30% 0%, 
            rgba(255,255,255,0.35) 0%, 
            rgba(255,255,255,0.2) 30%, 
            transparent 70%
        );
        pointer-events: none;
        opacity: 0;
        transition: all 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
        z-index: 2;
        border-radius: 50%;
        transform: rotate(-15deg);
    }

    .promo-card:hover::after {
        opacity: 1;
        top: 0;
        transform: rotate(-15deg) scale(1.1);
    }

    /* All text inside promo-card turns #4bd2fc on hover */
    .promo-card:hover .promo-badge,
    .promo-card:hover h1,
    .promo-card:hover p,
    .promo-card:hover strong,
    .promo-card:hover .feature h4,
    .promo-card:hover .feature span,
    .promo-card:hover .feature .icon {
        color: #4bd2fc !important;
        transition: color 0.4s ease;
    }

    .promo-card:hover .promo-badge {
        color: #4bd2fc !important;
    }

    .promo-card:hover .feature .icon {
        background: rgba(75, 210, 252, 0.15);
        color: #4bd2fc !important;
    }

    .promo-card:hover .claim-btn {
        background: #4bd2fc;
        color: #073b63 !important;
    }

    /* Ensure text stays above the light effect */
    .promo-card > * {
        position: relative;
        z-index: 3;
    }

    .promo-badge{
        display:inline-flex;
        align-items:center;
        gap:8px;
        color:#b7d5ef;
        font-size:13px;
        letter-spacing:1px;
        text-transform:uppercase;
        margin-bottom:20px;
        transition: all 0.4s ease;
        animation: fadeInDown 0.8s ease-out 0.2s both;
    }

    .promo-badge .material-symbols-outlined {
        font-size: 20px;
    }

    .promo-card h1{
        font-size:58px;
        line-height:1.05;
        font-weight:800;
        margin-bottom:22px;
        animation: fadeInUp 0.8s ease-out 0.4s both;
        transition: color 0.4s ease, transform 0.3s ease;
    }

    .promo-card:hover h1 {
        transform: translateX(4px);
    }

    .promo-card p{
        color:#d7e7f5;
        font-size:18px;
        margin-bottom:26px;
        animation: fadeInUp 0.8s ease-out 0.6s both;
        transition: color 0.4s ease, transform 0.3s ease;
    }

    .promo-card:hover p {
        transform: translateX(3px);
    }

    .promo-card strong{color:#fff;letter-spacing:1px;transition: color 0.4s ease}

    .features{
        display:flex;
        gap:28px;
        margin:10px 0 34px;
        flex-wrap:wrap;
    }
    .feature{
        display:flex;
        align-items:center;
        gap:12px;
        color:#d7e7f5;
        animation: fadeInUp 0.8s ease-out 0.8s both;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        padding: 8px 12px;
        border-radius: 12px;
        cursor: default;
    }

    .feature .icon{
        width:44px;
        height:44px;
        border-radius:50%;
        background:rgba(255,255,255,.12);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:20px;
        margin:0;
        color:inherit;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .feature .icon .material-symbols-outlined {
        font-size: 24px;
    }

    .claim-btn{
        align-self:flex-start;
        background:#fff;
        color:#0b4b73;
        padding:14px 28px;
        border-radius:999px;
        font-weight:700;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-decoration:none;
        animation: fadeInUp 0.8s ease-out 1s both;
        position:relative;
        overflow:hidden;
        z-index: 3;
    }

    .claim-btn:hover{
        transform: translateY(-4px) scale(1.03);
        box-shadow: 0 15px 40px rgba(255,255,255,0.2);
    }

    /* ===== HERO IMAGE WITH TRANSPARENT OVERLAY ===== */
    .hero-image{
        position:relative;
        border-radius:28px;
        overflow:hidden;
        min-height:520px;
        box-shadow:0 20px 50px rgba(0,0,0,.12);
        animation: modalSlideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .hero-image:hover {
        transform: translateY(-4px) scale(1.005);
        box-shadow: 0 30px 70px rgba(0,0,0,0.18);
    }

    .hero-image img{
        width:100%;
        height:100%;
        object-fit:cover;
        display:block;
        transition: transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .hero-image:hover img {
        transform: scale(1.03);
    }

    /* Transparent overlay - glass morphism */
    .image-overlay{
        position:absolute;
        right:22px;
        bottom:22px;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        padding:24px;
        border-radius:20px;
        max-width:300px;
        box-shadow:0 10px 24px rgba(0,0,0,.12);
        animation: modalSlideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.4s both;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: default;
        border: 1px solid rgba(255,255,255,0.15);
    }

    .image-overlay:hover {
        transform: scale(1.03) translateY(-4px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        background: rgba(255,255,255,0.2);
    }

    .image-overlay h3{
        color:#fff;
        font-size:34px;
        margin-bottom:10px;
        line-height:1.1;
        transition: transform 0.3s ease;
        text-shadow: 0 2px 20px rgba(0,0,0,0.1);
    }

    .image-overlay:hover h3 {
        transform: translateX(4px);
    }

    .image-overlay p{
        color:rgba(255,255,255,0.85);
        font-size:16px;
        text-shadow: 0 1px 10px rgba(0,0,0,0.05);
    }

    /* ===== SECTION HEADER WITH VIEW ALL ON RIGHT ===== */
    .section-header{
        display:flex;
        justify-content:space-between;
        align-items:flex-end;
        gap:20px;
        margin-bottom:30px;
    }

    .section-header h2{
        color:#27292b;
        font-size:40px;
        line-height:1.1;
        margin:0;
    }

    .section-header p{
        color:#6b7280;
        margin-top:10px;
    }

    .view-all{
        color: #0b4b73;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        transition: opacity 0.2s;
    }
    .view-all:hover{opacity: 0.8;}

    /* ===== ROUTE CARD WITH CAR ICON ANIMATION (7 SECONDS) ===== */
    .route-card{
        background:#fff;
        border:1px solid #e5e7eb;
        border-radius:22px;
        display:flex;
        align-items:stretch;
        margin-bottom:22px;
        box-shadow:0 10px 24px rgba(0,0,0,.04);
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        overflow:hidden;
        min-height:160px;
        animation: modalSlideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        position:relative;
    }

    /* Stagger delays for route cards */
    .route-card:nth-child(1) { animation-delay: 0s; }
    .route-card:nth-child(2) { animation-delay: 0.08s; }
    .route-card:nth-child(3) { animation-delay: 0.16s; }
    .route-card:nth-child(4) { animation-delay: 0.24s; }
    .route-card:nth-child(5) { animation-delay: 0.32s; }

    /* Car icon animation - 7 seconds */
    .route-card .car-icon {
        position: absolute;
        bottom: 8px;
        right: -60px;
        font-size: 28px;
        z-index: 3;
        opacity: 0;
        transform: translateX(0);
        transition: none;
        pointer-events: none;
        filter: drop-shadow(0 2px 10px rgba(11,75,115,0.2));
    }

    .route-card:hover .car-icon {
        animation: carMoveRightToLeft 7s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        opacity: 1;
    }

    @keyframes carMoveRightToLeft {
        0% {
            right: -60px;
            opacity: 0;
            transform: scale(0.8) rotate(0deg);
        }
        5% {
            opacity: 1;
            transform: scale(1) rotate(-3deg);
        }
        20% {
            transform: scale(1.05) rotate(3deg);
        }
        40% {
            transform: scale(1) rotate(-2deg);
        }
        60% {
            transform: scale(1.02) rotate(2deg);
        }
        80% {
            transform: scale(1) rotate(-1deg);
        }
        95% {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }
        100% {
            right: 110%;
            opacity: 0;
            transform: scale(0.9) rotate(0deg);
        }
    }

    /* Second car icon with delay (7 seconds) */
    .route-card .car-icon-2 {
        position: absolute;
        bottom: 8px;
        right: -60px;
        font-size: 22px;
        z-index: 3;
        opacity: 0;
        transform: translateX(0);
        transition: none;
        pointer-events: none;
        filter: drop-shadow(0 2px 10px rgba(11,75,115,0.15));
    }

    .route-card:hover .car-icon-2 {
        animation: carMoveRightToLeft2 7.3s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s forwards;
        opacity: 1;
    }

    @keyframes carMoveRightToLeft2 {
        0% {
            right: -60px;
            opacity: 0;
            transform: scale(0.7) rotate(5deg);
        }
        5% {
            opacity: 1;
            transform: scale(0.9) rotate(-2deg);
        }
        30% {
            transform: scale(1) rotate(2deg);
        }
        60% {
            transform: scale(0.95) rotate(-1deg);
        }
        85% {
            opacity: 1;
            transform: scale(0.9) rotate(1deg);
        }
        100% {
            right: 110%;
            opacity: 0;
            transform: scale(0.7) rotate(0deg);
        }
    }

    .route-card:hover{
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(11,75,115,0.12);
        border-color: rgba(11,75,115,0.1);
    }
    
    .route-image{
        width:200px;
        flex-shrink:0;
        position:relative;
        overflow:hidden;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .route-card:hover .route-image {
        transform: scale(1.02);
    }

    .route-image img{
        width:100%;
        height:100%;
        object-fit:cover;
        display:block;
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .route-card:hover .route-image img {
        transform: scale(1.05);
    }
    
    .route-body{
        flex:1;
        padding:18px 22px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:16px;
        transition: all 0.3s ease;
        position:relative;
        overflow:hidden;
    }
    .route-info{flex:1}
    .route-info h3{
        color:#0b4b73;
        font-size:24px;
        margin:0 0 4px 0;
        line-height:1.2;
        font-weight:700;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .route-card:hover .route-info h3 {
        color: #063857;
        transform: translateX(4px);
    }

    .route-info .route-details{
        color:#6b7280;
        font-size:14px;
        line-height:1.6;
        transition: all 0.3s ease;
    }

    .route-card:hover .route-info .route-details {
        color: #4b5563;
    }

    .route-info .route-details .detail-line{display:block}
    
    .price{
        text-align:right;
        min-width:140px;
        flex-shrink:0;
        padding-left:10px;
        transition: all 0.3s ease;
    }

    .route-card:hover .price {
        transform: translateX(-4px);
    }

    .old-price{
        color:#9ca3af;
        text-decoration:line-through;
        font-size:14px;
        margin-bottom:2px;
        transition: color 0.3s ease;
    }

    .route-card:hover .old-price {
        color: #6b7280;
    }

    .new-price{
        color:#0b4b73;
        font-size:28px;
        font-weight:800;
        line-height:1;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .route-card:hover .new-price {
        transform: scale(1.05);
        color: #063857;
    }

    .tag{
        position:absolute;
        top:10px;
        left:10px;
        background:#0b4b73;
        color:#fff;
        font-size:11px;
        font-weight:700;
        padding:4px 14px;
        border-radius:999px;
        text-transform:uppercase;
        letter-spacing:.5px;
        animation: fadeIn 0.6s ease-out 0.5s both;
        z-index:2;
    }

    /* ===== NEWSLETTER WITH TWO "THANK YOU" LETTERS (WHITE + #4bd2fc GLOW) ===== */
    .newsletter{padding:40px 0 80px}
    .newsletter-box{
        background:#073b63;
        color:#fff;
        border-radius:32px;
        padding:56px 48px;
        text-align:center;
        animation: modalSlideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        position:relative;
        overflow:hidden;
    }

    .newsletter-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 30px 70px rgba(7, 59, 99, 0.3);
    }

    /* Left Thank You letter - white with #4bd2fc glow */
    .newsletter-box .thank-you-left {
        position: absolute;
        top: 50%;
        left: -100px;
        transform: translateY(-50%) rotate(-30deg);
        font-size: 1.8rem;
        font-weight: 800;
        color: rgba(255,255,255,0);
        white-space: nowrap;
        pointer-events: none;
        z-index: 0;
        letter-spacing: 3px;
        text-transform: uppercase;
        transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        opacity: 0;
    }

    /* Right Thank You letter - white with #4bd2fc glow */
    .newsletter-box .thank-you-right {
        position: absolute;
        top: 50%;
        right: -100px;
        transform: translateY(-50%) rotate(30deg);
        font-size: 1.8rem;
        font-weight: 800;
        color: rgba(255,255,255,0);
        white-space: nowrap;
        pointer-events: none;
        z-index: 0;
        letter-spacing: 3px;
        text-transform: uppercase;
        transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        opacity: 0;
    }

    /* On hover - white letters with #4bd2fc glow */
    .newsletter-box:hover .thank-you-left,
    .newsletter-box .subscribe input:focus ~ .thank-you-left {
        left: 20px;
        color: #ffffff;
        opacity: 1;
        text-shadow: 0 0 30px #4bd2fc, 0 0 60px rgba(75, 210, 252, 0.4), 0 0 100px rgba(75, 210, 252, 0.2);
        transform: translateY(-50%) rotate(-30deg) scale(1.1);
        transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .newsletter-box:hover .thank-you-right,
    .newsletter-box .subscribe input:focus ~ .thank-you-right {
        right: 20px;
        color: #ffffff;
        opacity: 1;
        text-shadow: 0 0 30px #4bd2fc, 0 0 60px rgba(75, 210, 252, 0.4), 0 0 100px rgba(75, 210, 252, 0.2);
        transform: translateY(-50%) rotate(30deg) scale(1.1);
        transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Even brighter on active hover */
    .newsletter-box:hover .thank-you-left {
        color: #ffffff;
        text-shadow: 0 0 40px #4bd2fc, 0 0 80px rgba(75, 210, 252, 0.5), 0 0 120px rgba(75, 210, 252, 0.3);
        left: 30px;
        transform: translateY(-50%) rotate(-30deg) scale(1.15);
    }

    .newsletter-box:hover .thank-you-right {
        color: #ffffff;
        text-shadow: 0 0 40px #4bd2fc, 0 0 80px rgba(75, 210, 252, 0.5), 0 0 120px rgba(75, 210, 252, 0.3);
        right: 30px;
        transform: translateY(-50%) rotate(30deg) scale(1.15);
    }

    /* Reset when not hovered */
    .newsletter-box:not(:hover) .thank-you-left {
        left: -100px;
        opacity: 0;
        transition: all 0.5s ease;
        text-shadow: none;
    }

    .newsletter-box:not(:hover) .thank-you-right {
        right: -100px;
        opacity: 0;
        transition: all 0.5s ease;
        text-shadow: none;
    }

    .newsletter-box h3{
        font-size:18px;
        color:#c7d8e8;
        margin-bottom:12px;
        font-weight:600;
        animation: fadeIn 0.8s ease-out 0.5s both;
        transition: transform 0.3s ease;
        position:relative;
        z-index:1;
    }

    .newsletter-box:hover h3 {
        transform: translateY(-2px);
    }

    .newsletter-box p{
        color:#d7e7f5;
        max-width:720px;
        margin:0 auto 30px;
        font-size:18px;
        animation: fadeIn 0.8s ease-out 0.7s both;
        transition: transform 0.3s ease;
        position:relative;
        z-index:1;
    }

    .newsletter-box:hover p {
        transform: translateY(-2px);
    }

    .subscribe{
        display:flex;
        justify-content:center;
        gap:16px;
        flex-wrap:wrap;
        margin-bottom:18px;
        animation: fadeInUp 0.8s ease-out 0.9s both;
        position:relative;
        z-index:1;
    }
    .subscribe input{
        width:380px;
        max-width:100%;
        padding:16px 18px;
        border-radius:14px;
        border:1px solid rgba(255,255,255,.15);
        background:rgba(255,255,255,.08);
        color:#fff;
        font-size:16px;
        outline:none;
        transition: all 0.3s ease;
        position:relative;
        z-index:1;
    }

    .subscribe input::placeholder{color:#cbd5e1}
    .subscribe input:focus{
        border-color: rgba(255,255,255,0.3);
        background: rgba(255,255,255,0.12);
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }

    /* Trigger thank you on input focus */
    .subscribe input:focus ~ .thank-you-left {
        left: 20px;
        color: #ffffff;
        opacity: 1;
        text-shadow: 0 0 30px #4bd2fc, 0 0 60px rgba(75, 210, 252, 0.4), 0 0 100px rgba(75, 210, 252, 0.2);
        transform: translateY(-50%) rotate(-30deg) scale(1.1);
    }

    .subscribe input:focus ~ .thank-you-right {
        right: 20px;
        color: #ffffff;
        opacity: 1;
        text-shadow: 0 0 30px #4bd2fc, 0 0 60px rgba(75, 210, 252, 0.4), 0 0 100px rgba(75, 210, 252, 0.2);
        transform: translateY(-50%) rotate(30deg) scale(1.1);
    }

    .subscribe button{
        background:#8ec5f3;
        color:#083a5a;
        border:none;
        padding:16px 28px;
        border-radius:14px;
        font-weight:700;
        cursor:pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position:relative;
        overflow:hidden;
        z-index:1;
    }

    .subscribe button:hover{
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 40px rgba(142, 197, 243, 0.3);
        background: #9ed0f5;
    }

    .newsletter-box small{
        color:#cbd5e1;
        animation: fadeIn 0.8s ease-out 1.1s both;
        display: block;
        margin-top: 10px;
        transition: all 0.3s ease;
        position:relative;
        z-index:1;
    }

    .newsletter-box:hover small {
        color: #d7e7f5;
    }

    /* ===== KEYFRAME ANIMATIONS ===== */
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

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInDown {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    /* ===== RESPONSIVE ===== */
    @media(max-width:992px){
        .hero-grid{grid-template-columns:1fr}
        .section-header{flex-direction:column;align-items:flex-start}
        .route-card{flex-direction:column;min-height:auto}
        .route-image{width:100%;height:200px}
        .route-body{flex-direction:column;align-items:flex-start;padding:16px 20px}
        .price{text-align:left;width:100%;padding-left:0;padding-top:8px;border-top:1px solid #f3f4f6}
        .promo-card h1{font-size:44px}
        .section-header h2{font-size:38px}
        .hero-image{min-height:400px}
        .image-overlay{position:relative;right:auto;bottom:auto;margin:16px;max-width:100%}
        .image-overlay h3{color:#073b63}
        .image-overlay p{color:#4b5563}
        .hero-image:hover img { transform: scale(1.02); }
        .newsletter-box .thank-you-left { font-size: 1.4rem; }
        .newsletter-box .thank-you-right { font-size: 1.4rem; }
        .route-card .car-icon { display: none; }
        .route-card .car-icon-2 { display: none; }
    }
    @media(max-width:576px){
        .promo-card{padding:28px;min-height:auto}
        .promo-card h1{font-size:36px}
        .section-header h2{font-size:30px}
        .image-overlay h3{font-size:28px}
        .subscribe{flex-direction:column}
        .subscribe input,.subscribe button{width:100%}
        .route-image{height:160px}
        .route-body{padding:14px 16px}
        .route-info h3{font-size:20px}
        .route-info .route-details{font-size:13px}
        .new-price{font-size:24px}
        .hero-image{min-height:300px}
        .newsletter-box{padding:32px 20px}
        .newsletter-box .thank-you-left { font-size: 1.2rem; }
        .newsletter-box .thank-you-right { font-size: 1.2rem; }
        .newsletter-box:hover .thank-you-left { left: 10px; transform: translateY(-50%) rotate(-30deg) scale(1); text-shadow: 0 0 20px #4bd2fc, 0 0 40px rgba(75, 210, 252, 0.4); }
        .newsletter-box:hover .thank-you-right { right: 10px; transform: translateY(-50%) rotate(30deg) scale(1); text-shadow: 0 0 20px #4bd2fc, 0 0 40px rgba(75, 210, 252, 0.4); }
        .image-overlay{background:rgba(255,255,255,0.85);backdrop-filter:blur(8px)}
        .image-overlay h3{color:#073b63}
        .image-overlay p{color:#4b5563}
        .route-card .car-icon { display: none; }
        .route-card .car-icon-2 { display: none; }
    }
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
                    <div class="promo-badge">
                        <span class="material-symbols-outlined">eco</span>
                        {{ $heroBanner?->category ?? 'Sustainable Travel' }}
                    </div>
                    <h1>{{ $heroBanner?->title ?? 'No banner available' }}</h1>
                    <p>{{ $heroBanner?->description }}</p>
                    <div class="features">
                        @if($heroBanner?->badge_1_title)
                        <div class="feature">
                            <div class="icon"><span class="material-symbols-outlined">electric_bolt</span></div>
                            <div>
                                <h4>{{ $heroBanner->badge_1_title }}</h4>
                                <span>{{ $heroBanner->badge_1_sub }}</span>
                            </div>
                        </div>
                        @endif
                        @if($heroBanner?->badge_2_title)
                        <div class="feature">
                            <div class="icon"><span class="material-symbols-outlined">airline_seat_recline_extra</span></div>
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
                @php 
                    $imageUrl = $promotion->image ? asset('storage/'.$promotion->image) : 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80'; 
                @endphp
                <article class="route-card">
                    <div class="route-image">
                        <img src="{{ $imageUrl }}" alt="{{ $promotion->title }}" />
                        @if($loop->first)
                            <span class="tag">Best Seller</span>
                        @endif
                    </div>
                    <div class="route-body">
                        <span class="car-icon">🚗</span>
                        <span class="car-icon-2">🚙</span>
                        <div class="route-info">
                            <h3>{{ $promotion->title }}</h3>
                            <div class="route-details">
                                @if ($promotion->duration)
                                    <span class="detail-line">{{ $promotion->duration }}</span>
                                @endif
                                @if ($promotion->daily_departures)
                                    <span class="detail-line">Daily Departures: {{ $promotion->daily_departures }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="price">
                            <div class="old-price">{{ number_format((float) $promotion->original_price) }} MMK</div>
                            <div class="new-price">{{ number_format((float) $promotion->discounted_price) }} MMK</div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="newsletter">
        <div class="container">
            <div class="newsletter-box">
                <span class="thank-you-left"></span>
                <span class="thank-you-right"></span>
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