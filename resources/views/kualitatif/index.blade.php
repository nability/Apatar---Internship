@extends('layouts.kpra')

@section('title', 'Kualitatif Gyssens')
@section('page-title', 'Analisis Kualitatif (Gyssens)')

@section('breadcrumb')
    <li class="breadcrumb-item active">Kualitatif</li>
@endsection

@push('styles')
<style>
    .gyssens-badge {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.25rem 0.65rem;
        border-radius: 20px;
        font-size: 0.72rem; font-weight: 600;
    }
    .gyssens-0 { background: #d1fae5; color: #065f46; }  /* Tepat */
    .gyssens-I { background: #dbeafe; color: #1e40af; }
    .gyssens-II { background: #fef9c3; color: #713f12; }
    .gyssens-III { background: #ffedd5; color: #9a3412; }
    .gyssens-IV { background: #fee2e2; color: #991b1b; }  /* Tidak Tepat */
    .gyssens-V { background: #f3e8ff; color: #6b21a8; }  /* Tidak Bisa Dievaluasi */
    .table-kpra thead th {
        background: #f8fafc; font-size: 0.75rem; font-weight: 600;
        color: #64748b; text-transform: uppercase; letter-spacing: 0.04em;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-kpra tbody td { font-size: 0.83rem; vertical-align: middle; }

    /* Gyssens flow diagram */
    .gyssens-step {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.65rem 0.85rem;
        font-size: 0.78rem;
        background: #fff;
        position: relative;
    }
    .gyssens-step.step-ok { border-color: #10b981; background: #f0fdf4; }
    .gyssens-step.step-warn { border-color: #f59e0b; background: #fffbeb; }
    .gyssens-step.step-bad { border-color: #ef4444; background: #fef2f2; }
</style>
@endpush

@section('content')
@php
$pasienList = [
    ['no_rm'=>'RM-2024-00891', 'nama'=>'Budi Santoso', 'usia'=>'52 Th', 'ruang'=>'Bedah A', 'antibiotik'=>'Ceftriaxone 2g', 'diagnosa'=>'Post-op Laparotomi', 'gyssens'=>'IIa', 'keterangan'=>'Dosis berlebih'],
    ['no_rm'=>'RM-2024-00876', 'nama'=>'Siti Rahayu', 'usia'=>'34 Th', 'ruang'=>'Interne B', 'antibiotik'=>'Meropenem 1g', 'diagnosa'=>'Sepsis E.coli', 'gyssens'=>'0', 'keterangan'=>'Tepat'],
    ['no_rm'=>'RM-2024-00903', 'nama'=>'Ahmad Fauzi', 'usia'=>'67 Th', 'ruang'=>'ICU', 'antibiotik'=>'Vancomycin 500mg', 'diagnosa'=>'MRSA Bacteremia', 'gyssens'=>'0', 'keterangan'=>'Tepat'],
    ['no_rm'=>'RM-2024-00845', 'nama'=>'Dewi Kartika', 'usia'=>'28 Th', 'ruang'=>'Obsgyn', 'antibiotik'=>'Amoxicillin 500mg', 'diagnosa'=>'ISK Kehamilan', 'gyssens'=>'IVa', 'keterangan'=>'Ada antibiotik lebih efektif'],
    ['no_rm'=>'RM-2024-00921', 'nama'=>'Eko Prasetyo', 'usia'=>'45 Th', 'ruang'=>'Paru', 'antibiotik'=>'Ciprofloxacin 500mg', 'diagnosa'=>'TB Paru (suspect)', 'gyssens'=>'V', 'keterangan'=>'Tidak bisa dievaluasi'],
    ['no_rm'=>'RM-2024-00934', 'nama'=>'Farida Hanum', 'usia'=>'60 Th', 'ruang'=>'Jantung', 'antibiotik'=>'Azithromycin 500mg', 'diagnosa'=>'CAP Ringan', 'gyssens'=>'IIb', 'keterangan'=>'Rute pemberian tidak tepat'],
];
@endphp

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <x-stat-card title="Total Pasien" value="147" unit="pasien" icon="fa-solid fa-users" icon-bg="linear-gradient(135deg,#10b981,#06b6d4)" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Gyssens 0 (Tepat)" value="89" unit="%" icon="fa-solid fa-circle-check" icon-bg="linear-gradient(135deg,#10b981,#34d399)" trend="+4%" :trend-up="true" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Tidak Tepat (II-IV)" value="43" unit="pasien" icon="fa-solid fa-circle-xmark" icon-bg="linear-gradient(135deg,#f59e0b,#ef4444)" trend="-3" :trend-up="true" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Pending Review" value="12" unit="pasien" icon="fa-solid fa-hourglass-half" icon-bg="linear-gradient(135deg,#6366f1,#8b5cf6)" />
    </div>
</div>

<div class="row g-3">

    {{-- Pasien Table with Alpine filter --}}
    <div class="col-12" x-data="{
        search: '',
        filterGyssens: 'all',
        patients: {{ Js::from($pasienList) }},
        get filtered() {
            return this.patients.filter(p => {
                const matchSearch = p.nama.toLowerCase().includes(this.search.toLowerCase())
                    || p.no_rm.toLowerCase().includes(this.search.toLowerCase());
                const matchGyssens = this.filterGyssens === 'all' || p.gyssens === this.filterGyssens;
                return matchSearch && matchGyssens;
            });
        }
    }">
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-header bg-white border-0 pt-3 px-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
                        <i class="fa-solid fa-file-medical me-2" style="color:var(--kpra-green);"></i>
                        Daftar Evaluasi Gyssens
                    </h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <input type="text" x-model="search"
                               class="form-control form-control-sm"
                               placeholder="Cari nama / no. RM…"
                               style="width:200px; border-radius:8px; font-size:0.8rem;">
                        <select x-model="filterGyssens"
                                class="form-select form-select-sm"
                                style="width:160px; border-radius:8px; font-size:0.8rem;">
                            <option value="all">Semua Gyssens</option>
                            <option value="0">0 — Tepat</option>
                            <option value="IIa">IIa — Dosis</option>
                            <option value="IIb">IIb — Rute</option>
                            <option value="IVa">IVa — Lebih Efektif</option>
                            <option value="V">V — Tidak Evaluasi</option>
                        </select>
                        <a href="#" class="btn btn-kpra btn-sm px-3" style="border-radius:8px; font-size:0.78rem;">
                            <i class="fa-solid fa-plus me-1"></i>Tambah Evaluasi
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-kpra table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="px-4 py-3">No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Usia</th>
                                <th>Ruang</th>
                                <th>Antibiotik</th>
                                <th>Diagnosis</th>
                                <th>Gyssens</th>
                                <th>Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="p in filtered" :key="p.no_rm">
                                <tr>
                                    <td class="px-4 py-3 text-muted" style="font-size:0.75rem;" x-text="p.no_rm"></td>
                                    <td class="fw-500" x-text="p.nama"></td>
                                    <td x-text="p.usia"></td>
                                    <td x-text="p.ruang"></td>
                                    <td x-text="p.antibiotik"></td>
                                    <td x-text="p.diagnosa"></td>
                                    <td>
                                        <span class="gyssens-badge" :class="'gyssens-' + p.gyssens" x-text="p.gyssens"></span>
                                    </td>
                                    <td class="text-muted" style="font-size:0.78rem;" x-text="p.keterangan"></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-secondary" style="border-radius:7px; font-size:0.72rem; padding:0.2rem 0.6rem;">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <template x-if="filtered.length === 0">
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted" style="font-size:0.85rem;">
                                        <i class="fa-solid fa-search me-2"></i>Tidak ada data yang sesuai filter.
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Gyssens Classification Guide --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-header bg-white border-0 pt-3 px-4">
                <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
                    <i class="fa-solid fa-sitemap me-2" style="color:var(--kpra-cyan);"></i>
                    Panduan Klasifikasi Gyssens
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-2">
                    @foreach([
                        ['0',    'Tepat (Appropriate)',          'Penggunaan antibiotik sudah tepat dari semua aspek.', 'step-ok'],
                        ['I',    'Data Tidak Lengkap',           'Data rekam medis tidak cukup untuk evaluasi lengkap.', ''],
                        ['IIa',  'Dosis Tidak Tepat',            'Dosis yang diberikan tidak sesuai panduan.', 'step-warn'],
                        ['IIb',  'Interval/Rute Tidak Tepat',    'Rute pemberian atau interval dosis tidak sesuai.', 'step-warn'],
                        ['IIIa', 'Terlalu Lama',                 'Durasi terapi melebihi panduan.', 'step-warn'],
                        ['IIIb', 'Terlalu Singkat',              'Durasi terapi kurang dari yang direkomendasikan.', 'step-warn'],
                        ['IVa',  'Ada Antibiotik Lebih Efektif', 'Tersedia pilihan antibiotik dengan efektivitas lebih tinggi.', 'step-bad'],
                        ['IVb',  'Spektrum Terlalu Luas',        'Antibiotik yang dipilih memiliki spektrum lebih luas dari yang dibutuhkan.', 'step-bad'],
                        ['IVc',  'Antibiotik Lebih Murah',       'Tersedia pilihan yang lebih cost-effective.', 'step-bad'],
                        ['IVd',  'Toksisitas Lebih Rendah',      'Tersedia pilihan dengan profil toksisitas lebih rendah.', 'step-bad'],
                        ['V',    'Tidak Bisa Dievaluasi',        'Tidak ada indikasi yang jelas untuk antibiotik ini.', 'step-bad'],
                        ['VI',   'Profilaksis Tidak Perlu',      'Pemberian profilaksis tidak sesuai indikasi.', 'step-bad'],
                    ] as $g)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="gyssens-step {{ $g[3] }}">
                            <span class="fw-700" style="font-size:0.88rem;">Kategori {{ $g[0] }}</span>
                            <p class="mb-0 fw-500" style="font-size:0.75rem; color:#374151;">{{ $g[1] }}</p>
                            <p class="mb-0 text-muted" style="font-size:0.68rem;">{{ $g[2] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
