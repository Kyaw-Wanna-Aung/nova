<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Nova Mobility')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box} body{font-family:"Poppins",sans-serif;background:#f4f5f7;color:#1b2b3a;line-height:1.6} a{text-decoration:none;color:inherit}.container{width:90%;max-width:1200px;margin:0 auto}
        
        /* ===== HEADER ANIMATIONS ===== */
        header{background:#fff;border-bottom:1px solid #e6e6e6;position:sticky;top:0;z-index:1000;transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)}
        .navbar{display:flex;align-items:center;justify-content:space-between;padding:18px 0}
        
        /* ===== LOGO FLOATING ANIMATION ===== */
        .logo{font-size:28px;font-weight:700;color:#0b4b73;letter-spacing:.5px;display:inline-flex;align-items:center;animation: logoFloat 3s ease-in-out infinite}
        
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        
        .logo:hover {
            animation-play-state: paused;
            transform: scale(1.02);
        }
        
        .logo img{height:70px;width:auto;display:block;transition: transform 0.3s ease}
        .logo span{color:#4fa3d9}
        
        nav ul{display:flex;list-style:none;gap:30px}
        nav a{color:#4a5565;font-weight:500;transition: all 0.3s ease;position:relative;padding-bottom:6px}
        nav a.active{color:#0b4b73;border-bottom:2px solid #0b4b73}
        
        /* Underline animation for nav links */
        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #0b4b73;
            transition: width 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        nav a:hover::after {
            width: 100%;
        }
        
        nav a.active::after {
            width: 100%;
        }
        
        nav a:hover{color:#0b4b73}
        
        /* ===== BUTTON ANIMATIONS ===== */
        .btn{background:#0b4b73;color:#fff;padding:12px 22px;border-radius:10px;font-weight:600;transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);position:relative;overflow:hidden}
        
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
            pointer-events: none;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn:hover{background:#083a5a;transform: translateY(-3px) scale(1.02);box-shadow: 0 10px 30px rgba(11,75,115,0.2)}
        
        /* ===== HERO SECTION ANIMATIONS ===== */
        .hero{margin:34px auto;border-radius:26px;overflow:hidden;position:relative;height:500px;background:#0b4b73}
        .container > .hero{background:url("https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1600&q=80") center/cover no-repeat}
        .container > .hero::before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(4,35,56,.78),rgba(4,35,56,.28))}
        .hero-content{position:relative;z-index:1;color:#fff;padding:70px 60px;max-width:650px;animation: heroContent 1.2s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;opacity:0;transform: translateY(40px)}
        
        @keyframes heroContent {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .hero h1{font-size:60px;line-height:1.05;font-weight:800;margin-bottom:24px;animation: heroTitle 1s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;opacity:0;transform: translateX(-30px)}
        
        @keyframes heroTitle {
            0% { opacity: 0; transform: translateX(-30px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        .hero p{font-size:18px;color:#e5edf5;animation: heroDesc 1s cubic-bezier(0.34, 1.56, 0.64, 1) 0.6s both;opacity:0;transform: translateY(20px)}
        
        @keyframes heroDesc {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        /* ===== CARDS SECTION ANIMATIONS ===== */
        .cards{display:grid;grid-template-columns:1fr 1fr;gap:28px;margin:50px 0}
        
        .card{background:#fff;border-radius:20px;padding:36px;box-shadow:0 10px 30px rgba(0,0,0,.05);transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);position:relative;overflow:hidden;animation: cardSlideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) both;opacity:0;transform: translateY(40px) scale(0.95)}
        
        .card:nth-child(1) { animation-delay: 0s; }
        .card:nth-child(2) { animation-delay: 0.12s; }
        
        @keyframes cardSlideUp {
            0% { opacity: 0; transform: translateY(40px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        
        /* Card shine effect */
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
        }
        
        .card:hover::before {
            left: 100%;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(11,75,115,0.08);
        }
        
        .card.dark{background:#073b63;color:#fff}
        .card.dark:hover {
            box-shadow: 0 20px 50px rgba(7,59,99,0.2);
        }
        
        .icon{width:54px;height:54px;border-radius:50%;background:#eef4fa;display:flex;align-items:center;justify-content:center;font-size:22px;color:#0b4b73;margin-bottom:18px;transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1)}
        
        .card:hover .icon {
            transform: scale(1.1) rotate(-5deg);
            background: #0b4b73;
            color: #fff;
            box-shadow: 0 8px 25px rgba(11,75,115,0.15);
        }
        
        .dark .icon{background:rgba(255,255,255,.12);color:#fff}
        .dark .card:hover .icon {
            background: rgba(255,255,255,0.25);
            box-shadow: 0 8px 25px rgba(255,255,255,0.08);
        }
        
        .card h3{font-size:34px;margin-bottom:16px;transition: transform 0.3s ease}
        .card:hover h3 { transform: translateX(4px); }
        
        .card p{color:#596575;transition: transform 0.3s ease}
        .card:hover p { transform: translateX(3px); }
        
        .dark p{color:#d7e3ef}
        
        /* ===== STATS SECTION ANIMATIONS ===== */
        .stats{background:#f0f2f5;padding:70px 0;margin:70px 0;border-radius:0;position:relative;overflow:hidden}
        
        /* Stats background pulse */
        .stats::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 60%;
            height: 200%;
            background: radial-gradient(ellipse, rgba(11,75,115,0.03), transparent 70%);
            animation: statsPulse 8s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes statsPulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 1; }
        }
        
        .stats h2{text-align:center;font-size:54px;color:#0b4b73;margin-bottom:46px;animation: fadeInUp 0.8s ease-out 0.3s both}
        
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);text-align:center;gap:30px}
        
        .stat{
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            animation: statFadeUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) both;
            opacity: 0;
            transform: translateY(30px);
        }
        
        .stat:nth-child(1) { animation-delay: 0s; }
        .stat:nth-child(2) { animation-delay: 0.1s; }
        .stat:nth-child(3) { animation-delay: 0.2s; }
        .stat:nth-child(4) { animation-delay: 0.3s; }
        
        @keyframes statFadeUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .stat:hover {
            transform: translateY(-6px) scale(1.02);
        }
        
        .stat h3{font-size:48px;color:#0b4b73;margin-bottom:8px;transition: transform 0.3s ease}
        .stat:hover h3 { transform: scale(1.05); }
        
        .stat p{font-size:13px;font-weight:700;letter-spacing:1px;color:#6a7685;text-transform:uppercase;transition: color 0.3s ease}
        .stat:hover p { color: #0b4b73; }
        
        /* ===== NETWORK SECTION ANIMATIONS ===== */
        .network{display:grid;grid-template-columns:1fr 1fr;gap:42px;align-items:center;margin:80px 0}
        .network h2{font-size:46px;color:#0b4b73;margin-bottom:20px;animation: fadeInUp 0.8s ease-out 0.3s both}
        .network p{color:#5f6b7a;margin-bottom:30px;animation: fadeInUp 0.8s ease-out 0.4s both}
        
        .branch{background:#fff;border:1px solid #e6ebef;border-radius:14px;padding:18px 20px;margin-bottom:16px;display:flex;align-items:flex-start;gap:14px;transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);border-left: 4px solid transparent;animation: branchSlide 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) both;opacity:0;transform: translateX(-20px)}
        
        .branch:nth-child(1) { animation-delay: 0s; }
        .branch:nth-child(2) { animation-delay: 0.1s; }
        .branch:nth-child(3) { animation-delay: 0.2s; }
        
        @keyframes branchSlide {
            0% { opacity: 0; transform: translateX(-20px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        .branch:hover {
            border-left-color: #0b4b73;
            transform: translateX(8px);
            background: #f8fafc;
            box-shadow: 0 4px 20px rgba(11,75,115,0.04);
        }
        
        .branch-icon{width:40px;height:40px;border-radius:10px;background:#eef4fa;color:#0b4b73;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)}
        
        .branch:hover .branch-icon {
            transform: scale(1.1) rotate(-5deg);
            background: #0b4b73;
            color: #fff;
        }
        
        .branch h4{color:#0b4b73;margin-bottom:4px;font-size:18px;transition: transform 0.3s ease}
        .branch:hover h4 { transform: translateX(4px); }
        
        .branch span{color:#6b7785;font-size:14px;transition: color 0.3s ease}
        .branch:hover span { color: #4a5a6a; }
        
        .network-image img{width:100%;border-radius:22px;display:block;object-fit:cover;height:480px;transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);animation: imageReveal 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;opacity:0;transform: scale(0.95)}
        
        @keyframes imageReveal {
            0% { opacity: 0; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1); }
        }
        
        .network-image img:hover {
            transform: scale(1.02);
            box-shadow: 0 25px 60px rgba(11,75,115,0.1);
        }
        
        /* ===== FOOTER ANIMATIONS ===== */
        footer{background:#073b63;color:#dce7f1;padding:70px 0 30px;animation: fadeIn 0.8s ease-out 0.5s both}
        
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        
        .footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:40px}
        footer h3{color:#fff;margin-bottom:18px;font-size:32px;transition: transform 0.3s ease}
        footer:hover h3 { transform: translateX(4px); }
        footer h4{color:#fff;margin-bottom:16px;font-size:18px}
        footer p,footer li{color:#c6d5e3;margin-bottom:10px;list-style:none;transition: all 0.3s ease}
        footer li:hover { transform: translateX(6px); color: #8ec5f3; }
        .footer-bottom{margin-top:40px;padding-top:24px;border-top:1px solid rgba(255,255,255,.12);text-align:center;color:#c6d5e3;font-size:14px}
        
        @media(max-width:992px){
            nav{display:none}
            .cards,.network,.footer-grid{grid-template-columns:1fr}
            .stats-grid{grid-template-columns:repeat(2,1fr)}
            .hero{height:420px}
            .hero-content{padding:40px 30px}
            .hero h1{font-size:44px}
            .stats h2{font-size:38px}
            .network h2{font-size:34px}
            .stat:nth-child(1) { animation-delay: 0s; }
            .stat:nth-child(2) { animation-delay: 0.08s; }
            .stat:nth-child(3) { animation-delay: 0.16s; }
            .stat:nth-child(4) { animation-delay: 0.24s; }
        }
        
        @media(max-width:576px){
            .stats-grid{grid-template-columns:1fr}
            .hero{height:360px}
            .hero h1{font-size:34px}
            .card h3{font-size:28px}
            .stats h2{font-size:30px}
            .network h2{font-size:30px}
            .stat:nth-child(1) { animation-delay: 0s; }
            .stat:nth-child(2) { animation-delay: 0.06s; }
            .stat:nth-child(3) { animation-delay: 0.12s; }
            .stat:nth-child(4) { animation-delay: 0.18s; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('userlayout.partials.header')
    @yield('content')
    @include('userlayout.partials.footer')
    @stack('scripts')
</body>
</html>