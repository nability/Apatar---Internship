<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Apatar - @yield('title', 'Dashboard')</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome 6 --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    {{-- Google Fonts: Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --kpra-green:   #10b981;
            --kpra-cyan:    #06b6d4;
            --kpra-sidebar: #0f172a;
            --kpra-sidebar-hover: #1e293b;
            --kpra-text-muted: #94a3b8;
            --kpra-body-bg: #f1f5f9;
            --sidebar-width: 260px;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--kpra-body-bg);
            color: #1e293b;
            margin: 0;
        }

        /* Sidebar */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--kpra-sidebar);
            display: flex;
            flex-direction: column;
            z-index: 1040;
            overflow-y: auto;
        }
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }

        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid #1e293b;
        }
        .sidebar-brand .brand-logo {
            display: flex; align-items: center; gap: 0.75rem; text-decoration: none;
        }
        .sidebar-brand .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--kpra-green), var(--kpra-cyan));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; color: #fff;
        }
        .sidebar-brand .brand-text h6 {
            margin: 0; font-size: 0.85rem; font-weight: 700; color: #f1f5f9;
        }
        .sidebar-brand .brand-text span {
            font-size: 0.68rem; color: var(--kpra-text-muted);
        }

        .sidebar-hospital {
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid #1e293b;
        }
        .sidebar-hospital .hosp-badge {
            background: linear-gradient(135deg, rgba(16,185,129,0.15), rgba(6,182,212,0.15));
            border: 1px solid rgba(16,185,129,0.25);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
        }
        .sidebar-hospital .hosp-badge p { margin: 0; font-size: 0.8rem; color: var(--kpra-text-muted); }
        .sidebar-hospital .hosp-badge strong { font-size: 0.95rem; color: #e2e8f0; font-weight: 700; }

        .sidebar-nav { padding: 1rem 0; flex: 1; }
        .nav-section-label {
            padding: 0.4rem 1.25rem;
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            color: #475569;
            text-transform: uppercase;
        }

        .sidebar-link {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.65rem 1.25rem;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.84rem;
            font-weight: 500;
            margin: 0.1rem 0.75rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .sidebar-link:hover { color: #f1f5f9; background: var(--kpra-sidebar-hover); }
        .sidebar-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, rgba(16,185,129,0.2), rgba(6,182,212,0.2));
            border: 1px solid rgba(16,185,129,0.3);
        }
        .sidebar-link .nav-icon {
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 6px; font-size: 0.8rem;
            background: rgba(255,255,255,0.05);
        }
        .sidebar-link.active .nav-icon {
            background: linear-gradient(135deg, var(--kpra-green), var(--kpra-cyan));
            color: #fff;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid #1e293b;
        }
        .sidebar-footer .user-card {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.75rem;
            border-radius: 8px;
            background: var(--kpra-sidebar-hover);
        }
        .sidebar-footer .user-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--kpra-green), var(--kpra-cyan));
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 700; color: #fff;
        }
        .sidebar-name { font-size: 0.78rem; font-weight: 600; color: #e2e8f0; margin: 0; }
        .sidebar-role { font-size: 0.67rem; color: var(--kpra-text-muted); margin: 0; }

        /* Main Wrapper */
        #main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #topnav {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.85rem 1.75rem;
            display: flex; align-items: center; justify-content: between;
        }

        .content-body { padding: 1.75rem; flex: 1; }

        .btn-kpra {
            background: linear-gradient(135deg, var(--kpra-green), var(--kpra-cyan));
            border: none; color: #fff; font-weight: 600;
            transition: opacity 0.2s;
        }
        .btn-kpra:hover { opacity: 0.9; color: #fff; }

        .stat-card {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 1.25rem;
            position: relative; overflow: hidden; transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    <nav id="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" class="brand-logo">
                <div class="brand-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div class="brand-text">
                    <h6>APATAR RS</h6>
                    <span>Antibiotik & Resistensi</span>
                </div>
            </a>
        </div>

        <div class="sidebar-hospital">
            <div class="hosp-badge">
                <p>Rumah Sakit</p>
                <strong>RS Sekarwangi</strong>
            </div>
        </div>

        <div class="sidebar-nav">
            <div class="nav-section-label">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <div class="nav-icon"><i class="fa-solid fa-chart-pie"></i></div>
                Dashboard
            </a>

            <div class="nav-section-label mt-3">Modul KPRA</div>
            <a href="{{ route('kuantitatif.index') }}" class="sidebar-link {{ request()->routeIs('kuantitatif.*') ? 'active' : '' }}">
                <div class="nav-icon"><i class="fa-solid fa-chart-column"></i></div>
                Kuantitatif (DDD)
            </a>
            <a href="{{ route('kualitatif.index') }}" class="sidebar-link {{ request()->routeIs('kualitatif.*') ? 'active' : '' }}">
                <div class="nav-icon"><i class="fa-solid fa-file-medical"></i></div>
                Kualitatif (Gyssens)
            </a>
            <a href="{{ route('pga.index') }}" class="sidebar-link {{ request()->routeIs('pga.*') ? 'active' : '' }}">
                <div class="nav-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                PGA & AWaRe
            </a>

            <div class="nav-section-label mt-3">Integrasi SIMRS</div>
            <a href="{{ route('integrasi.farmasi') }}" class="sidebar-link {{ request()->routeIs('integrasi.farmasi') ? 'active' : '' }}">
                <div class="nav-icon"><i class="fa-solid fa-prescription-bottle-medical"></i></div>
                Farmasi
            </a>
            <a href="{{ route('integrasi.clinical-pathway') }}" class="sidebar-link {{ request()->routeIs('integrasi.clinical-pathway') ? 'active' : '' }}">
                <div class="nav-icon"><i class="fa-solid fa-notes-medical"></i></div>
                Clinical Pathway
            </a>
        </div>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
                <div style="flex:1; overflow:hidden;">
                    <p class="sidebar-name text-truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="sidebar-role text-truncate">{{ Auth::user()->email ?? 'admin@apatar.com' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-muted p-0" title="Logout" style="font-size:0.85rem;">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Main Wrapper --}}
    <div id="main-wrapper">
        <header id="topnav" class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <h5 class="mb-0 fw-700" style="font-size:1.05rem; color:#0f172a;">@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-success bg-opacity-15 text-success px-3 py-2" style="font-size:0.75rem; border-radius:8px;">
                    <i class="fa-solid fa-circle me-1" style="font-size:0.5rem;"></i> Online — RS Sekarwangi
                </span>
                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px; font-size:0.8rem;">
                    <i class="fa-solid fa-user me-1"></i>Profil
                </a>
            </div>
        </header>

        <div class="content-body">
            @yield('content')
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
