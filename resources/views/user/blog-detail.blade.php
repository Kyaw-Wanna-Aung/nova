@extends('userlayout.app')
@section('title', $blog->title.' - Nova Insights')
@push('styles')<style>
body{background:#f7fafc}

/* ===== ARTICLE HEAD ANIMATIONS ===== */
.article-head{background:#073b63;padding:60px 20px 140px;color:#fff;text-align:center;position:relative;overflow:hidden}

/* Background pulse effect */
.article-head::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -20%;
    width: 140%;
    height: 200%;
    background: radial-gradient(ellipse at center, rgba(255,255,255,0.05), transparent 70%);
    animation: headPulse 6s ease-in-out infinite;
    pointer-events: none;
}

@keyframes headPulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.2); opacity: 1; }
}

.article-head .meta-top{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:12px;margin-bottom:20px}
.article-head .category{
    background:#8ec5f3;
    color:#042b48;
    padding:6px 16px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
    letter-spacing:.08em;
    text-transform:uppercase;
    animation: fadeInDown 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) both;
}

@keyframes fadeInDown {
    0% { opacity: 0; transform: translateY(-20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.article-head .date{
    color:#e2e8f0;
    font-size:15px;
    font-weight:600;
    animation: fadeInDown 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s both;
}

.article-head h1{
    max-width:900px;
    margin:0 auto 40px;
    color:#fff;
    font-size:42px;
    line-height:1.15;
    font-weight:800;
    letter-spacing:-0.02em;
    animation: fadeInUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;
}

@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}

.author-bar{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:20px;max-width:600px;margin:0 auto}
.author{display:flex;gap:14px;align-items:center;color:#fff;text-align:left}
.author img{
    height:48px;
    width:48px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid rgba(255,255,255,0.2);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.author:hover img {
    transform: scale(1.08);
    border-color: #8ec5f3;
}
.author-info strong{color:#fff;font-size:15px;font-weight:700}
.author-info span{font-size:13px;color:#9cb5c9}
.author-divider{width:1px;height:36px;background:rgba(255,255,255,0.2)}
.read-time{color:#9cb5c9;font-size:14px;font-weight:600;display:flex;align-items:center;gap:8px}

.container-custom{max-width:1320px;margin:0 auto;padding:0 20px;}

/* ===== FEATURED IMAGE ANIMATIONS ===== */
.featured-image-container{margin-top:-90px;margin-bottom:40px;position:relative;z-index:3;animation: imageSlideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.4s both}
@keyframes imageSlideUp {
    0% { opacity: 0; transform: translateY(40px); }
    100% { opacity: 1; transform: translateY(0); }
}
.article-image-wrapper{border-radius:26px;position:relative;overflow:hidden;transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1)}
.article-image-wrapper:hover {
    transform: scale(1.005);
    box-shadow: 0 30px 60px rgba(4,43,72,0.2);
}
.article-image{
    width:100%;
    height:auto;
    max-height:520px;
    border-radius:26px;
    object-fit:cover;
    display:block;
    box-shadow:0 20px 40px rgba(4,43,72,0.25);
    transition: transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.article-image-wrapper:hover .article-image {
    transform: scale(1.03);
}

/* ===== LAYOUT ANIMATIONS ===== */
.layout{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:40px;padding:0 0 80px;align-items:start;}

/* ===== ARTICLE BODY ANIMATIONS ===== */
.article-body{
    color:#465564;
    font-size:17px;
    line-height:1.85;
    background:#fff;
    padding:35px;
    border-radius:24px;
    box-shadow:0 8px 30px rgba(11,39,64,0.05);
    overflow-wrap:break-word;
    word-break:break-word;
    animation: fadeIn 0.8s ease-out 0.5s both;
}
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}
.article-body>p{white-space:pre-line;margin-bottom:24px}
.article-body>p:first-of-type{
    border-left:4px solid #3171a1;
    padding-left:20px;
    margin-bottom:30px;
    animation: fadeInUp 0.6s ease-out 0.6s both;
}

.article-section{
    margin:42px 0;
    animation: fadeInUp 0.6s ease-out both;
}
.article-section:nth-child(1) { animation-delay: 0.1s; }
.article-section:nth-child(2) { animation-delay: 0.2s; }
.article-section:nth-child(3) { animation-delay: 0.3s; }
.article-section:nth-child(4) { animation-delay: 0.4s; }
.article-section:nth-child(5) { animation-delay: 0.5s; }

.article-section img{
    width:100%;
    height:auto;
    border-radius:18px;
    margin-bottom:18px;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.article-section img:hover {
    transform: scale(1.02);
    box-shadow: 0 20px 50px rgba(4,43,72,0.12);
}
.article-section h2{color:#073b63;font-size:28px;font-weight:800;margin-bottom:16px}

/* ===== SIDEBAR ANIMATIONS ===== */
.side{position:sticky;top:24px;display:flex;flex-direction:column;gap:24px}
.side-card{
    background:#073b63;
    color:#fff;
    border-radius:22px;
    padding:25px;
    box-shadow:0 12px 30px rgba(4,43,72,0.15);
    overflow-wrap:break-word;
    word-break:break-word;
    animation: fadeInUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.5s both;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.side-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 50px rgba(4,43,72,0.2);
}
.side-card h3{color:#fff;margin-top:0;margin-bottom:20px;font-size:20px;font-weight:800}

.related{
    padding:16px 0;
    border-bottom:1px solid rgba(255,255,255,0.1);
    display:flex;
    flex-direction:column;
    gap:6px;
    transition: all 0.3s ease;
}
.related:first-of-type{padding-top:0}
.related:last-child{border:0;padding-bottom:0}
.related:hover {
    transform: translateX(6px);
}
.related span{font-size:11px;color:#8ec5f3;font-weight:800;letter-spacing:.08em;text-transform:uppercase}
.related p{color:#fff;font-weight:600;font-size:14px;line-height:1.45;margin:0}
.related a{
    transition: all 0.3s ease;
}
.related:hover a {
    transform: translateX(4px);
}

.side-card.subscribe{
    background:#e2f0fb;
    color:#042b48;
    animation-delay: 0.7s;
}
.side-card.subscribe h3{color:#042b48}
.side-card.subscribe p{color:#465564;font-size:14px;line-height:1.5;margin-bottom:16px}
.subscribe input{
    width:100%;
    box-sizing:border-box;
    padding:14px 16px;
    border:1px solid #cbd5e1;
    border-radius:12px;
    margin-bottom:12px;
    font-size:14px;
    outline:none;
    background:#fff;
    transition: all 0.3s ease;
}
.subscribe input:focus {
    border-color: #0b4b73;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(11,75,115,0.08);
}
.subscribe button{
    width:100%;
    background:#0b4b73;
    color:#fff;
    border:0;
    border-radius:12px;
    padding:14px;
    font-weight:800;
    font-size:14px;
    cursor:pointer;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position:relative;
    overflow:hidden;
}
.subscribe button::before {
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
.subscribe button:hover::before {
    left: 100%;
}
.subscribe button:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 10px 30px rgba(11,75,115,0.2);
}

/* ===== MORE SECTION ANIMATIONS ===== */
.more{padding:70px 0 90px;background:#f7fafc;border-top:1px solid #e2e8f0}
.more .container-custom{max-width:1320px;margin:0 auto;padding:0 20px;}
.more-header{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:40px;flex-wrap:wrap;gap:16px;}
.more-header-content h2{
    color:#042b48;
    font-size:38px;
    font-weight:800;
    letter-spacing:-0.02em;
    margin:0 0 10px 0;
    animation: fadeInUp 0.8s ease-out 0.3s both;
}
.more-header-content p{
    color:#465564;
    font-size:16px;
    margin:0;
    animation: fadeInUp 0.8s ease-out 0.4s both;
}
.view-all-link{
    color:#042b48;
    font-weight:700;
    font-size:15px;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:6px;
    transition: all 0.3s ease;
    animation: fadeInUp 0.8s ease-out 0.5s both;
}
.view-all-link:hover{
    opacity:0.8;
    transform: translateX(6px);
}

.more-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px;}

.more-card{
    background:#fff;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(11,39,64,0.06);
    display:flex;
    flex-direction:column;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    animation: modalSlideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) both;
    opacity: 0;
    transform: translateY(40px) scale(0.95);
}

@keyframes modalSlideUp {
    0% { opacity: 0; transform: translateY(40px) scale(0.95); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

.more-card:nth-child(1) { animation-delay: 0s; }
.more-card:nth-child(2) { animation-delay: 0.08s; }
.more-card:nth-child(3) { animation-delay: 0.16s; }

.more-card:hover{
    transform: translateY(-8px) scale(1.005);
    box-shadow:0 20px 50px rgba(11,39,64,0.12);
}

.more-card-img-wrap{
    width:100%;
    height:220px;
    overflow:hidden;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.more-card:hover .more-card-img-wrap {
    transform: scale(1.02);
}
.more-card-img-wrap img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
    transition: transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.more-card:hover .more-card-img-wrap img {
    transform: scale(1.08);
}

.more-card-content{padding:26px;display:flex;flex-direction:column;flex-grow:1;}
.more-card-meta{
    font-size:12px;
    color:#465564;
    font-weight:700;
    letter-spacing:.06em;
    text-transform:uppercase;
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:12px;
    transition: color 0.3s ease;
}
.more-card:hover .more-card-meta {
    color: #0b4b73;
}
.more-card-meta span.dot{width:4px;height:4px;background:#cbd5e1;border-radius:50%;display:inline-block}
.more-card h3{
    color:#042b48;
    font-size:22px;
    font-weight:800;
    line-height:1.35;
    margin:0 0 14px 0;
    transition: color 0.3s ease, transform 0.3s ease;
}
.more-card:hover h3 {
    color: #073b63;
    transform: translateX(4px);
}
.more-card p{
    color:#465564;
    font-size:15px;
    line-height:1.6;
    margin:0 0 24px 0;
    flex-grow:1;
    transition: color 0.3s ease;
}
.more-card:hover p {
    color: #3a4a5a;
}
.more-card-link{
    color:#042b48;
    font-weight:800;
    font-size:14px;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:6px;
    margin-top:auto;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.more-card-link:hover{
    color:#3171a1;
    transform: translateX(6px);
}

@media(max-width:1024px){
    .layout{grid-template-columns:1fr;}
    .side{position:static;}
    .more-grid{grid-template-columns:repeat(2,1fr);}
    .more-card:nth-child(1) { animation-delay: 0s; }
    .more-card:nth-child(2) { animation-delay: 0.06s; }
    .more-card:nth-child(3) { animation-delay: 0.12s; }
}

@media(max-width:768px){
    .article-head h1{font-size:32px;}
    .more-grid{grid-template-columns:1fr;}
    .article-body{padding:20px;}
    .author-divider{display:none;}
    .featured-image-container{margin-top:-60px;}
    .more-header-content h2{font-size:28px;}
    .more-card:nth-child(1) { animation-delay: 0s; }
    .more-card:nth-child(2) { animation-delay: 0.06s; }
    .more-card:nth-child(3) { animation-delay: 0.12s; }
    .article-body>p:first-of-type {
        border-left-width: 3px;
        padding-left: 14px;
    }
}
</style>@endpush
@section('content')
<section class="article-head">
    <div class="container-custom">
        <div class="meta-top">
            <span class="category">{{ $blog->category }}</span>
            <span class="date">{{ $blog->published_at->format('F d, Y') }}</span>
        </div>
        <h1>{{ $blog->title }}</h1>
        <div class="author-bar">
            <div class="author">
                <img src="{{ Storage::url($blog->author_profile_image) }}" alt="{{ $blog->author_name }}">
                <div class="author-info">
                    <strong>{{ $blog->author_name }}</strong><br>
                    <span>{{ $blog->author_role }}</span>
                </div>
            </div>
            <div class="author-divider"></div>
            <div class="read-time">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                {{ $blog->read_time }} min read
            </div>
        </div>
    </div>
</section>

<div class="container-custom">
    <div class="featured-image-container">
        <div class="article-image-wrapper">
            <img class="article-image" src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}">
        </div>
    </div>

    <main class="layout">
        <article>
            <div class="article-body">
                @if($blog->summary)
                    <p>{{ $blog->summary }}</p>
                @endif
                <p>{{ $blog->content }}</p>
                @foreach ($blog->sections as $section)
                    @if ($section->image || $section->title || $section->message)
                        <section class="article-section">
                            @if ($section->image)
                                <img src="{{ Storage::url($section->image) }}" alt="{{ $section->title }}">
                            @endif
                            @if ($section->title)
                                <h2>{{ $section->title }}</h2>
                            @endif
                            @if ($section->message)
                                <p>{{ $section->message }}</p>
                            @endif
                        </section>
                    @endif
                @endforeach
            </div>
        </article>
        
        <aside class="side">
            <section class="side-card">
                <h3>Related Insights</h3>
                @foreach($relatedBlogs as $related)
                <div class="related">
                    <span>{{ $related->category }}</span>
                    <p>{{ $related->title }}</p>
                    <a href="{{ route('blog.show',$related) }}" style="color:#8ec5f3;font-size:13px;text-decoration:none;font-weight:700;margin-top:4px;">Read More →</a>
                </div>
                @endforeach
            </section>
            
            <section class="side-card subscribe">
                <h3>Stay Informed</h3>
                <p>Get the latest news on luxury mobility and sustainable travel directly in your inbox.</p>
                <form method="POST" action="{{ route('newsletter.subscribe') }}">
                    @csrf
                    <input name="email" type="email" required placeholder="Email address">
                    <button type="submit">Subscribe</button>
                </form>
            </section>
        </aside>
    </main>
</div>

<section class="more">
    <div class="container-custom">
        <div class="more-header">
            <div class="more-header-content">
                <h2>More from Nova Insights</h2>
                <p>Exploring the future of transport and premium lifestyle.</p>
            </div>
            <a href="{{ route('blog.all') }}" class="view-all-link">View All Posts →</a>
        </div>
        <div class="more-grid">
            @foreach($moreBlogs as $more)
            <article class="more-card">
                @if($more->featured_image)
                <div class="more-card-img-wrap">
                    <img src="{{ Storage::url($more->featured_image) }}" alt="{{ $more->title }}">
                </div>
                @endif
                <div class="more-card-content">
                    <div class="more-card-meta">
                        <span style="color:#3171a1;">{{ $more->category }}</span>
                        <span class="dot"></span>
                        <span>{{ $more->published_at->format('M d, Y') }}</span>
                    </div>
                    <h3>{{ $more->title }}</h3>
                    <p>{{ Str::limit($more->summary, 110) }}</p>
                    <a href="{{ route('blog.show',$more) }}" class="more-card-link">Read Article &nearr;</a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endsection