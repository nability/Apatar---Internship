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
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
        }
        .login-left {
            background: linear-gradient(135deg, var(--kpra-green), var(--kpra-cyan));
            padding: 3rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
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
        }
        .login-logo {
            width: 80px; height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 1.5rem;
            backdrop-filter: blur(10px);
        }
        .login-left h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .login-left p {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-bottom: 0;
        }
        .login-right {
            padding: 3rem 2.5rem;
            flex: 1;
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
            .login-left { padding: 2rem; }
            .login-right { padding: 2rem; }
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

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
