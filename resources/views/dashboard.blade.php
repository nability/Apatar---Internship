@extends('layouts.kpra')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@push('styles')
<style>
    .welcome-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        border-radius: 16px;
        padding: 1.75rem 2rem;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -40%; right: -5%;
        width: 300px; height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(16,185,129,0.25) 0%, transparent 70%);
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -50%; left: 20%;
        width: 250px; height: 250px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(6,182,212,0.2) 0%, transparent 70%);
    }
    .module-card {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        transition: all 0.25s ease;
        cursor: pointer;
        background: #fff;
    }
    .module-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        border-color: rgba(16,185,129,0.3);
    }
    .module-card .card-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; color: #fff;
    }
    .alert-item {
        display: flex; align-items: start; gap: 0.75rem;
        padding: 0.75rem;
        border-radius: 10px;
        background: #f8fafc;
        border-left: 3px solid;
        transition: background 0.2s;
    }
    .alert-item:hover { background: #f1f5f9; }
    .alert-item.danger { border-color: #ef4444; }
    .alert-item.warning { border-color: #f59e0b; }
    .alert-item.info { border-color: #06b6d4; }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    {{-- Welcome Banner --}}
    <div class="welcome-banner mb-4">
        <div class="position-relative" style="z-index:1;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h4 class="text-white fw-600 mb-1">
                        Selamat Datang! 👋
                    </h4>
                    <p class="mb-0" style="color: #94a3b8; font-size: 0.875rem;">
                        Apatar — Rumah Sakit Sekarwangi
                        &nbsp;|&nbsp; Periode: <strong class="text-white">September 2026</strong>
                    </p>
                </div>
                <a href="{{ route('kuantitatif.index') }}"
                   class="btn btn-kpra btn-sm px-4 py-2"
                   style="border-radius:20px; font-size:0.82rem;">
                    <i class="fa-solid fa-chart-line me-2"></i>Lihat Laporan Bulan Ini
                </a>
            </div>
        </div>
    </div>

    {{-- KPI Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <x-stat-card
                title="Total DDD (Sep)"
                value="1.248"
                unit="DDD/100 HH"
                icon="fa-solid fa-chart-column"
                icon-bg="linear-gradient(135deg, #10b981, #06b6d4)"
                trend="+8.3%"
                :trend-up="false"
                description="Penggunaan antibiotik keseluruhan"
            />
        </div>
        <div class="col-6 col-xl-3">
            <x-stat-card
                title="Pasien Dievaluasi"
                value="147"
                unit="pasien"
                icon="fa-solid fa-user-injured"
                icon-bg="linear-gradient(135deg, #6366f1, #8b5cf6)"
                trend="+12 pasien"
                :trend-up="true"
                description="Evaluasi Gyssens aktif"
            />
        </div>
        <div class="col-6 col-xl-3">
            <x-stat-card
                title="Kepatuhan PGA"
                value="78"
                unit="%"
                icon="fa-solid fa-shield-check"
                icon-bg="linear-gradient(135deg, #f59e0b, #ef4444)"
                trend="-2.1%"
                :trend-up="false"
                description="Target > 80%"
            />
        </div>
        <div class="col-6 col-xl-3">
            <x-stat-card
                title="AWaRe Reserve"
                value="23"
                unit="resep"
                icon="fa-solid fa-triangle-exclamation"
                icon-bg="linear-gradient(135deg, #ef4444, #dc2626)"
                trend="-3 resep"
                :trend-up="true"
                description="Antibiotik lini terakhir"
            />
        </div>
    </div>

    {{-- Module Cards + Alerts --}}
    <div class="row g-3">

        {{-- Module Quick Access --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                <div class="card-header bg-white border-0 pt-3 px-4">
                    <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
                        <i class="fa-solid fa-th me-2" style="color:var(--kpra-green);"></i>
                        Akses Cepat — Modul Utama
                    </h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('kuantitatif.index') }}" class="module-card p-3 text-decoration-none">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="card-icon" style="background:linear-gradient(135deg,#10b981,#06b6d4);">
                                        <i class="fa-solid fa-chart-column"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-600" style="color:#0f172a;font-size:0.9rem;">Kuantitatif (DDD)</h6>
                                        <p class="mb-0 text-muted" style="font-size:0.78rem;">Analisis penggunaan antibiotik</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('kualitatif.index') }}" class="module-card p-3 text-decoration-none">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="card-icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                                        <i class="fa-solid fa-file-medical"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-600" style="color:#0f172a;font-size:0.9rem;">Kualitatif (Gyssens)</h6>
                                        <p class="mb-0 text-muted" style="font-size:0.78rem;">Evaluasi ketepatan penggunaan</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('pga.index') }}" class="module-card p-3 text-decoration-none">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="card-icon" style="background:linear-gradient(135deg,#f59e0b,#ef4444);">
                                        <i class="fa-solid fa-clipboard-check"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-600" style="color:#0f172a;font-size:0.9rem;">PGA & AWaRe</h6>
                                        <p class="mb-0 text-muted" style="font-size:0.78rem;">Program pengendalian antimikroba</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('integrasi.farmasi') }}" class="module-card p-3 text-decoration-none">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="card-icon" style="background:linear-gradient(135deg,#06b6d4,#0891b2);">
                                        <i class="fa-solid fa-prescription-bottle-medical"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-600" style="color:#0f172a;font-size:0.9rem;">Integrasi Farmasi</h6>
                                        <p class="mb-0 text-muted" style="font-size:0.78rem;">Data stok & harga obat</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alerts / Notifications --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                <div class="card-header bg-white border-0 pt-3 px-4">
                    <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
                        <i class="fa-solid fa-bell me-2" style="color:var(--kpra-green);"></i>
                        Notifikasi & Peringatan
                    </h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="d-flex flex-column gap-2">
                        <div class="alert-item danger">
                            <i class="fa-solid fa-triangle-exclamation" style="font-size:1rem;color:#ef4444;"></i>
                            <div>
                                <p class="mb-1 fw-600" style="font-size:0.8rem;color:#991b1b;">Stok Kritis</p>
                                <p class="mb-0" style="font-size:0.75rem;color:#7f1d1d;">Vancomycin tersisa < 100 vial</p>
                            </div>
                        </div>
                        <div class="alert-item warning">
                            <i class="fa-solid fa-circle-exclamation" style="font-size:1rem;color:#f59e0b;"></i>
                            <div>
                                <p class="mb-1 fw-600" style="font-size:0.8rem;color:#713f12;">Pending Review</p>
                                <p class="mb-0" style="font-size:0.75rem;color:#92400e;">18 resep menunggu persetujuan DPJP</p>
                            </div>
                        </div>
                        <div class="alert-item info">
                            <i class="fa-solid fa-circle-info" style="font-size:1rem;color:#06b6d4;"></i>
                            <div>
                                <p class="mb-1 fw-600" style="font-size:0.8rem;color:#1e40af;">Kepatuhan PGA</p>
                                <p class="mb-0" style="font-size:0.75rem;color:#1e3a8a;">Target 80%, realisasi 78% (kurang 2%)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Clinical Pathway Card --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius:14px;">
                <div class="card-header bg-white border-0 pt-3 px-4 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
                        <i class="fa-solid fa-notes-medical me-2" style="color:var(--kpra-cyan);"></i>
                        Clinical Pathway — Pasien Aktif
                    </h6>
                    <a href="{{ route('integrasi.clinical-pathway') }}" class="text-decoration-none" style="font-size:0.8rem;color:var(--kpra-green);">
                        Lihat semua →
                    </a>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-2" style="font-size:0.8rem;">
                        <div class="col-md-4 text-center">
                            <p class="mb-1 text-muted">Pneumonia (CAP)</p>
                            <h5 class="mb-0 fw-700" style="color:var(--kpra-green);">12 pasien</h5>
                        </div>
                        <div class="col-md-4 text-center border-start border-end">
                            <p class="mb-1 text-muted">Sepsis</p>
                            <h5 class="mb-0 fw-700" style="color:#06b6d4;">8 pasien</h5>
                        </div>
                        <div class="col-md-4 text-center">
                            <p class="mb-1 text-muted">ISK / Infeksi Lain</p>
                            <h5 class="mb-0 fw-700" style="color:#f59e0b;">18 pasien</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
