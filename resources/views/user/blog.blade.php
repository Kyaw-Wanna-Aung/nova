@extends('userlayout.app')
@section('title', 'Nova Insights')
@push('styles')
<style>
body{background:#f7fafc}

/* ===== HERO SECTION ANIMATIONS ===== */
.insights-hero{background:#f4f5f6;color:#0b4b73;padding:60px 0 90px;position:relative;overflow:hidden}
.insights-hero .container{max-width:1320px;width:100%;margin:0 auto;padding:0 20px;position:relative;z-index:1}

/* Hero background pulse */
.insights-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -30%;
    width: 60%;
    height: 200%;
    background: radial-gradient(ellipse, rgba(142,197,243,0.08), transparent 70%);
    animation: heroPulse 8s ease-in-out infinite;
    pointer-events: none;
}

@keyframes heroPulse {
    0%, 100% { transform: scale(1) translateX(0); opacity: 0.5; }
    50% { transform: scale(1.2) translateX(-30px); opacity: 1; }
}

.insights-badge{
    display:inline-block;
    background:#8ec5f3;
    color:#0b4b73;
    padding:6px 16px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
    letter-spacing:.08em;
    margin-bottom:20px;
    box-shadow:0 4px 12px rgba(11,75,115,0.08);
    animation: fadeInDown 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) both;
}

