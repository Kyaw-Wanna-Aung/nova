@extends('userlayout.app')
@section('title', 'Nova Insights')
@push('styles')
<style>
body{background:#f7fafc}
.insights-hero{background:#f4f5f6;color:#0b4b73;padding:60px 0 90px}
.insights-hero .container{max-width:1320px;width:100%;margin:0 auto;padding:0 20px}
.insights-badge{display:inline-block;background:#8ec5f3;color:#0b4b73;padding:6px 16px;border-radius:999px;font-size:12px;font-weight:800;letter-spacing:.08em;margin-bottom:20px;box-shadow:0 4px 12px rgba(11,75,115,0.08)}
.insights-hero h1{font-size:56px;line-height:1.15;letter-spacing:-0.02em;margin:0 0 20px;color:#0b4b73;font-weight:800;max-width:1000px}
.insights-hero p{max-width:760px;color:#373333;font-size:16px;font-weight:700;line-height:1.6}

.tabs{display:flex;gap:10px;flex-wrap:wrap;margin-top:-25px;position:relative}
.tabs a{padding:12px 18px;border-radius:999px;background:#fff;color:#345;font-size:14px;font-weight:700;box-shadow:0 8px 20px #1232;text-decoration:none}
.tabs a.active{background:#0b4b73;color:#fff}
.blog-wrap{padding:44px 0 80px}
.blog-wide-container{max-width:1320px;width:100%;margin:0 auto;padding:0 20px}

/* Featured Blog Overlay Style */
.featured-blog{position:relative;border-radius:28px;overflow:hidden;box-shadow:0 14px 34px #0b27401c;margin-bottom:60px;margin-top:30px;min-height:480px;display:flex;align-items:flex-end}
.featured-blog img{position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;z-index:1}
.featured-blog::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,0,0,0.1) 20%,rgba(11,75,115,0.95) 90%);z-index:2}
.featured-copy{position:relative;z-index:3;padding:48px;display:flex;flex-direction:column;justify-content:flex-end;color:#fff;max-width:800px}
.featured-copy .kicker{color:#b7d5ef;background:rgba(11,75,115,0.8);padding:6px 12px;border-radius:8px;display:inline-block;width:fit-content;margin-bottom:12px;font-size:12px;font-weight:800;letter-spacing:.11em;text-transform:uppercase}
.featured-copy h2{font-size:38px;line-height:1.15;color:#fff;margin:10px 0 15px}
.featured-copy p{color:#e2e8f0;font-size:16px;line-height:1.6;margin-bottom:20px}

/* Small Cards Grid Style - Fixed Image Border Radius */
.blog-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:30px}
.blog-card{background:transparent;display:flex;flex-direction:column}

.blog-card-img-wrap{
    position:relative;
    width:100%;
    height:220px;
    border-radius:24px !important;
    overflow:hidden !important;
    -webkit-mask-image:-webkit-radial-gradient(white, black);
    box-shadow:0 10px 25px rgba(11,39,64,0.12);
}
.blog-card-img-wrap img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
    border-radius:24px !important;
}
.blog-card-tag{position:absolute;margin-top:10px;left:14px;background:#fff;color:#073b63;padding:6px 14px;border-radius:999px;font-size:12px;font-weight:800;box-shadow:0 4px 12px rgba(0,0,0,0.1);z-index:2}

.blog-card div.content{padding:14px 10px 0 10px;display:flex;flex-direction:column;flex:1}
.blog-card h3{color:#073b63;font-size:20px;line-height:1.25;margin:8px 0 10px;flex:1}
.blog-card p{color:#556677;line-height:1.6;font-size:14px;margin-bottom:14px}
.meta{color:#222222;font-size:13px;font-weight:700;margin-bottom:4px}

/* Light Blue color for Read More links */
.button-link{font-weight:800;color:#53a7db;margin-top:auto;display:inline-flex;align-items:center;gap:6px;text-decoration:none;transition:.2s}
.button-link:hover{color:#8ec5f3}

/* Load More Button Style */
.load{text-align:center;margin:50px 0}
.load-more-btn{display:inline-block;padding:14px 36px;border:2px solid #0b4b73;border-radius:14px;background:#fff;color:#0b4b73;font-weight:800;font-size:15px;text-decoration:none;transition:all .2s ease;box-shadow:0 4px 14px rgba(11,75,115,0.08);cursor:pointer;}
.load-more-btn:hover{background:#0b4b73;color:#fff}

.newsletter-box{background:#0a3f65;color:#fff;border-radius:26px;padding:100px;display:grid;grid-template-columns:1fr 1fr;gap:32px;align-items:center;margin-top:60px;margin-bottom:60px}
.newsletter-box p{color:#d8eaf8}
.newsletter-box form{display:flex;gap:10px}
.newsletter-box input{flex:1;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.15);border-radius:12px;padding:16px 20px;color:#fff;font-size:14px;outline:none;transition:border-color .2s}
.newsletter-box input::placeholder{color:#7a9ab5}
.newsletter-box input:focus{border-color:#8ec5f3}
.newsletter-box button{border:0;border-radius:10px;padding:15px 22px;background:#8ec5f3;color:#083b60;font-weight:800;cursor:pointer}

@media(max-width:900px){.newsletter-box{grid-template-columns:1fr}.blog-grid{grid-template-columns:1fr 1fr}.insights-hero h1{font-size:40px}}
@media(max-width:600px){.blog-grid{grid-template-columns:1fr}.insights-hero h1{font-size:30px}.featured-copy{padding:28px}.featured-copy h2{font-size:30px}.newsletter-box form{flex-direction:column}}
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
    <nav class="tabs">
        @foreach(['' => 'All Stories','Sustainable Travel' => 'Sustainable Travel','Tech & Innovation' => 'Tech & Innovation','Travel Guides' => 'Travel Guides','Corporate Updates' => 'Corporate Updates'] as $value => $label)
            <a href="{{ route('blog.index', $value ? ['category' => $value] : []) }}" @class(['active' => $category === $value])>{{ $label }}</a>
        @endforeach
    </nav>

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
        <!-- ပထမ (၃) ခုကိုသာ ပြထားပြီး၊ ကျန်တာတွေကို hidden-blog အဖြစ် ဖွက်ထားပါမယ် -->
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
            // hidden-blog class ပါတဲ့ ကတ်တွေကို ရှာပါမယ်
            let hiddenBlogs = document.querySelectorAll('.hidden-blog');
            let showCount = 0;
            
            // တစ်ခါနှိပ်ရင် ၃ ခု စီ ထပ်ပြပါမယ်
            hiddenBlogs.forEach(function(card) {
                if (showCount < 3) {
                    card.style.display = 'flex';
                    card.classList.remove('hidden-blog');
                    showCount++;
                }
            });

            // ဖွက်ထားတာ ထပ်မရှိတော့ရင် ခလုတ်ကို ဖျောက်လိုက်ပါမယ်
            if (document.querySelectorAll('.hidden-blog').length === 0) {
                loadMoreBtn.style.display = 'none';
            }
        });
    }
});
</script>
@endpush