<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4a6fa5;
            --secondary-color: #166088;
            --accent-color: #4fc3f7;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Header Styles */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.5rem;
        }

        .logo i {
            margin-left: 10px;
            font-size: 2rem;
            color: var(--secondary-color);
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark-color);
            cursor: pointer;
        }

        .nav-links {
            display: flex;
            list-style: none;
            align-items: center;
        }

        .nav-links li {
            margin-right: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .btn {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-outline {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background-color: var(--primary-color);
            color: white !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white !important;
            border: 2px solid var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        /* Mobile Menu Styles */
        .mobile-menu {
            display: none;
            flex-direction: column;
            background: white;
            padding: 20px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 999;
        }

        .mobile-menu.show {
            display: flex;
        }

        .mobile-menu .btn {
            margin-bottom: 10px;
            text-align: center;
            width: 100%;
        }

        /* Hero Section */
        .hero {
            padding: 150px 0 80px;
            background: linear-gradient(135deg, rgba(74, 111, 165, 0.1) 0%, rgba(22, 96, 136, 0.1) 100%);
            text-align: center;
        }

        .hero h1 {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            color: var(--dark-color);
            max-width: 800px;
            margin: 0 auto 30px;
        }

        .hero-btns {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background-color: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
            color: var(--secondary-color);
            font-size: 2rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background-color: var(--accent-color);
            margin: 15px auto 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background-color: var(--light-color);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 4px solid var(--accent-color);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--secondary-color);
        }

        /* Stats Section */
        .stats {
            padding: 60px 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .stat-item p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* CTA Section */
        .cta {
            padding: 80px 0;
            text-align: center;
            background-color: var(--light-color);
        }

        .cta h2 {
            font-size: 2rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        .cta p {
            max-width: 700px;
            margin: 0 auto 30px;
            font-size: 1.1rem;
        }

        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 30px 0;
            text-align: center;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            list-style: none;
            margin-bottom: 20px;
        }

        .footer-links li {
            margin: 0 15px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--accent-color);
        }

        .copyright {
            opacity: 0.8;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .nav-links {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero {
                padding: 120px 0 60px;
            }

            .hero h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .hero-btns {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 250px;
                margin-bottom: 10px;
            }
        }
    </style>
    <style>
        :root {
            --primary-color: #4a6fa5;
            --secondary-color: #166088;
            --accent-color: #4fc3f7;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        /* Smooth scroll offset for fixed header */
        section {
            scroll-margin-top: 80px;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <a href="#" class="logo">
                <i class="fas fa-clinic-medical"></i>
                <span>Arbeto System Management</span>
            </a>

            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>

            <ul class="nav-links">
                @if (Route::has('login'))
                @auth
                <li><a href="{{ url('/dashboard') }}" class="btn btn-outline">لوحة التحكم</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">تسجيل الخروج</button>
                    </form>
                </li>
                @else
                <li><a href="{{ route('login') }}" class="btn btn-outline">تسجيل الدخول</a></li>
                @if (Route::has('register'))
                <li><a href="{{ route('register') }}" class="btn btn-primary text-light">إنشاء حساب</a></li>
                @endif
                @endauth
                @endif
            </ul>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            @if (Route::has('login'))
            @auth
            <a href="{{ url('/dashboard') }}" class="btn btn-outline">لوحة التحكم</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-primary">تسجيل الخروج</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-outline">تسجيل الدخول</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-primary">إنشاء حساب</a>
            @endif
            @endauth
            @endif
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>نظام متكامل لإدارة مركز الأشعة الخاص بك</h1>
            <p>حلول ذكية لإدارة كافة جوانب مركزك الطبي من الحسابات المالية إلى سجلات المرضى والتقارير الطبية، كل ذلك في نظام واحد متكامل وسهل الاستخدام.</p>

            <div class="hero-btns">
                <a href="#features" class="btn btn-primary">اكتشف الميزات</a>
                <a href="{{ route('register') }}" class="btn btn-outline">جربه الآن</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title">مميزات نظامنا المتكامل</h2>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3>إدارة مالية متكاملة</h3>
                    <p>نظام محاسبي متكامل لمتابعة الإيرادات والمصروفات والفواتير والمدفوعات مع تقارير مالية دقيقة.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-injured"></i>
                    </div>
                    <h3>سجلات المرضى</h3>
                    <p>إدارة كاملة لسجلات المرضى، التاريخ الطبي، الفحوصات السابقة، والوصفات الطبية في مكان واحد.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>حجز المواعيد</h3>
                    <p>نظام حجز مواعيد ذكي يتكامل مع التقويم ويرسل تذكيرات تلقائية للمرضى والأطباء.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <h3>التقارير الطبية</h3>
                    <p>إنشاء وتخزين وإدارة التقارير الطبية بسهولة مع إمكانية مشاركتها مع المرضى والأطباء الآخرين.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>إحصائيات وتحليلات</h3>
                    <p>لوحات تحكم تفاعلية مع رسوم بيانية توضح أداء المركز واتجاهات العملاء والتحليلات المالية.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>متاح على جميع الأجهزة</h3>
                    <p>يمكن الوصول إلى النظام من أي جهاز كمبيوتر أو جهاز لوحي أو هاتف ذكي مع واجهة مستخدم متجاوبة.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>100%</h3>
                    <p>أمان وحماية للبيانات</p>
                </div>
                <div class="stat-item">
                    <h3>24/7</h3>
                    <p>دعم فني متواصل</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>ميزة متقدمة</p>
                </div>
                <div class="stat-item">
                    <h3>1000+</h3>
                    <p>عميل راضٍ</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>جاهز لتحويل إدارة مركزك إلى مستوى جديد؟</h2>
            <p>سجل الآن وابدأ رحلتك نحو إدارة أكثر كفاءة واحترافية لمركز الأشعة الخاص بك. وفر الوقت والجهد وركز على ما يهم حقًا - رعاية المرضى.</p>
            <a href="{{ route('register') }}" class="btn btn-primary">ابدأ الأن</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="copyright">All rights reserved.© ASM 2025</p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('show');
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>