@keyframes fadeInDown {
    0% { opacity: 0; transform: translateY(-20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.insights-hero h1{
    font-size:56px;
    line-height:1.15;
    letter-spacing:-0.02em;
    margin:0 0 20px;
    color:#0b4b73;
    font-weight:800;
    max-width:1000px;
    animation: fadeInUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s both;
}

@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}

.insights-hero p{
    max-width:760px;
    color:#373333;
    font-size:16px;
    font-weight:700;
    line-height:1.6;
    animation: fadeInUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
}

/* ===== TABS SECTION ===== */
.tabs-wrapper {
    margin-top: -15px;
    margin-bottom: 80px;
    border-bottom: 2px solid #c3c2c2;
    padding-bottom: 20px;
    animation: fadeIn 0.8s ease-out 0.4s both;
}

@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

.tabs{display:flex;gap:10px;flex-wrap:wrap;position:relative;margin-bottom:20px}
.tabs a{
    padding:12px 18px;
    border-radius:999px;
    background:#fff;
    color:#345;
    font-size:14px;
    font-weight:700;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    text-decoration:none;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position:relative;
    overflow:hidden;
}

/* Tab shine effect */
.tabs a::before {
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

.tabs a:hover::before {
    left: 100%;
}

.tabs a:hover {
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 12px 30px rgba(11,75,115,0.12);
}

.tabs a.active{
    background:#0b4b73;
    color:#fff;
    box-shadow: 0 10px 30px rgba(11,75,115,0.25);
}

.tabs a.active:hover {
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 15px 40px rgba(11,75,115,0.3);
}

.blog-wrap{padding:20px 0 80px}
.blog-wide-container{max-width:1400px;width:100%;margin:0 auto;padding:0 20px}

/* ===== FEATURED BLOG ANIMATIONS ===== */
.featured-blog{
    position:relative;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 14px 34px rgba(11,39,64,0.12);
    margin-bottom:80px;
    margin-top:10px;
    min-height:480px;
    display:flex;
    align-items:flex-end;
    animation: featuredZoom 1s cubic-bezier(0.34, 1.56, 0.64, 1) 0.5s both;
    transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
                box-shadow 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes featuredZoom {
    0% { opacity: 0; transform: scale(0.95); }
    100% { opacity: 1; transform: scale(1); }
}

.featured-blog:hover {
    transform: translateY(-6px) scale(1.005);
    box-shadow: 0 25px 60px rgba(11,39,64,0.18);
}

.featured-blog img{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    object-fit:cover;
    z-index:1;
    transition: transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.featured-blog:hover img {
    transform: scale(1.05);
}

.featured-blog::after{
    content:'';
    position:absolute;
    inset:0;
    background:linear-gradient(180deg,rgba(0,0,0,0.1) 20%,rgba(11,75,115,0.95) 90%);
    z-index:2;
    transition: opacity 0.5s ease;
}

.featured-blog:hover::after {
    opacity: 0.9;
}

.featured-copy{
    position:relative;
    z-index:3;
    padding:48px;
    display:flex;
    flex-direction:column;
    justify-content:flex-end;
    color:#fff;
    max-width:800px;
}

.featured-copy .kicker{
    color:#b7d5ef;
    background:rgba(11,75,115,0.8);
    padding:6px 12px;
    border-radius:8px;
    display:inline-block;
    width:fit-content;
    margin-bottom:12px;
    font-size:12px;
    font-weight:800;
    letter-spacing:.11em;
    text-transform:uppercase;
    animation: fadeIn 0.6s ease-out 0.7s both;
    transition: all 0.3s ease;
}

.featured-blog:hover .kicker {
    background: rgba(11,75,115,0.95);
}

.featured-copy h2{
    font-size:38px;
    line-height:1.15;
    color:#fff;
    margin:10px 0 15px;
    animation: fadeInUp 0.6s ease-out 0.8s both;
    transition: transform 0.3s ease;
}

.featured-blog:hover .featured-copy h2 {
    transform: translateX(4px);
}

.featured-copy p{
    color:#e2e8f0;
    font-size:16px;
    line-height:1.6;
    margin-bottom:20px;
    animation: fadeInUp 0.6s ease-out 0.9s both;
}

.featured-copy .button-link {
    animation: fadeInUp 0.6s ease-out 1s both;
}

/* ===== BLOG CARDS ===== */
.blog-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:35px}

.blog-card{
    background:transparent;
    display:flex;
    flex-direction:column;
    animation: modalSlideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) both;
    opacity: 0;
    transform: translateY(40px) scale(0.95);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes modalSlideUp {
    0% { opacity: 0; transform: translateY(40px) scale(0.95); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

/* Stagger delays for blog cards */
.blog-card:nth-child(1) { animation-delay: 0s; }
.blog-card:nth-child(2) { animation-delay: 0.08s; }
.blog-card:nth-child(3) { animation-delay: 0.16s; }
.blog-card:nth-child(4) { animation-delay: 0.24s; }
.blog-card:nth-child(5) { animation-delay: 0.32s; }
.blog-card:nth-child(6) { animation-delay: 0.40s; }

.blog-card:hover {
    transform: translateY(-8px);
}

.blog-card-img-wrap{
    position:relative;
    width:100%;
    height:240px;
    border-radius:24px !important;
    overflow:hidden !important;
    -webkit-mask-image:-webkit-radial-gradient(white, black);
    box-shadow:0 10px 25px rgba(11,39,64,0.12);
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.blog-card:hover .blog-card-img-wrap {
    transform: scale(1.02);
    box-shadow: 0 20px 40px rgba(11,39,64,0.18);
}

.blog-card-img-wrap img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
    border-radius:24px !important;
    transition: transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.blog-card:hover .blog-card-img-wrap img {
    transform: scale(1.08);
}

.blog-card-tag{
    position:absolute;
    top:14px;
    left:14px;
    background:#fff;
    color:#073b63;
    padding:6px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    z-index:2;
    transition: all 0.3s ease;
}

.blog-card:hover .blog-card-tag {
    background: #0b4b73;
    color: #fff;
    transform: translateY(-2px) scale(1.05);
}

.blog-card div.content{padding:14px 10px 0 10px;display:flex;flex-direction:column;flex:1}

.blog-card h3{
    color:#073b63;
    font-size:20px;
    line-height:1.25;
    margin:8px 0 10px;
    flex:1;
    transition: color 0.3s ease, transform 0.3s ease;
}

.blog-card:hover h3 {
    color: #0b4b73;
    transform: translateX(4px);
}

.blog-card p{
    color:#556677;
    line-height:1.6;
    font-size:14px;
    margin-bottom:14px;
    transition: color 0.3s ease;
}

.blog-card:hover p {
    color: #4a5a6a;
}

.meta{
    color:#222222;
    font-size:13px;
    font-weight:700;
    margin-bottom:4px;
    transition: color 0.3s ease;
}

.blog-card:hover .meta {
    color: #0b4b73;
}

.button-link{
    font-weight:800;
    color:#53a7db;
    margin-top:auto;
    display:inline-flex;
    align-items:center;
    gap:6px;
    text-decoration:none;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.button-link:hover{
    color:#8ec5f3;
    transform: translateX(6px);
}

/* ===== LOAD MORE BUTTON ===== */
.load{text-align:center;margin:50px 0}
.load-more-btn{
    display:inline-block;
    padding:14px 36px;
    border:2px solid #0b4b73;
    border-radius:14px;
    background:#fff;
    color:#0b4b73;
    font-weight:800;
    font-size:15px;
    text-decoration:none;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow:0 4px 14px rgba(11,75,115,0.08);
    cursor:pointer;
    position:relative;
    overflow:hidden;
}

.load-more-btn::before {
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

.load-more-btn:hover::before {
    left: 100%;
}

.load-more-btn:hover{
    background:#0b4b73;
    color:#fff;
    transform: translateY(-4px) scale(1.03);
    box-shadow: 0 15px 40px rgba(11,75,115,0.2);
}

/* ===== NEWSLETTER SECTION ===== */
.newsletter-box{
    background:#0a3f65;
    color:#fff;
    border-radius:26px;
    padding:100px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:32px;
    align-items:center;
    margin-top:60px;
    margin-bottom:60px;
    animation: modalSlideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.5s both;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    position:relative;
    overflow:hidden;
}

/* Newsletter background pulse */
.newsletter-box::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(ellipse, rgba(255,255,255,0.05), transparent 70%);
    animation: newsPulse 6s ease-in-out infinite;
    pointer-events: none;
}

@keyframes newsPulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.2); opacity: 1; }
}

.newsletter-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 30px 70px rgba(10,63,101,0.25);
}

.newsletter-box h2{
    animation: fadeInUp 0.8s ease-out 0.7s both;
    transition: transform 0.3s ease;
}

.newsletter-box:hover h2 {
    transform: translateY(-2px);
}

.newsletter-box p{
    color:#d8eaf8;
    animation: fadeInUp 0.8s ease-out 0.9s both;
    transition: transform 0.3s ease;
}

.newsletter-box:hover p {
    transform: translateY(-2px);
}

.newsletter-box form{
    display:flex;
    gap:10px;
    animation: fadeInUp 0.8s ease-out 1.1s both;
}

.newsletter-box input{
    flex:1;
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.15);
    border-radius:12px;
    padding:16px 20px;
    color:#fff;
    font-size:14px;
    outline:none;
    transition: all 0.3s ease;
}

.newsletter-box input::placeholder{color:#7a9ab5}
.newsletter-box input:focus{
    border-color:#8ec5f3;
    background:rgba(255,255,255,0.1);
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}

.newsletter-box button{
    border:0;
    border-radius:10px;
    padding:15px 22px;
    background:#8ec5f3;
    color:#083b60;
    font-weight:800;
    cursor:pointer;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position:relative;
    overflow:hidden;
}

.newsletter-box button::before {
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

.newsletter-box button:hover::before {
    left: 100%;
}

.newsletter-box button:hover{
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 15px 40px rgba(142,197,243,0.25);
    background: #9ed5f5;
}

/* ===== KEYFRAME ANIMATIONS ===== */
@keyframes modalSlideUp {
    0% { opacity: 0; transform: translateY(40px) scale(0.95); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes fadeInDown {
    0% { opacity: 0; transform: translateY(-20px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

/* ===== HIDDEN BLOG CARDS (for load more) ===== */
.hidden-blog {
    display: none !important;
}

/* ===== RESPONSIVE ===== */
@media(max-width:900px){
    .newsletter-box{grid-template-columns:1fr}
    .blog-grid{grid-template-columns:1fr 1fr}
    .insights-hero h1{font-size:40px}
    .blog-card:nth-child(1) { animation-delay: 0s; }
    .blog-card:nth-child(2) { animation-delay: 0.08s; }
    .blog-card:nth-child(3) { animation-delay: 0.16s; }
    .blog-card:nth-child(4) { animation-delay: 0.24s; }
    .blog-card:nth-child(5) { animation-delay: 0.32s; }
    .blog-card:nth-child(6) { animation-delay: 0.40s; }
    .newsletter-box{padding:60px 40px}
}
@media(max-width:600px){
    .blog-grid{grid-template-columns:1fr}
    .insights-hero h1{font-size:30px}
    .featured-copy{padding:28px}
    .featured-copy h2{font-size:30px}
    .newsletter-box form{flex-direction:column}
    .newsletter-box{padding:40px 24px}
    .blog-card:nth-child(1) { animation-delay: 0s; }
    .blog-card:nth-child(2) { animation-delay: 0.06s; }
    .blog-card:nth-child(3) { animation-delay: 0.12s; }
    .blog-card:nth-child(4) { animation-delay: 0.18s; }
    .blog-card:nth-child(5) { animation-delay: 0.24s; }
    .blog-card:nth-child(6) { animation-delay: 0.30s; }
    .tabs a{padding:10px 14px;font-size:12px}
    .featured-blog{min-height:320px}
    .blog-card:hover{transform:translateY(-4px)}
}
</style>
@endpush

@section('content')
<section class="insights-hero">
    <div class="container">
        <span class="insights-badge">NOVA INSIGHTS</span>
        <h1>The future of premium mobility in Myanmar.</h1>
        <p>Discover how Nova Mobility is redefining intercity travel through sustainable technology, executive comfort, and innovative routes across the Golden Land.</p>
    </div>
</section>

<main class="blog-wide-container blog-wrap">
    <!-- တက်ဘ်အောက်မှာ မျဉ်းကြောင်းပေါ်လာစေရန် .tabs-wrapper သုံးပေးထားသည် -->
    <div class="tabs-wrapper">
        <nav class="tabs">
            @foreach(['' => 'All Stories','Sustainable Travel' => 'Sustainable Travel','Tech & Innovation' => 'Tech & Innovation','Travel Guides' => 'Travel Guides','Corporate Updates' => 'Corporate Updates'] as $value => $label)
                <a href="{{ route('blog.index', $value ? ['category' => $value] : []) }}" @class(['active' => $category === $value])>{{ $label }}</a>
            @endforeach
        </nav>
    </div>

    @if($featured)
    <article class="featured-blog">
        <img src="{{ Storage::url($featured->featured_image) }}" alt="{{ $featured->title }}">
        <div class="featured-copy">
            <span class="kicker">FEATURED · {{ $featured->published_at->format('F d, Y') }}</span>
            <h2>{{ $featured->title }}</h2>
            <p>{{ $featured->summary }}</p>
            <a class="button-link" href="{{ route('blog.show',$featured) }}" style="color:#8ec5f3;">Read the full story →</a>
        </div>
    </article>
    @endif

    <div class="blog-grid" id="main-blog-grid">
        @forelse($blogs as $index => $blog)
        <article class="blog-card {{ $index >= 3 ? 'hidden-blog' : '' }}" style="{{ $index >= 3 ? 'display:none;' : '' }}">
            <div class="blog-card-img-wrap">
                <img src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}">
                <span class="blog-card-tag">{{ $blog->category }}</span>
            </div>
            <div class="content">
                <div class="meta">{{ $blog->published_at->format('M d, Y') }} · {{ $blog->read_time }} min read</div>
                <h3>{{ $blog->title }}</h3>
                <p>{{ Str::limit($blog->summary, 142) }}</p>
                <a class="button-link" href="{{ route('blog.show',$blog) }}">Read More →</a>
            </div>
        </article>
        @empty
        <p>No stories are available in this category.</p>
        @endforelse
    </div>

    @if(count($blogs) > 3)
    <div class="load">
        <button type="button" id="main-load-more-btn" class="load-more-btn">Load More Articles</button>
    </div>
    @endif

    <section class="newsletter-box">
        <div>
            <h2>Stay ahead with Nova Mobility insights.</h2>
            <p>Subscribe to our monthly newsletter for travel guides, technology updates, and early access to promotional routes.</p>
        </div>
        <form method="POST" action="{{ route('newsletter.subscribe') }}">
            @csrf
            <input name="email" type="email" required placeholder="Enter your business email">
            <button>Subscribe</button>
        </form>
    </section>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('main-load-more-btn');
    
    if(loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            let hiddenBlogs = document.querySelectorAll('.hidden-blog');
            let showCount = 0;
            
            hiddenBlogs.forEach(function(card) {
                if (showCount < 3) {
                    card.style.display = 'flex';
                    card.classList.remove('hidden-blog');
                    showCount++;
                }
            });

            if (document.querySelectorAll('.hidden-blog').length === 0) {
                loadMoreBtn.style.display = 'none';
            }
        });
    }
});
</script>
@endpush