<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - لوحة التحكم الإدارية</title>
    <link rel="stylesheet" href="{{ asset('login-style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <i class="fas fa-tachometer-alt"></i>
                    <h1>لوحة التحكم الإدارية</h1>
                </div>
                <p>مرحباً بك، يرجى تسجيل الدخول للمتابعة</p>
            </div>
 
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 
            <form class="login-form" action="{{ route('admin.login') }}" method="POST" id="loginForm">
                @csrf
                <div class="form-group">
                    <label for="username">اسم المستخدم</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="email" id="username" name="username" required placeholder="أدخل اسم المستخدم">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input name="password" type="password" id="password" name="password" required placeholder="أدخل كلمة المرور">
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                {{-- <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" id="rememberMe">
                        <span class="checkmark"></span>
                        تذكرني
                    </label>
                    <a href="#" class="forgot-password">نسيت كلمة المرور؟</a>
                </div> --}}

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    تسجيل الدخول
                </button>
            </form>

            <div class="login-footer">
                <p>&copy; 2024 لوحة التحكم الإدارية. جميع الحقوق محفوظة.</p>
            </div>
        </div>

        <!-- خلفية متحركة -->
        <div class="background-animation">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
            <div class="floating-shape shape-4"></div>
            <div class="floating-shape shape-5"></div>
        </div>
    </div>

    <script src="{{ asset('login-script.js') }}"></script>
</body>

</html>
