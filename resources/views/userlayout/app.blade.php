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
        header{background:#fff;border-bottom:1px solid #e6e6e6;position:sticky;top:0;z-index:1000}.navbar{display:flex;align-items:center;justify-content:space-between;padding:18px 0}.logo{font-size:28px;font-weight:700;color:#0b4b73;letter-spacing:.5px;display:inline-flex;align-items:center}.logo img{height:70px;width:auto;display:block}.logo span{color:#4fa3d9}nav ul{display:flex;list-style:none;gap:30px}nav a{color:#4a5565;font-weight:500;transition:.3s}nav a.active{color:#0b4b73;border-bottom:2px solid #0b4b73;padding-bottom:6px}nav a:hover{color:#0b4b73}.btn{background:#0b4b73;color:#fff;padding:12px 22px;border-radius:10px;font-weight:600;transition:.3s}.btn:hover{background:#083a5a}
        .hero{margin:34px auto;border-radius:26px;overflow:hidden;position:relative;height:500px;background:#0b4b73}.container > .hero{background:url("https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1600&q=80") center/cover no-repeat}.container > .hero::before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(4,35,56,.78),rgba(4,35,56,.28))}.hero-content{position:relative;z-index:1;color:#fff;padding:70px 60px;max-width:650px}.hero h1{font-size:60px;line-height:1.05;font-weight:800;margin-bottom:24px}.hero p{font-size:18px;color:#e5edf5}
        .cards{display:grid;grid-template-columns:1fr 1fr;gap:28px;margin:50px 0}.card{background:#fff;border-radius:20px;padding:36px;box-shadow:0 10px 30px rgba(0,0,0,.05)}.card.dark{background:#073b63;color:#fff}.icon{width:54px;height:54px;border-radius:50%;background:#eef4fa;display:flex;align-items:center;justify-content:center;font-size:22px;color:#0b4b73;margin-bottom:18px}.dark .icon{background:rgba(255,255,255,.12);color:#fff}.card h3{font-size:34px;margin-bottom:16px}.card p{color:#596575}.dark p{color:#d7e3ef}
        .stats{background:#f0f2f5;padding:70px 0;margin:70px 0;border-radius:0}.stats h2{text-align:center;font-size:54px;color:#0b4b73;margin-bottom:46px}.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);text-align:center;gap:30px}.stat h3{font-size:48px;color:#0b4b73;margin-bottom:8px}.stat p{font-size:13px;font-weight:700;letter-spacing:1px;color:#6a7685;text-transform:uppercase}
        .network{display:grid;grid-template-columns:1fr 1fr;gap:42px;align-items:center;margin:80px 0}.network h2{font-size:46px;color:#0b4b73;margin-bottom:20px}.network p{color:#5f6b7a;margin-bottom:30px}.branch{background:#fff;border:1px solid #e6ebef;border-radius:14px;padding:18px 20px;margin-bottom:16px;display:flex;align-items:flex-start;gap:14px}.branch-icon{width:40px;height:40px;border-radius:10px;background:#eef4fa;color:#0b4b73;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}.branch h4{color:#0b4b73;margin-bottom:4px;font-size:18px}.branch span{color:#6b7785;font-size:14px}.network-image img{width:100%;border-radius:22px;display:block;object-fit:cover;height:480px}
        footer{background:#073b63;color:#dce7f1;padding:70px 0 30px}.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:40px}footer h3{color:#fff;margin-bottom:18px;font-size:32px}footer h4{color:#fff;margin-bottom:16px;font-size:18px}footer p,footer li{color:#c6d5e3;margin-bottom:10px;list-style:none}.footer-bottom{margin-top:40px;padding-top:24px;border-top:1px solid rgba(255,255,255,.12);text-align:center;color:#c6d5e3;font-size:14px}
        @media(max-width:992px){nav{display:none}.cards,.network,.footer-grid{grid-template-columns:1fr}.stats-grid{grid-template-columns:repeat(2,1fr)}.hero{height:420px}.hero-content{padding:40px 30px}.hero h1{font-size:44px}.stats h2{font-size:38px}.network h2{font-size:34px}}@media(max-width:576px){.stats-grid{grid-template-columns:1fr}.hero{height:360px}.hero h1{font-size:34px}.card h3{font-size:28px}.stats h2{font-size:30px}.network h2{font-size:30px}}
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
