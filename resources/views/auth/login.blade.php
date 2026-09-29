<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Apatar</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome 6 --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    {{-- Google Fonts: Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --kpra-green: #10b981;
            --kpra-cyan: #06b6d4;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }
        .login-card {
            min-height: 100vh;
            width: 100%;
            display: flex;
        }
        .login-left {
            flex: 0 0 50%;
            min-height: 100vh;
            padding: clamp(2rem, 6vw, 6rem);
            background: linear-gradient(145deg, #064e3b 0%, #0f766e 48%, #0891b2 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
            transform-origin: right center;
            will-change: transform, opacity;
            animation: reveal-left 1.2s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
        .login-left::before {
            content: '';
            position: absolute;
            top: -50%; right: -20%;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }
        .login-left::after {
            content: '';
            position: absolute;
            bottom: -30%; left: -10%;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }
        .login-left-content {
            position: relative;
            z-index: 1;
            max-width: 440px;
        }
        .login-logo {
            width: 88px; height: 88px;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.7rem;
            margin: 0 auto 1.5rem;
            backdrop-filter: blur(10px);
        }
        .login-left h2 {
            font-size: clamp(2rem, 3vw, 3rem);
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: 0.08em;
        }
        .login-left p {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 0;
            line-height: 1.7;
        }
        .login-right {
            flex: 0 0 50%;
            min-height: 100vh;
            padding: clamp(2rem, 7vw, 7rem);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-form-box {
            width: 100%;
            max-width: 440px;
            margin-left: auto;
            margin-right: auto;
            padding: clamp(1.75rem, 4vw, 3rem);
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
            transform-origin: left center;
            will-change: transform, opacity;
            animation: reveal-right 1.2s cubic-bezier(0.22, 1, 0.36, 1) 0.12s both;
        }

        @keyframes reveal-left {
            from {
                opacity: 0;
                transform: translateX(-100%) scaleX(0.82);
            }
            to {
                opacity: 1;
                transform: translateX(0) scaleX(1);
            }
        }

        @keyframes reveal-right {
            from {
                opacity: 0;
                transform: translateX(100%) scaleX(0.82);
            }
            to {
                opacity: 1;
                transform: translateX(0) scaleX(1);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .login-left,
            .login-form-box {
                animation: none;
            }
        }
        .login-right h3 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }
        .login-right p {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .form-control, .form-check-input {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
        }
        .form-control:focus {
            border-color: var(--kpra-green);
            box-shadow: 0 0 0 0.2rem rgba(16,185,129,0.15);
        }
        .btn-login {
            background: linear-gradient(135deg, var(--kpra-green), var(--kpra-cyan));
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-size: 0.95rem;
            width: 100%;
            transition: opacity 0.2s;
        }
        .btn-login:hover {
            opacity: 0.9;
            color: #fff;
        }
        .forgot-link {
            color: var(--kpra-cyan);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }
        .alert {
            border-radius: 10px;
            font-size: 0.85rem;
        }
        @media (max-width: 768px) {
            .login-card { flex-direction: column; }
            .login-left {
                flex-basis: auto;
                min-height: 42vh;
                padding: 3rem 1.5rem;
            }
            .login-right {
                flex-basis: auto;
                min-height: 58vh;
                padding: 3rem 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-card">
        {{-- Left Panel --}}
        <div class="login-left">
            <div class="login-left-content">
                <div class="login-logo">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h2>APATAR</h2>
                <p>Sistem Informasi KPRA<br>Rumah Sakit Sekarwangi</p>
                <p class="mt-4" style="font-size:0.8rem; opacity:0.8;">
                    Komite Pengendalian Resistensi Antimikroba
                </p>
            </div>
        </div>

        {{-- Right Panel (Form) --}}
        <div class="login-right">
            <div class="login-form-box">
                <h3>Selamat Datang</h3>
                <p>Masuk untuk mengakses dashboard KPRA</p>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="alert alert-success mb-3">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required autofocus autocomplete="username" 
                               placeholder="admin@apatar.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               required autocomplete="current-password" 
                               placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me" style="font-size:0.85rem; color:#64748b;">
                            Ingat saya
                        </label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-login">
                            <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk
                        </button>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Lupa kata sandi?
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
