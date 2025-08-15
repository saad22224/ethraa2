<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sadad Union - تطبيق التحويلات المالية</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/logo-01.jpg') }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
</head>


<style>
    html {
        overflow-x: hidden !important;
    }

    .CON {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .slider-container {
        max-width: 800px;
        width: 100%;
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);

    }

    .slider-wrapper {
        position: relative;
        width: 100%;
        height: 700px;
        overflow: hidden;
    }

    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateX(50px);
    }

    .slide.active {
        opacity: 1;
        transform: translateX(0);
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0;
    }

    .slide-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        padding: 60px 40px 30px;
        color: white;
        transform: translateY(100%);
        transition: transform 0.8s ease;
    }

    .slide.active .slide-content {
        transform: translateY(0);
    }

    .slide-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .slide-description {
        font-size: 1.1rem;
        opacity: 0.9;
        line-height: 1.6;
    }



    .dots-container {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 12px;
        z-index: 10;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dot.active {
        background: white;
        transform: scale(1.3);
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
    }

    .dot:hover {
        background: rgba(255, 255, 255, 0.8);
        transform: scale(1.2);
    }

    @media (max-width: 768px) {
        .slider-wrapper {
            height: 400px;
        }

        .slide-content {
            padding: 40px 20px 20px;
        }

        .slide-title {
            font-size: 1.5rem;
        }

        .slide-description {
            font-size: 1rem;
        }

        .navigation {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .search-trigger {
            transform: translateX(-150%);
        }
    }

    .search-trigger {
        background: none;
        border: none;
        color: #666;
        font-size: 20px;
        cursor: pointer;
        padding: 8px;
        border-radius: 50%;
        transition: all 0.3s ease;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-trigger:hover {
        background: #f0f0f0;
        color: #333;
    }

    /* Search Bar Container */
    .search-bar-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 2000;
        transform: translateY(-100%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .search-bar-container.active {
        transform: translateY(0);
        opacity: 1;
    }

    .search-bar-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .search-logo {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        white-space: nowrap;
    }

    /* MTCN Search Input */
    .mtcn-search-container {
        flex: 1;
        display: flex;
        align-items: center;
        background: #f8f9fa;
        border: 2px solid #e4e6ea;
        border-radius: 24px;
        padding: 8px 20px;
        transition: all 0.3s ease;
        max-width: 600px;
    }

    .mtcn-search-container:focus-within {
        background: white;
        border-color: #1a73e8;
        box-shadow: 0 2px 8px rgba(26, 115, 232, 0.15);
    }

    .mtcn-inputs-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
    }

    .digit-input {
        width: 35px;
        height: 35px;
        border: 1px solid #dadce0;
        border-radius: 6px;
        text-align: center;
        font-size: 16px;
        font-weight: 500;
        color: #333;
        background: white;
        transition: all 0.2s ease;
    }

    .digit-input:focus {
        outline: none;
        border-color: #1a73e8;
        box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
    }

    .separator {
        color: #dadce0;
        font-weight: 500;
        margin: 0 4px;
    }

    .search-icon {
        color: #9aa0a6;
        font-size: 18px;
        margin-left: 12px;
        cursor: pointer;
        transition: color 0.2s;
    }

    .search-icon:hover {
        color: #1a73e8;
    }

    .close-search {
        background: none;
        border: none;
        color: #5f6368;
        font-size: 18px;
        cursor: pointer;
        padding: 8px;
        border-radius: 50%;
        transition: all 0.2s;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-search:hover {
        background: #f8f9fa;
        color: #333;
    }

    /* Search Suggestions/Status */
    .search-status {
        position: absolute;
        top: 100%;
        left: 20px;
        right: 20px;
        background: white;
        border: 1px solid #e4e6ea;
        border-top: none;
        border-radius: 0 0 8px 8px;
        padding: 15px 20px;
        font-size: 14px;
        color: #5f6368;
        display: none;
    }

    .search-status.show {
        display: block;
    }

    .search-status.error {
        color: #ea4335;
        border-left: 3px solid #ea4335;
        background: #fef7f7;
    }

    /* Backdrop */
    .search-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.1);
        z-index: 1999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .search-backdrop.active {
        opacity: 1;
        visibility: visible;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .search-bar-content {
            padding: 15px;
            gap: 15px;
        }

        .search-logo {
            font-size: 16px;
            min-width: auto;
        }

        .digit-input {
            width: 30px;
            height: 30px;
            font-size: 14px;
        }

        .mtcn-search-container {
            padding: 6px 15px;
        }

        .separator {
            margin: 0 2px;
            font-size: 12px;
        }
    }

    @media (max-width: 480px) {
        .search-bar-content {
            flex-wrap: wrap;
            gap: 10px;
        }

        .search-logo {
            width: 100%;
            text-align: center;
            order: 1;
        }

        .mtcn-search-container {
            order: 2;
            width: 100%;
        }

        .close-search {
            order: 3;
            position: absolute;
            top: 10px;
            left: 10px;
        }
    }

    #mtcnHidden:focus {
        border: none;
        outline: none;
    }

    .fa-search {
        color: #FFD700;
    }
</style>

<body>
    @if (session('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                destination: "{{ url('/') }}",
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "left", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "red",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    <!-- Header -->

    <header class="header">
        <nav class="navbar">

            <div class="nav-container">
                <div class="nav-logo">
                    <img style="width: 100px; border-radius: 8px;" src="{{ asset('assets/logo-01.jpg') }}"
                        alt="">
                    <span>
                    </span>
                </div>

                <!-- Desktop Menu -->
                <ul class="nav-menu">
                    <li><a href="#home">الرئيسية</a></li>
                    <li><a href="#about">عن التطبيق</a></li>
                    <li><a href="#features">المزايا</a></li>
                    <li><a href="#faq">أسئلة شائعة</a></li>
                    <li><a href="#contact">تواصل معنا</a></li>
                    {{-- <li><a href="{{ route('tracking') }}"> تعقب الحواله</a></li> --}}
                </ul>
                <button class="search-trigger" onclick="openSearch()">
                    <i class="fas fa-search"></i>
                </button>
                {{-- <button onclick="Toastify({text: 'رسالة اختبار', duration: 3000}).showToast();">جرب توست</button> --}}

                <div class="search-backdrop" id="searchBackdrop"></div>
                <div class="search-bar-container" id="searchBar">
                    <div class="search-bar-content">
                        <div class="search-logo">تتبع الحوالة</div>

                        <form id="mtcnForm" class="mtcn-search-container" method="POST"
                            action="{{ route('tracking.tracking') }}">
                            @csrf

                            <div class="mtcn-inputs-wrapper">
                                <input type="text" name="mtcn" id="mtcnHidden" value=""
                                    style="
    padding: 10px 24px;
    background: white;
    color: #333;
    font-size: 16px;
    font-weight: 600;
    border: none;
    border-radius: 24px;
    cursor: text;
    box-shadow: 0 3px 6px white;
    transition: background 0.3s ease;
    width: 100%;
    text-align: center;
  "
                                    placeholder="أدخل رقم MTCN" />




                            </div>
                            <button style="border: none; background: none;" type="submit" class="search-btn">
                                <i class="fas fa-search search-icon">

                                </i>
                                {{-- test --}}
                            </button>
                        </form>

                        <button class="close-search" onclick="closeSearch()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="search-status" id="searchStatus">
                        أدخل رقم MTCN المكون من 10 أرقام
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>

        <!-- Mobile Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <img style="width: 100px; border-radius: 8px;" src="{{ asset('assets/logo-01.jpg') }}"
                        alt="">
                    {{-- <i class="fas fa-wallet"></i> --}}
                    {{-- <span>FlowPay</span> --}}
                </div>
                <button class="close-btn" id="closeBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#home" class="sidebar-link">الرئيسية</a></li>
                <li><a href="#about" class="sidebar-link">عن التطبيق</a></li>
                <li><a href="#features" class="sidebar-link">المزايا</a></li>
                <li><a href="#faq" class="sidebar-link">أسئلة شائعة</a></li>
                <li><a href="#contact" class="sidebar-link">تواصل معنا</a></li>
            </ul>
        </div>

        <!-- Overlay -->
        <div class="overlay" id="overlay"></div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <span class="highlight" data-aos="fade-left">Sadad Union</span>
                        <br>مستقبل التحويلات المالية
                    </h1>
                    <p class="hero-description">
                        التطبيق الأول في المنطقة للتحويلات المالية السريعة والآمنة. حوّل أموالك، اشترِ بالفيزا الوهمية،
                        وأرسل الأموال لأصدقائك بضغطة واحدة.
                    </p>
                    <div class="hero-buttons">
                        <a target="_blank" href="https://play.google.com/store/apps/details?id=com.sadadunion.sadad_union" class="btn btn-primary">
                            <i class="fab fa-google-play"></i>
                            تحميل التطبيق
                        </a>
                        <a href="#about" class="btn btn-secondary">
                            <i class="fas fa-info-circle"></i>
                            اعرف أكثر
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat">
                            <span class="stat-number">50K+</span>
                            <span class="stat-label">مستخدم نشط</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number">1M+</span>
                            <span class="stat-label">تحويل ناجح</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">دعم فني</span>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="phone-mockup">
                        <div class="phone-screen">
                            <div class="app-interface">
                                <div class="app-header">
                                    <div class="balance">$2,450.00</div>
                                </div>
                                <div class="app-buttons">
                                    <div class="app-btn">إرسال</div>
                                    <div class="app-btn">استلام</div>
                                    <div class="app-btn">فيزا</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="floating-elements">
                        <div class="floating-card card-1">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="floating-card card-2">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="floating-card card-3">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-wave"></div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-aos="fade-left" data-aos-duration="3000">عن التطبيق</h2>
                <p data-aos="fade-up" data-aos-duration="4000" class="section-subtitle">سداد يونيون هي شركة تحويل
                    أموال موثوقة، شريكة رسمية لشركة ويسترن يونيون، وتوفر خدمات مالية رقمية آمنة وسريعة محليًا ودوليًا.
                </p>
            </div>
            <div class="about-content">
                <div class="about-grid">
                    <div class="about-card" data-aos-easing="linear" data-aos="fade-left" data-aos-duration="7000">
                        <div class="card-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <h3>التحويلات المالية</h3>
                        <p>حوّل أموالك بسرعة وأمان إلى أي مكان في العالم بأفضل الأسعار</p>
                    </div>
                    <div class="about-card" data-aos-easing="linear" data-aos="fade-left" data-aos-duration="9000">
                        <div class="card-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <h3>الفيزا الوهمية</h3>
                        <p>أنشئ فيزا وهمية للتسوق الآمن عبر الإنترنت واحمِ بياناتك المالية</p>
                    </div>
                    <div class="about-card" data-aos-easing="linear" data-aos="fade-left" data-aos-duration="11000">
                        <div class="card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>إرسال للأصدقاء</h3>
                        <p>أرسل الأموال لأصدقائك وعائلتك فوريًا داخل التطبيق</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-aos-easing="linear" data-aos="fade-left" data-aos-duration="3000">
                    مزايا التطبيق</h2>
                <p class="section-subtitle" data-aos-easing="linear" data-aos="fade-up" data-aos-duration="3000">
                    اكتشف الميزات الرائعة التي تجعل تجربتك المالية أسهل وأكثر أمانًا</p>
            </div>
            <div class="features-grid">
                <div class="feature-card" data-aos-easing="linear" data-aos="fade-right">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>سرعة فائقة</h3>
                    <p>تحويلات فورية في ثوانٍ معدودة</p>
                </div>
                <div class="feature-card" data-aos-easing="linear" data-aos="fade-right">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>أمان عالي</h3>
                    <p>تشفير متقدم وحماية لبياناتك</p>
                </div>
                <div class="feature-card" data-aos-easing="linear" data-aos="fade-right">
                    <div class="feature-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h3>رسوم منخفضة</h3>
                    <p>أقل الرسوم في السوق</p>
                </div>
                <div class="feature-card" data-aos-easing="linear" data-aos="fade-right">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>دعم 24/7</h3>
                    <p>فريق دعم متاح طوال الوقت</p>
                </div>
                <div class="feature-card" data-aos-easing="linear" data-aos="fade-right">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>سهولة الاستخدام</h3>
                    <p>واجهة بسيطة ومريحة</p>
                </div>
                <div class="feature-card" data-aos-easing="linear" data-aos="fade-right">
                    <div class="feature-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>تغطية عالمية</h3>
                    <p>خدمات في أكثر من 50 دولة</p>
                </div>
            </div>
        </div>
    </section>
    <div class="CON">
        <div class="slider-container">
            <div class="slider-wrapper">
                <div class="slide active">
                    <img src="{{ asset('assets/1.jpg') }}" alt="منظر طبيعي">
                </div>

                <div class="slide">
                    <img src="{{ asset('assets/2.jpg') }}" alt="بحيرة">
                </div>

                <div class="slide">
                    <img src="{{ asset('assets/3.jpg') }}" alt="غابة">
                </div>

                <div class="slide">
                    <img src="{{ asset('assets/4.jpg') }}" alt="جبال">
                </div>

                <div class="slide">
                    <img src="{{ asset('assets/5.jpg') }}" alt="شاطئ">

                </div>
                <div class="slide">
                    <img src="{{ asset('assets/6.jpg') }}" alt="شاطئ">

                </div>
                <div class="slide">
                    <img src="{{ asset('assets/7.jpg') }}" alt="شاطئ">

                </div>
                <div class="slide">
                    <img src="{{ asset('assets/8.jpg') }}" alt="شاطئ">

                </div>
            </div>



            <div class="dots-container">
                <span class="dot active" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
                <span class="dot" onclick="currentSlide(4)"></span>
                <span class="dot" onclick="currentSlide(5)"></span>
                <span class="dot" onclick="currentSlide(6)"></span>
                <span class="dot" onclick="currentSlide(7)"></span>
                <span class="dot" onclick="currentSlide(8)"></span>
            </div>
        </div>
    </div>
    <script>
        let slideIndex = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        let slideInterval;

        function showSlide(n) {
            slides[slideIndex].classList.remove('active');
            dots[slideIndex].classList.remove('active');

            slideIndex = (n + slides.length) % slides.length;

            slides[slideIndex].classList.add('active');
            dots[slideIndex].classList.add('active');
        }

        function currentSlide(n) {
            showSlide(n - 1);
            resetInterval();
        }

        function autoSlide() {
            slideInterval = setInterval(() => {
                showSlide(slideIndex + 1);
            }, 4000);
        }

        function resetInterval() {
            clearInterval(slideInterval);
            autoSlide();
        }

        // تشغيل السلايدر التلقائي
        autoSlide();

        // إيقاف السلايدر عند التمرير فوق الصورة
        document.querySelector('.slider-container').addEventListener('mouseenter', () => {
            clearInterval(slideInterval);
        });

        // تشغيل السلايدر عند الخروج من الصورة
        document.querySelector('.slider-container').addEventListener('mouseleave', () => {
            autoSlide();
        });
    </script>
    <!-- FAQ Section -->
    <section id="faq" class="faq">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">أسئلة شائعة</h2>
                <p class="section-subtitle">إجابات على الأسئلة الأكثر شيوعًا حول التطبيق</p>
            </div>
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>1. ما هي شركة سداد يونيون؟</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>سداد يونيون هي شركة تحويل أموال موثوقة، شريكة رسمية لشركة ويسترن يونيون، وتوفر خدمات مالية
                            رقمية آمنة وسريعة محليًا ودوليًا.
                        </p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>2. هل سداد يونيون جهة مرخصة؟
                        </h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>نعم، سداد يونيون تعمل بشكل قانوني ومرخص، وتخضع للوائح المالية المعتمدة في الدولة.
                        </p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>3. هل تتوفر خدمات سداد يونيون من خلال تطبيق إلكتروني؟
                        </h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>نعم، تتوفر جميع خدماتنا عبر تطبيق مخصص لأنظمة iOS وAndroid، يتيح لك التحويل، التتبع، الدفع،
                            وإدارة حسابك بسهولة.
                        </p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>5. هل يمكن تنفيذ الحوالات عبر التطبيق
                        </h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>نعم، يمكن إرسال واستقبال الأموال، ومتابعة حالة الحوالات عبر الموقع الإلكتروني بكل سهولة
                            وأمان.
                        </p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>كيف تعمل الفيزا الوهمية؟</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>الفيزا الوهمية هي بطاقة رقمية مؤقتة يمكنك إنشاؤها للتسوق الآمن عبر الإنترنت. تحدد المبلغ
                            والمدة، وتستخدم البطاقة دون الكشف عن بياناتك البنكية الحقيقية.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img style="width: 100px; border-radius: 8px;" src="{{ asset('assets/logo-01.jpg') }}"
                            alt="">
                        {{-- <i class="fas fa-wallet"></i> --}}
                        {{-- <span>FlowPay</span> --}}
                    </div>
                    <p>التطبيق الأول للتحويلات المالية السريعة والآمنة في المنطقة العربية</p>
                    <div class="social-links">
                        <a style="text-decoration: none" target="_blank"
                            href="https://www.facebook.com/SADADUNION?mibextid=ZbWKwL"><i
                                class="fab fa-facebook"></i></a>
                        <a style="text-decoration: none" target="_blank"
                            href="https://x.com/SADAD_UNION?t=9yC60Ib7RMVBv4r5wIS9CQ&s=09"><i
                                class="fab fa-twitter"></i></a>
                        <a style="text-decoration: none" target="_blank" href="https://t.me/SADADUNION"><i
                                class="fab fa-telegram"></i></a>
                        {{-- <a href="#"><i class="fab fa-linkedin"></i></a> --}}
                    </div>
                </div>
                <div class="footer-section">
                    <h3>الخدمات</h3>
                    <ul>
                        <li><a href="#">التحويلات المالية</a></li>
                        <li><a href="#">الفيزا الوهمية</a></li>
                        <li><a href="#">إرسال للأصدقاء</a></li>
                        <li><a href="#">المحفظة الإلكترونية</a></li>
                    </ul>
                </div>
                {{-- <div class="footer-section">
                    <h3>الدعم</h3>
                    <ul>
                        <li><a href="#">مركز المساعدة</a></li>
                        <li><a href="#">تواصل معنا</a></li>
                        <li><a href="#">الأسئلة الشائعة</a></li>
                        <li><a href="#">الشروط والأحكام</a></li>
                    </ul>
                </div> --}}
                <div class="footer-section">
                    <h3>تواصل معنا</h3>
                    <div class="contact-info">
                        <p><i class="fas fa-envelope"></i> saddadunion@gmail.com</p>
                        {{-- <p><i class="fas fa-phone"></i> +966 50 123 4567</p> --}}
                        {{-- <p><i class="fas fa-map-marker-alt"></i> الرياض، المملكة العربية السعودية</p> --}}
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Sadad Union. جميع الحقوق محفوظة</p>
            </div>
        </div>
    </footer>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="{{ asset('land.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        let searchOpen = false;

        // Show/Hide Status
        function showStatus(message, type = '') {
            const status = document.getElementById('searchStatus');
            if (!status) return;
            status.textContent = message;
            status.className = `search-status show ${type}`;
        }

        function hideStatus() {
            const status = document.getElementById('searchStatus');
            if (!status) return;
            status.classList.remove('show');
        }

        // Open Search Bar
        function openSearch() {
            const searchBar = document.getElementById('searchBar');
            const backdrop = document.getElementById('searchBackdrop');

            searchBar.classList.add('active');
            backdrop.classList.add('active');
            searchOpen = true;

            // Focus first input after animation delay
            setTimeout(() => {
                const firstInput = document.querySelector('.digit-input');
                if (firstInput) firstInput.focus();
                showStatus('أدخل رقم MTCN المكون من 10 أرقام');
            }, 300);
        }

        // Close Search Bar
        function closeSearch() {
            const searchBar = document.getElementById('searchBar');
            const backdrop = document.getElementById('searchBackdrop');

            searchBar.classList.remove('active');
            backdrop.classList.remove('active');
            searchOpen = false;

            // Reset form and hide status
            const form = document.getElementById('mtcnForm');
            if (form) form.reset();
            hideStatus();
        }

        document.getElementById('searchBackdrop').addEventListener('click', closeSearch);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOpen) {
                closeSearch();
            }
        });

        // document.addEventListener('DOMContentLoaded', function() {
        //     const inputs = document.querySelectorAll('.digit-input');
        //     const form = document.getElementById('mtcnForm');

        //     // Input event handling
        //     inputs.forEach((input, index) => {
        //         input.addEventListener('input', function(e) {
        //             this.value = this.value.replace(/[^0-9]/g, '');

        //             const currentLength = Array.from(inputs).map(i => i.value).join('').length;
        //             if (currentLength === 0) {
        //                 showStatus('أدخل رقم MTCN المكون من 10 أرقام');
        //             } else if (currentLength === 10) {
        //                 showStatus('اضغط Enter للبحث أو أيقونة البحث');
        //             } else {
        //                 showStatus(`${currentLength}/10 أرقام`);
        //             }

        //             if (this.value.length === 1 && index < inputs.length - 1) {
        //                 inputs[index + 1].focus();
        //             }
        //         });

        //         input.addEventListener('keydown', function(e) {
        //             if (e.key === 'Backspace' && this.value === '' && index > 0) {
        //                 inputs[index - 1].focus();
        //             }
        //             if (e.key === 'Enter') {
        //                 e.preventDefault();
        //                 form.dispatchEvent(new Event('submit'));
        //             }
        //         });

        //         input.addEventListener('paste', function(e) {
        //             e.preventDefault();
        //             const pastedData = (e.clipboardData || window.clipboardData).getData('text');
        //             const numbers = pastedData.replace(/[^0-9]/g, '');

        //             for (let i = 0; i < numbers.length && (index + i) < inputs.length; i++) {
        //                 inputs[index + i].value = numbers[i];
        //             }

        //             const totalLength = Array.from(inputs).map(i => i.value).join('').length;
        //             if (totalLength === 10) {
        //                 showStatus('اضغط Enter للبحث أو أيقونة البحث');
        //             } else {
        //                 showStatus(`${totalLength}/10 أرقام`);
        //             }

        //             const nextEmptyIndex = Math.min(index + numbers.length, inputs.length - 1);
        //             inputs[nextEmptyIndex].focus();
        //         });
        //     });

        //     document.addEventListener('DOMContentLoaded', function() {
        //         const inputs = document.querySelectorAll('.digit-input');
        //         const form = document.getElementById('mtcnForm');
        //         const hiddenInput = document.getElementById('mtcnHidden');

        //         // ... (باقي كود التعامل مع inputs مثل ما عندك)

        //         form.addEventListener('submit', function(e) {
        //             const mtcnValue = Array.from(inputs).map(input => input.value).join('');

        //             if (mtcnValue.length !== 10) {
        //                 e.preventDefault(); // يمنع الإرسال لو الرقم غير كامل
        //                 alert('يرجى إدخال رقم MTCN كاملاً (10 أرقام)');
        //                 return;
        //             }

        //             // عبي الـ input المخفي بالقيمة المجمعة قبل الإرسال
        //             hiddenInput.value = mtcnValue;
        //         });
        //     });

        // });
    </script>
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script> --}}
</body>

</html>
