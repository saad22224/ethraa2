<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowPay - تطبيق التحويلات المالية</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

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
    }
</style>

<body>
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
                    <li><a href="{{ route('tracking') }}"> تعقب الحواله</a></li>
                </ul>

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
                        <a href="#" class="btn btn-primary">
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
                    <img src="{{ asset('assets/1.jpg') }}"
                        alt="منظر طبيعي">
                </div>

                <div class="slide">
                    <img src="{{ asset('assets/2.jpg') }}"
                        alt="بحيرة">
                </div>

                <div class="slide">
                    <img src="{{ asset('assets/3.jpg') }}"
                        alt="غابة">
                </div>

                <div class="slide">
                    <img src="{{ asset('assets/4.jpg') }}"
                        alt="جبال">
                </div>

                <div class="slide">
                    <img src="{{ asset('assets/5.jpg') }}"
                        alt="شاطئ">

                </div>
                <div class="slide">
                    <img src="{{ asset('assets/6.jpg') }}"
                        alt="شاطئ">

                </div>
                <div class="slide">
                    <img src="{{ asset('assets/7.jpg') }}"
                        alt="شاطئ">

                </div>
                <div class="slide">
                    <img src="{{ asset('assets/8.jpg') }}"
                        alt="شاطئ">

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
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
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
                        <p><i class="fas fa-envelope"></i> info@flowpay.com</p>
                        <p><i class="fas fa-phone"></i> +966 50 123 4567</p>
                        <p><i class="fas fa-map-marker-alt"></i> الرياض، المملكة العربية السعودية</p>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Sadad Union. جميع الحقوق محفوظة</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('land.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
