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
    {{-- Google Fonts: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            /* Color System - Healthcare SaaS */
            --primary: #087F5B;
            --primary-dark: #056B4D;
            --primary-light: #E7F5EF;
            --background: #F7F8F7;
            --surface: #FFFFFF;
            --text-primary: #1F2933;
            --text-secondary: #7A858F;
            --text-muted: #9AA3AA;
            --border: #E7EBE9;
            --border-strong: #DDE4E0;
            --success: #2E9B68;
            --warning: #E6A23C;
            --danger: #D9534F;
            --info: #4C8DFF;

            /* Legacy aliases for backward compat */
            --kpra-green: #087F5B;
            --kpra-cyan: #06b6d4;
            --kpra-sidebar: #FFFFFF;
            --kpra-sidebar-hover: #F2F6F4;
            --kpra-text-muted: #7A858F;
            --kpra-body-bg: #F7F8F7;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 68px;

            /* Spacing */
            --space-1: 4px;
            --space-2: 8px;
            --space-3: 12px;
            --space-4: 16px;
            --space-5: 20px;
            --space-6: 24px;
            --space-8: 32px;

            /* Border Radius */
            --radius-sm: 8px;
            --radius-md: 10px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --radius-full: 999px;

            /* Shadows */
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.05);
            --shadow-card: 0 4px 20px rgba(0, 0, 0, 0.04);

            /* Transitions */
            --transition-fast: 150ms ease;
            --transition-base: 200ms ease;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--background);
            color: var(--text-primary);
            margin: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Sidebar - Green Theme */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--primary);
            border-right: none;
            border-radius: 0 var(--radius-xl) var(--radius-xl) 0;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            z-index: 1040;
            overflow-y: auto;
            overflow-x: hidden;
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 4px; }

        .sidebar-brand {
            padding: var(--space-4) var(--space-4) var(--space-3);
            border-bottom: 1px solid rgba(255,255,255,0.15);
            transition: padding 0.25s ease;
        }
        .sidebar-brand .brand-logo {
            display: flex; align-items: center; gap: var(--space-3); text-decoration: none;
        }
        .sidebar-brand .brand-icon {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.2);
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: #fff;
            flex-shrink: 0;
        }
        .sidebar-brand .brand-text h6 {
            margin: 0; font-size: 0.82rem; font-weight: 700; color: #fff; white-space: nowrap;
        }
        .sidebar-brand .brand-text span {
            font-size: 0.65rem; color: rgba(255,255,255,0.7); white-space: nowrap;
        }

        .sidebar-hospital {
            padding: var(--space-2) var(--space-4);
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }
        .sidebar-hospital .hosp-badge {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: var(--radius-md);
            padding: 4px 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .sidebar-hospital .hosp-badge p { margin: 0; font-size: 0.7rem; color: rgba(255,255,255,0.7); }
        .sidebar-hospital .hosp-badge strong { font-size: 0.8rem; color: #fff; font-weight: 600; white-space: nowrap; }

        .sidebar-nav { padding: var(--space-2) 0; flex: 1; }
        .nav-section-label {
            padding: var(--space-2) var(--space-4) 4px;
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            white-space: nowrap;
        }

        .sidebar-link {
            display: flex; align-items: center; gap: var(--space-3);
            padding: 0.42rem 0.75rem;
            color: rgba(255,255,255,0.8);
            background: transparent;
            text-decoration: none;
            font-size: 0.8125rem;
            font-weight: 500;
            margin: 2px 8px;
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
            white-space: nowrap;
        }
        .sidebar-link:hover { color: #fff; background: rgba(255,255,255,0.12); }
        .sidebar-link.active {
            color: var(--primary);
            background: linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(255,255,255,0.88) 100%);
            font-weight: 600;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.18);
            position: relative;
        }
        .sidebar-link.active:hover {
            background: linear-gradient(135deg, #fff 0%, rgba(255,255,255,0.95) 100%);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.22);
            transform: translateY(-1px);
        }
        .sidebar-link .nav-icon {
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            border-radius: var(--radius-sm); font-size: 0.8rem;
            color: rgba(255,255,255,0.8);
            transition: all var(--transition-fast);
            flex-shrink: 0;
        }
        .sidebar-link.active .nav-icon {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 2px 6px rgba(8, 127, 91, 0.3);
        }
        .sidebar-link.active:hover .nav-icon {
            box-shadow: 0 3px 10px rgba(8, 127, 91, 0.4);
            transform: scale(1.05);
        }
        .sidebar-link:hover .nav-icon {
            color: #fff;
        }

        /* Sidebar Collapsed State */
        #sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        #sidebar.collapsed .sidebar-brand {
            padding: var(--space-3) 0;
        }
        #sidebar.collapsed .sidebar-brand .brand-logo {
            justify-content: center;
        }
        #sidebar.collapsed .brand-text,
        #sidebar.collapsed .sidebar-hospital,
        #sidebar.collapsed .nav-section-label,
        #sidebar.collapsed .link-text {
            display: none !important;
        }
        #sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding: 0.45rem 0;
            margin: 4px 6px;
        }

        .sidebar-footer {
            padding: var(--space-4) var(--space-5);
            border-top: 1px solid rgba(255,255,255,0.15);
        }
        .sidebar-footer .user-card {
            display: flex; align-items: center; gap: var(--space-3);
            padding: var(--space-3) var(--space-4);
            border-radius: var(--radius-md);
            background: rgba(255,255,255,0.1);
        }
        .sidebar-footer .user-info-section {
            flex: 1; overflow: hidden; cursor: pointer;
            transition: all var(--transition-fast);
        }
        .sidebar-footer .user-info-section:hover {
            opacity: 0.9;
        }
        .sidebar-footer .user-role-trigger {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.7rem;
            color: rgba(255,255,255,0.8);
            font-weight: 600;
            margin-top: 0.25rem;
        }
        .sidebar-footer .role-chevron {
            font-size: 0.6rem;
            transition: transform var(--transition-fast);
        }
        .sidebar-footer .user-info-section[aria-expanded="true"] .role-chevron {
            transform: rotate(180deg);
        }
        .sidebar-footer .user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: 700; color: #fff;
        }
        .sidebar-name { font-size: 0.8rem; font-weight: 600; color: #fff; margin: 0; }
        .sidebar-role { font-size: 0.7rem; color: rgba(255,255,255,0.7); margin: 0; }
        
        .role-switcher-dropdown {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            padding: var(--space-2);
            min-width: 200px;
            max-height: 300px;
            overflow-y: auto;
        }
        .role-switcher-item {
            display: block;
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-sm);
            font-size: 0.8rem;
            color: var(--text-primary);
            text-decoration: none;
            transition: background var(--transition-fast);
        }
        .role-switcher-item:hover {
            background: var(--primary-light);
            color: var(--primary);
        }
        .role-switcher-item.active {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
        }

        /* Main Wrapper */
        #main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #main-wrapper.sidebar-collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        #topnav {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: var(--space-3) var(--space-6);
            display: flex; align-items: center; justify-content: space-between;
        }

        .btn-sidebar-toggle {
            background: var(--background);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-primary);
            cursor: pointer;
            transition: all var(--transition-fast);
            font-size: 0.9rem;
        }
        .btn-sidebar-toggle:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
        }

        .content-body { padding: var(--space-6); flex: 1; }

        .btn-kpra {
            background: var(--primary);
            border: none; color: #fff; font-weight: 600;
            border-radius: var(--radius-md);
            padding: var(--space-2) var(--space-4);
            font-size: 0.875rem;
            transition: background var(--transition-fast), transform var(--transition-fast);
        }
        .btn-kpra:hover { background: var(--primary-dark); color: #fff; transform: translateY(-1px); }

        .online-status {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-3);
            border: 1px solid var(--border);
            border-radius: var(--radius-full);
            background: var(--surface);
            color: var(--text-secondary);
            font-size: 0.75rem;
            font-weight: 500;
            line-height: 1;
            white-space: nowrap;
        }

        .online-status i {
            color: var(--success);
            font-size: 0.5rem;
        }

        .stat-card {
            background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-xl); padding: var(--space-5);
            position: relative; overflow: hidden; transition: transform var(--transition-fast), box-shadow var(--transition-fast);
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-card); }

        @keyframes kpra-fade-up {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-body > *,
        .content-body .card,
        .content-body .access-card,
        .content-body .cp-card,
        .content-body .module-card,
        .content-body .alert-item,
        .content-body .chart-placeholder {
            opacity: 0;
        }

        .page-ready .content-body > *,
        .page-ready .content-body .card,
        .page-ready .content-body .access-card,
        .page-ready .content-body .cp-card,
        .page-ready .content-body .module-card,
        .page-ready .content-body .alert-item,
        .page-ready .content-body .chart-placeholder {
            animation: kpra-fade-up 0.6s ease-out both;
        }

        .content-body .row > [class*="col-"]:nth-child(2) > * { animation-delay: 0.06s; }
        .content-body .row > [class*="col-"]:nth-child(3) > * { animation-delay: 0.12s; }
        .content-body .row > [class*="col-"]:nth-child(4) > * { animation-delay: 0.18s; }

        .content-body .module-card,
        .content-body .cp-card,
        .content-body .access-card,
        .content-body .btn,
        .content-body button,
        .content-body a:not(.sidebar-link) {
            transition: transform var(--transition-fast), box-shadow var(--transition-fast), border-color var(--transition-fast), opacity var(--transition-fast);
        }

        .content-body .module-card:hover,
        .content-body .cp-card:hover,
        .content-body .access-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
        }

        .content-body .btn:hover,
        .content-body button:hover,
        .content-body a:not(.sidebar-link):hover {
            transform: translateY(-1px);
        }

        .sidebar-link {
            transition: color var(--transition-fast), background var(--transition-fast), transform var(--transition-fast);
        }

        .sidebar-link:hover {
            transform: translateX(2px);
        }

        @media (prefers-reduced-motion: reduce) {
            .content-body > *,
            .content-body .card,
            .content-body .access-card,
            .content-body .cp-card,
            .content-body .module-card,
            .content-body .alert-item,
            .content-body .chart-placeholder {
                animation: none;
                opacity: 1;
            }

            .content-body .module-card:hover,
            .content-body .cp-card:hover,
            .content-body .access-card:hover,
            .content-body .btn:hover,
            .content-body button:hover,
            .content-body a:not(.sidebar-link):hover,
            .sidebar-link:hover {
                transform: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body x-data="{ 
    sidebarCollapsed: localStorage.getItem('sidebar_collapsed') === 'true',
    toggleSidebar() {
        this.sidebarCollapsed = !this.sidebarCollapsed;
        localStorage.setItem('sidebar_collapsed', this.sidebarCollapsed);
    }
}">

    {{-- Sidebar --}}
    <nav id="sidebar" :class="sidebarCollapsed ? 'collapsed' : ''">
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
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Dashboard">
                <div class="nav-icon"><i class="fa-solid fa-chart-pie"></i></div>
                <span class="link-text">Dashboard</span>
            </a>

            @php
                $user = Auth::user();
                $activeRole = \App\Helpers\RoleHelper::getActiveRole();
                
                if ($user->isAdmin()) {
                    $accessibleModules = \App\Models\Module::orderBy('sidebar_order')->get();
                } elseif ($activeRole) {
                    $accessibleModules = \App\Models\Module::whereHas('roleAccesses', function ($query) use ($activeRole) {
                        $query->where('role_id', $activeRole->id)
                            ->where('can_view', true);
                    })->orderBy('sidebar_order')->get();
                } else {
                    $accessibleModules = collect();
                }
            @endphp

            @if($accessibleModules->isNotEmpty())
                <div class="nav-section-label mt-3">Modul Akses</div>
                @foreach($accessibleModules as $mod)
                    @php
                        $isRouteActive = false;
                        if ($mod->key === 'kuantitatif') $isRouteActive = request()->routeIs('kuantitatif.*');
                        elseif ($mod->key === 'kualitatif') $isRouteActive = request()->routeIs('kualitatif.*');
                        elseif ($mod->key === 'pga') $isRouteActive = request()->routeIs('pga.*');
                        elseif ($mod->key === 'farmasi') $isRouteActive = request()->routeIs('integrasi.farmasi');
                        elseif ($mod->key === 'clinical_pathway') $isRouteActive = request()->routeIs('integrasi.clinical-pathway');
                    @endphp
                    <a href="{{ route($mod->route_prefix) }}" class="sidebar-link {{ $isRouteActive ? 'active' : '' }}" title="{{ $mod->label }}">
                        <div class="nav-icon"><i class="{{ $mod->icon ?? 'fa-solid fa-cube' }}"></i></div>
                        <span class="link-text">{{ $mod->label }}</span>
                    </a>
                @endforeach
            @endif

            @if($user->isAdmin() || ($activeRole && $activeRole->isAdmin()))
                <div class="nav-section-label mt-3">Administrasi</div>
                <a href="{{ route('admin.access.index') }}" class="sidebar-link {{ request()->routeIs('admin.access.*') ? 'active' : '' }}" title="Kelola Akses Role">
                    <div class="nav-icon"><i class="fa-solid fa-user-shield"></i></div>
                    <span class="link-text">Kelola Akses Role</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" title="Manajemen User">
                    <div class="nav-icon"><i class="fa-solid fa-users-gear"></i></div>
                    <span class="link-text">Manajemen User</span>
                </a>
            @endif

        </div>

    </nav>

    {{-- Main Wrapper --}}
    <div id="main-wrapper" :class="sidebarCollapsed ? 'sidebar-collapsed' : ''">
        <header id="topnav" class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button type="button" @click="toggleSidebar()" class="btn-sidebar-toggle" title="Buka / Tutup Sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h5 class="mb-0 fw-700" style="font-size:1.1rem; color:var(--text-primary);">@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                
                @php
                    $user = Auth::user();
                    $userRoles = $user->roles;
                    $activeRole = \App\Helpers\RoleHelper::getActiveRole();
                @endphp
                
                <div x-data="{ open: false, roleOpen: false }" style="position: relative;">
                    <div class="user-card" @click="open = !open" style="cursor: pointer; padding: 0.5rem 0.75rem; border-radius: var(--radius-md); background: var(--background); border: 1px solid var(--border); transition: all 0.2s;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar" style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.8rem;">
                                {{ substr($user->name ?? 'A', 0, 1) }}
                            </div>
                            <div style="display: flex; flex-direction: column; min-width: 0;">
                                <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-primary); white-space: nowrap;">{{ $user->name }}</span>
                                <span style="font-size: 0.7rem; color: var(--primary); font-weight: 500; display: flex; align-items: center; gap: 0.3rem;">
                                    {{ $user->isAdmin() ? 'Administrator Utama' : ($activeRole?->label ?? 'Pilih Role') }}
                                    <i class="fa-solid fa-chevron-down" style="font-size: 0.6rem; transition: transform 0.2s;" :style="open && 'transform: rotate(180deg)'"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Dropdown Menu --}}
                    <div x-show="open" @click.away="open = false; roleOpen = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        style="position: absolute; top: calc(100% + 8px); right: 0; z-index: 1050; min-width: 220px;
                               background: var(--primary); border-radius: var(--radius-xl); box-shadow: 4px 4px 24px rgba(0,0,0,0.18);
                               overflow: hidden; padding: 0.5rem 0;">

                        {{-- User Info Header --}}
                        <div style="padding: 0.75rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.15); display: flex; align-items: center; gap: 0.6rem;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">
                                {{ substr($user->name ?? 'A', 0, 1) }}
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 0.82rem; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $user->name }}</div>
                                <div style="font-size: 0.7rem; color: rgba(255,255,255,0.7);">{{ $user->email }}</div>
                            </div>
                        </div>

                        {{-- Switch Role Sub-dropdown --}}
                        @if($userRoles->count() > 1)
                        <div style="padding: 0.25rem 0.5rem; position: relative;">
                            <button @click="roleOpen = !roleOpen" style="width: 100%; display: flex; align-items: center; gap: 0.6rem; padding: 0.5rem 0.6rem; border-radius: var(--radius-md); background: transparent; border: none; cursor: pointer; color: rgba(255,255,255,0.8); font-size: 0.82rem; font-weight: 500; transition: all 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.8)'">
                                <div style="width: 28px; height: 28px; border-radius: 8px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; flex-shrink: 0;">
                                    <i class="fa-solid fa-shuffle"></i>
                                </div>
                                <span style="flex: 1; text-align: left;">Ganti Role</span>
                                <i class="fa-solid fa-chevron-right" style="font-size: 0.6rem; transition: transform 0.2s;" :style="roleOpen && 'transform: rotate(90deg)'"></i>
                            </button>

                            {{-- Sub dropdown roles --}}
                            <div x-show="roleOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 -translate-x-2"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                style="margin-top: 0.25rem; background: rgba(255,255,255,0.12); border-radius: var(--radius-md); padding: 0.25rem; border: 1px solid rgba(255,255,255,0.15);">
                                @foreach($userRoles as $role)
                                <form method="POST" action="{{ route('role.switch', $role) }}" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="width: 100%; display: flex; align-items: center; gap: 0.6rem; padding: 0.45rem 0.6rem; border-radius: var(--radius-sm); background: {{ $activeRole?->id === $role->id ? 'rgba(255,255,255,0.2)' : 'transparent' }}; border: none; cursor: pointer; color: {{ $activeRole?->id === $role->id ? '#fff' : 'rgba(255,255,255,0.75)' }}; font-size: 0.8rem; font-weight: {{ $activeRole?->id === $role->id ? '600' : '400' }}; transition: all 0.15s; text-align: left;" onmouseover="this.style.background='rgba(255,255,255,0.2)';this.style.color='#fff'" onmouseout="this.style.background='{{ $activeRole?->id === $role->id ? 'rgba(255,255,255,0.2)' : 'transparent' }}';this.style.color='{{ $activeRole?->id === $role->id ? '#fff' : 'rgba(255,255,255,0.75)' }}'">
                                        @if($activeRole?->id === $role->id)
                                            <i class="fa-solid fa-circle-check" style="font-size: 0.7rem; flex-shrink: 0;"></i>
                                        @else
                                            <i class="fa-regular fa-circle" style="font-size: 0.7rem; flex-shrink: 0;"></i>
                                        @endif
                                        {{ $role->label }}
                                    </button>
                                </form>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Profile --}}
                        <div style="padding: 0.25rem 0.5rem;">
                            <a href="{{ route('profile.edit') }}" style="display: flex; align-items: center; gap: 0.6rem; padding: 0.5rem 0.6rem; border-radius: var(--radius-md); color: rgba(255,255,255,0.8); font-size: 0.82rem; font-weight: 500; text-decoration: none; transition: all 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.8)'">
                                <div style="width: 28px; height: 28px; border-radius: 8px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; flex-shrink: 0;">
                                    <i class="fa-solid fa-user-gear"></i>
                                </div>
                                Pengaturan Profil
                            </a>
                        </div>

                        {{-- Divider --}}
                        <div style="border-top: 1px solid rgba(255,255,255,0.15); margin: 0.25rem 0;"></div>

                        {{-- Logout --}}
                        <div style="padding: 0.25rem 0.5rem;">
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" style="width: 100%; display: flex; align-items: center; gap: 0.6rem; padding: 0.5rem 0.6rem; border-radius: var(--radius-md); background: transparent; border: none; cursor: pointer; color: rgba(255,160,140,0.9); font-size: 0.82rem; font-weight: 500; transition: all 0.15s; text-align: left;" onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.color='#ffb3a0'" onmouseout="this.style.background='transparent';this.style.color='rgba(255,160,140,0.9)'">
                                    <div style="width: 28px; height: 28px; border-radius: 8px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; flex-shrink: 0;">
                                        <i class="fa-solid fa-right-from-bracket"></i>
                                    </div>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @if($userRoles->count() <= 1)
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted p-0" title="Logout" style="font-size:0.9rem;">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                @endif
            </div>
        </header>

        <div class="content-body">
            @yield('content')
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('load', function () {
            requestAnimationFrame(function () {
                document.body.classList.add('page-ready');
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
