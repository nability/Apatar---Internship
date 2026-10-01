@extends('layouts.kpra')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@push('styles')
<style>
    .welcome-banner {
        background: linear-gradient(135deg, #E7F5EF 0%, #FFFFFF 100%);
        border-radius: 16px;
        padding: 1.75rem 2rem;
        position: relative;
        overflow: hidden;
        border: 1px solid #E7EBE9;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -40%; right: -5%;
        width: 300px; height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(8, 127, 91, 0.08) 0%, transparent 70%);
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -50%; left: 20%;
        width: 250px; height: 250px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(8, 127, 91, 0.05) 0%, transparent 70%);
    }
    .welcome-banner h4 {
        color: #1F2933;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .welcome-banner p {
        color: #7A858F;
        margin-bottom: 0;
        font-size: 0.875rem;
    }
    .module-card {
        border: 1px solid #E7EBE9;
        border-radius: 12px;
        transition: all 0.2s ease;
        cursor: pointer;
        background: #FFFFFF;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    .module-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        border-color: #087F5B;
    }
    .module-card .card-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; 
        background: #E7F5EF;
        color: #087F5B;
    }
    .alert-item {
        display: flex; align-items: flex-start; gap: 0.75rem;
        padding: 0.75rem;
        border-radius: 10px;
        background: #F7F8F7;
        border-left: 3px solid;
        transition: background 0.2s;
    }
    .alert-item:hover { background: #F0F1F0; }
    .alert-item.danger { border-color: #D9534F; }
    .alert-item.warning { border-color: #E6A23C; }
    .alert-item.info { border-color: #4C8DFF; }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    {{-- Welcome Banner --}}
    <div class="welcome-banner mb-4">
        <div class="position-relative" style="z-index:1;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h4 class="fw-700 mb-2">
                        Selamat Datang! 
                    </h4>
                    <p style="color: #7A858F; font-size: 0.875rem;">
                        Apatar — Rumah Sakit Sekarwangi
                        &nbsp;|&nbsp; Periode: <strong style="color:#1F2933;">September 2026</strong>
                    </p>
                </div>
                <a href="{{ route('kuantitatif.index') }}"
                   class="btn btn-sm px-4 py-2"
                   style="background:#087F5B; color:#fff; border-radius:10px; font-size:0.82rem; border:none; font-weight:600;">
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
                icon="fa-solid fa-shield-halved"
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
            <div class="card border-0 h-100" style="border-radius:16px; border:1px solid #E7EBE9; box-shadow:0 4px 20px rgba(0,0,0,0.04);">
                <div class="card-header bg-white border-0 pt-3 px-4">
                    <h6 class="mb-0 fw-600" style="font-size:0.95rem; color:#1F2933;">
                        <i class="fa-solid fa-th me-2" style="color:#087F5B;"></i>
                        Akses Cepat — Modul Utama
                    </h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('kuantitatif.index') }}" class="module-card p-3 text-decoration-none d-block">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="card-icon">
                                        <i class="fa-solid fa-chart-column"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-600" style="color:#1F2933;font-size:0.9rem;">Kuantitatif (DDD)</h6>
                                        <p class="mb-0" style="color:#7A858F; font-size:0.78rem;">Analisis penggunaan antibiotik</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('kualitatif.index') }}" class="module-card p-3 text-decoration-none d-block">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="card-icon">
                                        <i class="fa-solid fa-file-medical"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-600" style="color:#1F2933;font-size:0.9rem;">Kualitatif (Gyssens)</h6>
                                        <p class="mb-0" style="color:#7A858F; font-size:0.78rem;">Evaluasi ketepatan penggunaan</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('pga.index') }}" class="module-card p-3 text-decoration-none d-block">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="card-icon">
                                        <i class="fa-solid fa-clipboard-check"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-600" style="color:#1F2933;font-size:0.9rem;">PGA & AWaRe</h6>
                                        <p class="mb-0" style="color:#7A858F; font-size:0.78rem;">Program pengendalian antimikroba</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('integrasi.farmasi') }}" class="module-card p-3 text-decoration-none d-block">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="card-icon">
                                        <i class="fa-solid fa-prescription-bottle-medical"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-600" style="color:#1F2933;font-size:0.9rem;">Integrasi Farmasi</h6>
                                        <p class="mb-0" style="color:#7A858F; font-size:0.78rem;">Data stok & harga obat</p>
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
            <div class="card border-0 h-100" style="border-radius:16px; border:1px solid #E7EBE9; box-shadow:0 4px 20px rgba(0,0,0,0.04);">
                <div class="card-header bg-white border-0 pt-3 px-4">
                    <h6 class="mb-0 fw-600" style="font-size:0.95rem; color:#1F2933;">
                        <i class="fa-solid fa-bell me-2" style="color:#087F5B;"></i>
                        Notifikasi & Peringatan
                    </h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="d-flex flex-column gap-2">
                        <div class="alert-item danger">
                            <i class="fa-solid fa-triangle-exclamation" style="font-size:1rem;color:#D9534F;"></i>
                            <div>
                                <p class="mb-1 fw-600" style="font-size:0.8rem;color:#991b1b;">Stok Kritis</p>
                                <p class="mb-0" style="font-size:0.75rem;color:#7f1d1d;">Vancomycin tersisa < 100 vial</p>
                            </div>
                        </div>
                        <div class="alert-item warning">
                            <i class="fa-solid fa-circle-exclamation" style="font-size:1rem;color:#E6A23C;"></i>
                            <div>
                                <p class="mb-1 fw-600" style="font-size:0.8rem;color:#713f12;">Pending Review</p>
                                <p class="mb-0" style="font-size:0.75rem;color:#92400e;">18 resep menunggu persetujuan DPJP</p>
                            </div>
                        </div>
                        <div class="alert-item info">
                            <i class="fa-solid fa-circle-info" style="font-size:1rem;color:#4C8DFF;"></i>
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
            <div class="card border-0" style="border-radius:16px; border:1px solid #E7EBE9; box-shadow:0 4px 20px rgba(0,0,0,0.04);">
                <div class="card-header bg-white border-0 pt-3 px-4 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-600" style="font-size:0.95rem; color:#1F2933;">
                        <i class="fa-solid fa-notes-medical me-2" style="color:#06b6d4;"></i>
                        Clinical Pathway — Pasien Aktif
                    </h6>
                    <a href="{{ route('integrasi.clinical-pathway') }}" class="text-decoration-none" style="font-size:0.85rem;color:#087F5B;">
                        Lihat semua →
                    </a>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-2" style="font-size:0.85rem;">
                        <div class="col-md-4 text-center">
                            <p class="mb-1" style="color:#7A858F;">Pneumonia (CAP)</p>
                            <h5 class="mb-0 fw-700" style="color:#087F5B;">12 pasien</h5>
                        </div>
                        <div class="col-md-4 text-center border-start border-end">
                            <p class="mb-1" style="color:#7A858F;">Sepsis</p>
                            <h5 class="mb-0 fw-700" style="color:#06b6d4;">8 pasien</h5>
                        </div>
                        <div class="col-md-4 text-center">
                            <p class="mb-1" style="color:#7A858F;">ISK / Infeksi Lain</p>
                            <h5 class="mb-0 fw-700" style="color:#E6A23C;">18 pasien</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
