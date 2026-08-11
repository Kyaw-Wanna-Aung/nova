@extends('userlayout.app')

@section('title', 'Nova Mobility')

@section('content')
    <div class="container">
        <!-- Hero Section with Premium Image Slider & Typewriter Effects -->
        <section class="hero" id="download-app">
            <!-- Background Image Slides -->
            <div class="hero-slides">
                <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80')"></div>
                <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=1200&q=80')"></div>
                <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1200&q=80')"></div>
            </div>
            
            <div class="hero-overlay"></div>

            <div class="hero-content">
                <h1 id="typewriter-h1"></h1>
                <p id="typewriter-p"></p>
            </div>
        </section>

        <!-- Cards Section with Scroll Animation -->
        <section class="cards">
            <div class="card animate-zoom">
                <div class="icon">👁</div>
                <h3>Our Vision</h3>
                <p>{{ $visionMission?->vision }}</p>
            </div>
            <div class="card dark animate-zoom">
                <div class="icon">🚩</div>
                <h3>Our Mission</h3>
                <p>{{ $visionMission?->mission }}</p>
            </div>
        </section>
    </div>

    <!-- Stats Section with Fade & Stagger Animation -->
    <section class="stats animate-fade-up">
        <div class="container">
            <h2>The Nova Standard</h2>
            <div class="stats-grid">
                <div class="stat animate-stagger" data-count="50" data-suffix="K">
                    <h3><span class="count-number">0</span><span class="count-suffix">K</span></h3>
                    <p>Safe Trips Completed</p>
                </div>
                <div class="stat animate-stagger" data-count="100" data-suffix="%">
                    <h3><span class="count-number">0</span><span class="count-suffix">%</span></h3>
                    <p>Comfortable Trips</p>
                </div>
                <div class="stat animate-stagger" data-count="4">
                    <h3><span class="count-number">0</span></h3>
                    <p>Major Cities Connected</p>
                </div>
                <div class="stat animate-stagger" data-count="24" data-suffix="/7">
                    <h3><span class="count-number">0</span><span class="count-suffix">/7</span></h3>
                    <p>Premium Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Network Section with Slide-in Animations -->
    <div class="container">
        <section class="network animate-slide-left" id="network">
            <div class="network-text">
                <h2>Our Network</h2>
                <p>Operating from strategic hubs across the country, our terminals are designed as premium lounges, ensuring your journey begins in comfort long before you board.</p>
                <div class="branch animate-stagger"><div class="branch-icon">📍</div><div><h4>Yangon Branch (HQ)</h4><span>Downtown Financial District</span></div></div>
                <div class="branch animate-stagger"><div class="branch-icon">📍</div><div><h4>Mandalay Branch</h4><span>Central Station Terminal</span></div></div>
                <div class="branch animate-stagger"><div class="branch-icon">📍</div><div><h4>Naypyidaw Hub</h4><span>Capital Access Point</span></div></div>
            </div>
            <div class="network-image animate-slide-right">
                <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80" alt="Nova Vehicle" />
            </div>
        </section>
    </div>

    <!-- Styles for Advanced Animations & Cinematic Slider -->
    <style>
        /* ===== CINEMATIC CROSSFADE HERO SLIDER ===== */
        .hero {
            position: relative;
            min-height: 500px;
            display: flex;
            align-items: center;
            border-radius: 16px;
            overflow: hidden;
            padding: 50px;
            color: #fff;
            width: 100%;
        }

        .hero-slides {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 1;
        }

        .hero-slide {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transform: scale(1.05);
            transition: opacity 1.8s cubic-bezier(0.4, 0, 0.2, 1), transform 6s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .hero-slide.active {
            opacity: 1;
            transform: scale(1);
        }
        
        .hero-overlay {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3));
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            max-width: 850px;
            width: 100%;
        }

        /* ===== FULLY RESPONSIVE FLUID TYPOGRAPHY ===== */
        #typewriter-h1 {
            font-size: clamp(1.8rem, 4vw, 3.2rem);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            border-right: 3px solid rgba(255, 255, 255, 0.75);
            white-space: pre-wrap;
            word-break: break-word;
            display: inline-block;
        }

        #typewriter-p {
            font-size: clamp(0.95rem, 1.8vw, 1.25rem);
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            border-right: none;
            white-space: pre-wrap;
            word-break: break-word;
        }

        /* ===== RESPONSIVE ICONS ===== */
        .icon {
            font-size: clamp(2rem, 4vw, 2.8rem);
            width: clamp(60px, 8vw, 80px);
            height: clamp(60px, 8vw, 80px);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 0 20px 0; /* Updated from '0 auto 20px' to align left */
            background: rgba(0, 114, 255, 0.08);
            border-radius: 50%;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            flex-shrink: 0;
        }

        .branch-icon {
            font-size: clamp(1.5rem, 2.5vw, 2rem);
            flex-shrink: 0;
            width: clamp(40px, 5vw, 50px);
            text-align: center;
            transition: all 0.3s ease;
        }

        /* ===== SECTION ANIMATION MODELS ===== */
        .animate-zoom {
            opacity: 0;
            transform: scale(0.92);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .animate-zoom.is-visible {
            opacity: 1;
            transform: scale(1);
        }

        .animate-fade-up {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.9s ease-out, transform 0.9s ease-out;
        }
        .animate-fade-up.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .animate-slide-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .animate-slide-left.is-visible {
            opacity: 1;
            transform: translateX(0);
        }

        .animate-slide-right {
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .animate-slide-right.is-visible {
            opacity: 1;
            transform: translateX(0);
        }

        .animate-stagger {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .animate-stagger.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== CARD HOVER ANIMATIONS ===== */
        .card {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            padding: 30px 25px;
            background: #fff;
            border-radius: 20px;
            text-align: left; /* Updated from 'center' to 'left' */
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        }

        .card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(0, 114, 255, 0.06), transparent 70%);
            border-radius: 50%;
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
            opacity: 0;
        }

        .card:hover::before {
            opacity: 1;
            transform: scale(1.5);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        }

        .card:hover .icon {
            transform: scale(1.1) rotate(-5deg);
            background: rgba(0, 114, 255, 0.15);
        }

        .card.dark {
            background: linear-gradient(145deg, #073b63, #0b558e);
            color: #fff;
        }

        .card.dark .icon {
            background: rgba(255, 255, 255, 0.1);
        }

        .card.dark:hover {
            box-shadow: 0 20px 60px rgba(0, 114, 255, 0.15);
        }

        .card.dark:hover .icon {
            background: rgba(255, 255, 255, 0.2);
        }

        .card h3 {
            font-size: clamp(1.2rem, 2vw, 1.5rem);
            margin-bottom: 12px;
        }

        .card p {
            font-size: clamp(0.85rem, 1.2vw, 0.95rem);
            color: #6b7280;
            line-height: 1.7;
        }

        .card.dark p {
            color: rgba(255, 255, 255, 0.8);
        }

        /* ===== STATS ===== */
        .stats {
            background: #f8faff;
            padding: 80px 0;
            border-radius: 40px 40px 0 0;
            margin-top: 40px;
        }

        .stats h2 {
            text-align: center;
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 800;
            margin-bottom: 50px;
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .stats h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #0072ff, #00c6ff);
            border-radius: 3px;
            transition: width 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .stats:hover h2::after {
            width: 100px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 30px;
        }

        .stat {
            text-align: center;
            padding: 30px 20px;
            background: #fff;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        }

        .stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
        }

        .stat h3 {
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 800;
            color: #073b63;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2px;
        }

        .stat:hover h3 .count-number {
            animation: countPulse 0.6s ease;
        }

        @keyframes countPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .stat p {
            font-size: clamp(0.8rem, 1vw, 0.95rem);
            color: #6b7280;
            font-weight: 500;
        }

        .count-suffix {
            font-size: clamp(1.2rem, 2vw, 1.8rem);
            font-weight: 700;
        }

        /* ===== NETWORK ===== */
        .network {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            padding: 80px 0;
            align-items: center;
        }

        .network-text h2 {
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 800;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .network-text h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #0072ff, #00c6ff);
            border-radius: 3px;
            transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .network-text h2.is-visible::after {
            width: 60px;
        }

        .network-text > p {
            color: #6b7280;
            line-height: 1.8;
            margin-bottom: 30px;
            font-size: clamp(0.9rem, 1.2vw, 1rem);
        }

        .branch {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            background: #f8faff;
            border-radius: 14px;
            margin-bottom: 12px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border-left: 3px solid transparent;
        }

        .branch:hover {
            transform: translateX(8px);
            border-left-color: #0072ff;
            background: rgba(0, 114, 255, 0.04);
        }

        .branch:hover .branch-icon {
            transform: scale(1.2) rotate(-5deg);
        }

        .branch h4 {
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
            font-size: clamp(0.95rem, 1.2vw, 1.05rem);
        }

        .branch span {
            font-size: clamp(0.8rem, 1vw, 0.9rem);
            color: #6b7280;
        }

        .network-image img {
            width: 100%;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .network-image img:hover {
            transform: scale(1.02);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.08);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .network {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .network-image {
                order: -1;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 30px 20px;
                min-height: 400px;
            }
            
            .card:hover {
                transform: translateY(-5px);
            }
            
            .stat:hover {
                transform: translateY(-3px);
            }
            
            .branch:hover {
                transform: translateX(4px);
            }

            .cards {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stats {
                padding: 50px 0;
                border-radius: 30px 30px 0 0;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat {
                padding: 20px 15px;
            }

            .stat h3 {
                font-size: clamp(1.6rem, 5vw, 2.2rem);
            }
        }

        @media (max-width: 480px) {
            .hero {
                min-height: 350px;
                padding: 20px 15px;
            }
            
            .card:hover {
                transform: translateY(-3px);
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .stat {
                padding: 15px 10px;
            }

            .stat h3 {
                font-size: clamp(1.4rem, 6vw, 1.8rem);
            }

            .stat p {
                font-size: 0.75rem;
            }

            .branch {
                padding: 12px 15px;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }

        /* ===== CARDS CONTAINER ===== */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            padding: 60px 0;
            animation: cardsFadeIn 1s ease-out;
        }

        @keyframes cardsFadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* ===== STAGGER DELAYS ===== */
        .stat:nth-child(1) { transition-delay: 0s; }
        .stat:nth-child(2) { transition-delay: 0.12s; }
        .stat:nth-child(3) { transition-delay: 0.24s; }
        .stat:nth-child(4) { transition-delay: 0.36s; }

        .branch:nth-child(1) { transition-delay: 0s; }
        .branch:nth-child(2) { transition-delay: 0.12s; }
        .branch:nth-child(3) { transition-delay: 0.24s; }
    </style>

    <!-- Script for Cinematic Image Crossfade & Sequential Typewriter Engine -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ===== 1. CINEMATIC BACKGROUND SLIDESHOW =====
            const slides = document.querySelectorAll('.hero-slide');
            let currentSlideIndex = 0;
            
            function changeSlide() {
                slides[currentSlideIndex].classList.remove('active');
                currentSlideIndex = (currentSlideIndex + 1) % slides.length;
                slides[currentSlideIndex].classList.add('active');
            }

            setInterval(changeSlide, 15000);

            // ===== 2. SEQUENTIAL TYPEWRITER EFFECT =====
            const h1Element = document.getElementById('typewriter-h1');
            const pElement = document.getElementById('typewriter-p');
            
            const h1Text = "Redefining Travel Across Myanmar";
            const pText = "Experience the pinnacle of intercity transport with our premium, 100% electric fleet. Comfort, safety, and sustainability, seamlessly connected.";

            let typewriterTimeout;

            function runTypewriterSequence() {
                h1Element.textContent = "";
                pElement.textContent = "";
                h1Element.style.borderRight = "3px solid rgba(255, 255, 255, 0.75)";
                pElement.style.borderRight = "none";

                let h1Index = 0;
                let pIndex = 0;

                function typeH1() {
                    if (h1Index < h1Text.length) {
                        h1Element.textContent += h1Text.charAt(h1Index);
                        h1Index++;
                        typewriterTimeout = setTimeout(typeH1, 70);
                    } else {
                        h1Element.style.borderRight = "none";
                        pElement.style.borderRight = "3px solid rgba(255, 255, 255, 0.75)";
                        setTimeout(typeP, 300);
                    }
                }

                function typeP() {
                    if (pIndex < pText.length) {
                        pElement.textContent += pText.charAt(pIndex);
                        pIndex++;
                        typewriterTimeout = setTimeout(typeP, 35);
                    } else {
                        pElement.style.borderRight = "none";
                        typewriterTimeout = setTimeout(runTypewriterSequence, 40000);
                    }
                }

                typeH1();
            }

            runTypewriterSequence();

            // ===== 3. SCROLL ANIMATION INTERSECTION OBSERVER =====
            const observerOptions = {
                threshold: 0.12,
                rootMargin: '0px 0px -20px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        
                        const staggeredChildren = entry.target.querySelectorAll('.animate-stagger');
                        staggeredChildren.forEach((child, index) => {
                            setTimeout(() => {
                                child.classList.add('is-visible');
                            }, index * 120);
                        });

                        const heading = entry.target.querySelector('.network-text h2');
                        if (heading) {
                            setTimeout(() => {
                                heading.classList.add('is-visible');
                            }, 300);
                        }

                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.animate-zoom, .animate-fade-up, .animate-slide-left, .animate-slide-right').forEach(section => {
                observer.observe(section);
            });

            // ===== 4. COUNTING ANIMATION FOR STATS =====
            function animateCounters() {
                const statElements = document.querySelectorAll('.stat');
                
                statElements.forEach(stat => {
                    const countElement = stat.querySelector('.count-number');
                    const suffixElement = stat.querySelector('.count-suffix');
                    const targetCount = parseInt(stat.getAttribute('data-count'));
                    const suffix = stat.getAttribute('data-suffix') || '';
                    let currentCount = 0;
                    
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting && currentCount === 0) {
                                startCounting();
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.5 });
                    
                    observer.observe(stat);
                    
                    function startCounting() {
                        const duration = 2000;
                        const steps = 60;
                        const increment = targetCount / steps;
                        let step = 0;
                        
                        function updateCounter() {
                            step++;
                            currentCount = Math.min(Math.round(increment * step), targetCount);
                            
                            const formattedCount = currentCount.toLocaleString();
                            countElement.textContent = formattedCount;
                            
                            if (suffixElement) {
                                suffixElement.textContent = suffix;
                            }
                            
                            if (step < steps && currentCount < targetCount) {
                                requestAnimationFrame(updateCounter);
                            } else {
                                countElement.textContent = targetCount.toLocaleString();
                                if (suffixElement) {
                                    suffixElement.textContent = suffix;
                                }
                            }
                        }
                        
                        updateCounter();
                    }
                });
            }

            // ===== 5. SMOOTH SCROLL BEHAVIOR =====
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // ===== 6. PARALLAX EFFECT ON HERO =====
            window.addEventListener('scroll', function() {
                const hero = document.querySelector('.hero');
                if (hero) {
                    const scrolled = window.pageYOffset;
                    const rate = scrolled * 0.3;
                    hero.style.backgroundPositionY = rate + 'px';
                }
            });

            // ===== 7. INITIALIZE COUNTING ANIMATION =====
            setTimeout(animateCounters, 500);

            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const stats = entry.target.querySelectorAll('.stat');
                        stats.forEach(stat => {
                            const countElement = stat.querySelector('.count-number');
                            if (countElement && countElement.textContent === '0') {
                                animateCounters();
                            }
                        });
                    }
                });
            }, { threshold: 0.3 });

            const statsSection = document.querySelector('.stats');
            if (statsSection) {
                statsObserver.observe(statsSection);
            }
        });
    </script>
@endsection