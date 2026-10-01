<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - APATAR RS</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome 6 --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    {{-- Google Fonts: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #087F5B;
            --primary-dark: #056B4D;
            --primary-light: #E7F5EF;
            --text-primary: #1F2933;
            --text-secondary: #7A858F;
            --border: #E2E8F0;
        }

        * { box-sizing: border-box; }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #04523B 0%, #087F5B 45%, #0f766e 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle background glow elements */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            top: -100px;
            left: -100px;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.06) 0%, transparent 70%);
            bottom: -50px;
            right: 15%;
            pointer-events: none;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1200px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 3rem;
            position: relative;
            z-index: 1;
        }

        /* Left Branding Section */
        .login-brand-side {
            flex: 1;
            color: #fff;
            padding: 1rem 2rem;
            max-width: 540px;
        }

        .brand-header {
            display: inline-flex;
            align-items: center;
            gap: 0.85rem;
            text-decoration: none;
            color: #fff;
            margin-bottom: 3.5rem;
        }

        .brand-header-icon {
            width: 46px;
            height: 46px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #fff;
        }

        .brand-header-text h5 {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .brand-hero-title {
            font-size: clamp(2.5rem, 4.5vw, 3.8rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        .brand-hero-subtitle {
            font-size: 1.15rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 0.75rem;
        }

        .brand-hero-desc {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.65;
            margin-bottom: 0;
        }

        /* Right Floating White Card */
        .login-card-container {
            flex: 0 0 450px;
            max-width: 450px;
            width: 100%;
        }

        .login-card {
            background: #FFFFFF;
            border-radius: 36px;
            padding: 3rem 2.5rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.22);
            position: relative;
        }

        .card-header-title {
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--text-primary);
            text-align: center;
            letter-spacing: -0.02em;
            margin-bottom: 0.4rem;
        }

        .card-header-subtitle {
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        /* Form Inputs - Pill Rounded Style */
        .form-input-pill {
            border-radius: 999px;
            border: 1.5px solid var(--border);
            padding: 0.75rem 1.4rem;
            font-size: 0.88rem;
            background: #fff;
            color: var(--text-primary);
            transition: all 0.2s ease;
            width: 100%;
        }

        .form-input-pill::placeholder {
            color: #A0AEC0;
            font-size: 0.88rem;
        }

        .form-input-pill:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(8, 127, 91, 0.12);
            outline: none;
        }

        .forgot-link {
            color: var(--text-secondary);
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.15s;
        }

        .forgot-link:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        /* Pill Button */
        .btn-pill-login {
            background: linear-gradient(135deg, #087F5B 0%, #056B4D 100%);
            border: none;
            color: #fff;
            font-weight: 700;
            padding: 0.85rem 1.5rem;
            border-radius: 999px;
            font-size: 0.95rem;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(8, 127, 91, 0.25);
            transition: all 0.2s ease;
        }

        .btn-pill-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(8, 127, 91, 0.35);
            color: #fff;
        }

        .btn-pill-login:active {
            transform: translateY(0);
        }

        /* OR Divider */
        .login-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.75rem 0 1.25rem;
        }

        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border);
        }

        .login-divider span {
            padding: 0 0.85rem;
            color: #A0AEC0;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* Quick Info Badges */
        .social-pill-row {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .social-pill {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.65rem 0.85rem;
            border-radius: 999px;
            border: 1px solid #EDF2F7;
            background: #F8FAFC;
            color: var(--text-primary);
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .social-pill:hover {
            background: #EDF2F7;
            color: var(--primary-dark);
        }

        .social-pill i {
            font-size: 0.9rem;
            color: var(--primary);
        }

        .card-footer-text {
            text-align: center;
            font-size: 0.82rem;
            color: var(--text-secondary);
            margin-bottom: 0;
        }

        .card-footer-text a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .card-footer-text a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
                align-items: center;
                gap: 2.5rem;
            }

            .login-brand-side {
                text-align: center;
                padding: 0;
                max-width: 100%;
            }

            .brand-header {
                margin-bottom: 1.5rem;
            }

            .login-card-container {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }

            .login-card {
                padding: 2.25rem 1.5rem;
                border-radius: 28px;
            }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        {{-- Left Branding Panel --}}
        <div class="login-brand-side">
            <a href="#" class="brand-header">
                <div class="brand-header-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div class="brand-header-text">
                    <h5>APATAR RS</h5>
                </div>
            </a>

            <div class="brand-hero-title">
                Hey, Hello!
            </div>

            <div class="brand-hero-subtitle">
                Sistem Pengendalian Resistensi Antimikroba
            </div>

            <p class="brand-hero-desc">
                Monitoring penggunaan antibiotik, analisis kuantitatif DDD, kualitatif Gyssens, dan integrasi farmasi RS Sekarwangi.
            </p>
        </div>

        {{-- Right Floating Card --}}
        <div class="login-card-container">
            <div class="login-card">
                <div class="card-header-title">
                    Welcome Back
                </div>
                <div class="card-header-subtitle">
                    Silakan masukkan email & password untuk login.
                </div>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="alert alert-success py-2 px-3 mb-3" style="border-radius: 12px; font-size: 0.85rem;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email / Username --}}
                    <div class="mb-3">
                        <input id="email" type="email" name="email" 
                               class="form-input-pill @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required autofocus autocomplete="username" 
                               placeholder="Email Pengguna">
                        @error('email')
                            <div class="text-danger mt-1 ps-3" style="font-size: 0.78rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-2">
                        <input id="password" type="password" name="password" 
                               class="form-input-pill @error('password') is-invalid @enderror" 
                               required autocomplete="current-password" 
                               placeholder="Password">
                        @error('password')
                            <div class="text-danger mt-1 ps-3" style="font-size: 0.78rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Forgot Password Link --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                        <label class="d-flex align-items-center gap-2 m-0" style="cursor: pointer;">
                            <input type="checkbox" name="remember" id="remember_me" style="accent-color: var(--primary); cursor: pointer;">
                            <span style="font-size: 0.8rem; color: var(--text-secondary);">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    {{-- Login Button --}}
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn-pill-login">
                            Login
                        </button>
                    </div>

                    {{-- Footer Help Link --}}
                    <p class="card-footer-text">
                        Butuh bantuan akun? <a href="mailto:it@rssekarwangi.go.id">Hubungi IT</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
