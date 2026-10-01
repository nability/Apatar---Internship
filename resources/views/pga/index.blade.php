@extends('layouts.kpra')

@section('title', 'PGA & AWaRe')
@section('page-title', 'Program Pengendalian Antimikroba (PGA)')

@section('breadcrumb')
    <li class="breadcrumb-item active">PGA & AWaRe</li>
@endsection

@push('styles')
<style>
    .table-kpra thead th {
        background: #F7F8F7; font-size: 0.75rem; font-weight: 600;
        color: #7A858F; text-transform: uppercase; letter-spacing: 0.04em;
        border-bottom: 1px solid #E7EBE9;
        padding: 0.75rem 1rem;
    }
    .table-kpra tbody td { font-size: 0.85rem; vertical-align: middle; padding: 0.75rem 1rem; }
    .table-kpra tbody tr:hover { background: #F7F8F7; }
    .table-kpra tbody tr { border-bottom: 1px solid #F7F8F7; }

    .audit-card { border-radius: 16px; border: 1px solid #E7EBE9; transition: all 0.2s; }
    .audit-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.05); transform: translateY(-2px); }

    .aware-Access  { background:#E8F6EF; color:#065F46; border: 1px solid #A7F3D0; }
    .aware-Watch   { background:#FFF5DD; color:#9A6A00; border: 1px solid #FDE68A; }
    .aware-Reserve { background:#FDECEC; color:#B83A3A; border: 1px solid #FCA5A5; }

    .status-badge-approved  { background:#E8F6EF; color:#065F46; border-radius: 999px; padding: 0.25rem 0.6rem; font-size: 0.7rem; }
    .status-badge-pending   { background:#FFF5DD; color:#9A6A00; border-radius: 999px; padding: 0.25rem 0.6rem; font-size: 0.7rem; }
    .status-badge-rejected  { background:#FDECEC; color:#B83A3A; border-radius: 999px; padding: 0.25rem 0.6rem; font-size: 0.7rem; }
    .status-badge-review    { background:#EAF2FF; color:#1e40af; border-radius: 999px; padding: 0.25rem 0.6rem; font-size: 0.7rem; }

    .progress-bar-access  { background: linear-gradient(90deg,#087F5B,#34d399); }
    .progress-bar-watch   { background: linear-gradient(90deg,#E6A23C,#fbbf24); }
    .progress-bar-reserve { background: linear-gradient(90deg,#D9534F,#f87171); }
</style>
@endpush

@section('content')
@php
$auditData = [
    ['id'=>'AUD-001','no_rm'=>'RM-2024-00891','nama'=>'Budi Santoso','ruang'=>'Bedah A','antibiotik'=>'Ceftriaxone','aware'=>'Watch','dosis'=>'2g IV','indikasi'=>'Profilaksis Pre-op','status'=>'Approved','reviewer'=>'dr. Ratna'],
    ['id'=>'AUD-002','no_rm'=>'RM-2024-00876','nama'=>'Siti Rahayu','ruang'=>'Interne B','antibiotik'=>'Meropenem','aware'=>'Reserve','dosis'=>'1g IV q8h','indikasi'=>'Sepsis gram-negatif','status'=>'Pending','reviewer'=>'-'],
    ['id'=>'AUD-003','no_rm'=>'RM-2024-00903','nama'=>'Ahmad Fauzi','ruang'=>'ICU','antibiotik'=>'Vancomycin','aware'=>'Reserve','dosis'=>'1g IV q12h','indikasi'=>'MRSA','status'=>'Approved','reviewer'=>'dr. Ratna'],
    ['id'=>'AUD-004','no_rm'=>'RM-2024-00845','nama'=>'Dewi Kartika','ruang'=>'Obsgyn','antibiotik'=>'Amoxicillin','aware'=>'Access','dosis'=>'500mg PO TID','indikasi'=>'ISK Kehamilan','status'=>'Approved','reviewer'=>'dr. Sari'],
    ['id'=>'AUD-005','no_rm'=>'RM-2024-00921','nama'=>'Eko Prasetyo','ruang'=>'Paru','antibiotik'=>'Ciprofloxacin','aware'=>'Watch','dosis'=>'500mg PO BID','indikasi'=>'CAP Berat','status'=>'Review','reviewer'=>'Menunggu DPJP'],
    ['id'=>'AUD-006','no_rm'=>'RM-2024-00934','nama'=>'Farida Hanum','ruang'=>'Jantung','antibiotik'=>'Azithromycin','aware'=>'Watch','dosis'=>'500mg PO OD','indikasi'=>'Atypical Pneumonia','status'=>'Rejected','reviewer'=>'dr. Ratna'],
    ['id'=>'AUD-007','no_rm'=>'RM-2024-00956','nama'=>'Gunawan Lim','ruang'=>'Anak','antibiotik'=>'Amoxicillin-Clav','aware'=>'Access','dosis'=>'375mg PO TID','indikasi'=>'ISPA Bakteri','status'=>'Approved','reviewer'=>'dr. Sari'],
];
@endphp

{{-- KPI Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <x-stat-card title="Total Audit" value="247" unit="resep" icon="fa-solid fa-clipboard-check" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Reserve Disetujui" value="23" unit="resep" icon="fa-solid fa-triangle-exclamation" trend="-3" :trend-up="true" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Pending Review" value="18" unit="resep" icon="fa-solid fa-hourglass-half" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Kepatuhan PPAB" value="82" unit="%" icon="fa-solid fa-shield-halved" trend="+2%" :trend-up="true" />
    </div>
</div>

<div class="row g-3">

    {{-- AWaRe Distribution Cards --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-header bg-white border-0 pt-3 px-4">
                <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
                    <i class="fa-solid fa-layer-group me-2" style="color:var(--kpra-green);"></i>
                    Distribusi AWaRe — Resep Aktif (Sep 2026)
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    @foreach([
                        ['Access',  '#10b981', '39.9%', 98,  'fa-solid fa-shield-halved',  'Antibiotik first-line, tersedia luas, aman untuk sebagian besar infeksi umum.'],
                        ['Watch',   '#f59e0b', '47.5%', 117, 'fa-solid fa-eye',            'Antibiotik second-line, risiko resistensi lebih tinggi, perlu indikasi kuat.'],
                        ['Reserve', '#ef4444', '12.6%', 31,  'fa-solid fa-skull-crossbones','Antibiotik lini terakhir, hanya untuk kasus MDR, persetujuan khusus wajib.'],
                    ] as $a)
                    <div class="col-md-4">
                        <div class="audit-card p-3" style="background:#fff;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div style="width:36px;height:36px; border-radius:10px;
                                            background: {{ $a[1] }}20;
                                            display:flex;align-items:center;justify-content:center;
                                            color: {{ $a[1] }}; font-size:1rem;">
                                    <i class="{{ $a[4] }}"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-700" style="font-size:0.92rem; color:#0f172a;">AWaRe: {{ $a[0] }}</h6>
                                    <span class="badge aware-{{ $a[0] }}" style="font-size:0.65rem;">{{ $a[2] }} dari total resep</span>
                                </div>
                                <span class="ms-auto fw-700" style="font-size:1.4rem; color: {{ $a[1] }};">{{ $a[3] }}</span>
                            </div>
                            <div class="progress mb-2" style="height:6px; border-radius:3px;">
                                <div class="progress-bar progress-bar-{{ strtolower($a[0]) }}"
                                     style="width: {{ $a[2] }};"></div>
                            </div>
                            <p class="mb-0 text-muted" style="font-size:0.72rem;">{{ $a[5] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Audit Table with Alpine filter --}}
    <div class="col-12"
         x-data="{
             filterAware: 'all',
             filterStatus: 'all',
             search: '',
             audits: {{ Js::from($auditData) }},
             get filtered() {
                 return this.audits.filter(a => {
                     const matchAware  = this.filterAware  === 'all' || a.aware   === this.filterAware;
                     const matchStatus = this.filterStatus === 'all' || a.status  === this.filterStatus;
                     const matchSearch = a.nama.toLowerCase().includes(this.search.toLowerCase())
                                      || a.antibiotik.toLowerCase().includes(this.search.toLowerCase());
                     return matchAware && matchStatus && matchSearch;
                 });
             }
         }">
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-header bg-white border-0 pt-3 px-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
                        <i class="fa-solid fa-list-check me-2" style="color:var(--kpra-green);"></i>
                        Log Audit Resep Antibiotik
                    </h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <input type="text" x-model="search" placeholder="Cari nama / antibiotik…"
                               class="form-control form-control-sm"
                               style="width:190px; border-radius:8px; font-size:0.8rem;">
                        <select x-model="filterAware" class="form-select form-select-sm"
                                style="width:140px; border-radius:8px; font-size:0.8rem;">
                            <option value="all">Semua AWaRe</option>
                            <option value="Access">Access</option>
                            <option value="Watch">Watch</option>
                            <option value="Reserve">Reserve</option>
                        </select>
                        <select x-model="filterStatus" class="form-select form-select-sm"
                                style="width:150px; border-radius:8px; font-size:0.8rem;">
                            <option value="all">Semua Status</option>
                            <option value="Approved">Approved</option>
                            <option value="Pending">Pending</option>
                            <option value="Review">Review</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                        <button class="btn btn-kpra btn-sm px-3" style="border-radius:8px; font-size:0.78rem;">
                            <i class="fa-solid fa-plus me-1"></i>Audit Baru
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-kpra table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="px-4 py-3">ID Audit</th>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Ruang</th>
                                <th>Antibiotik</th>
                                <th>AWaRe</th>
                                <th>Dosis</th>
                                <th>Indikasi</th>
                                <th>Status</th>
                                <th>Reviewer</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="a in filtered" :key="a.id">
                                <tr>
                                    <td class="px-4 py-3 text-muted" style="font-size:0.72rem;" x-text="a.id"></td>
                                    <td class="text-muted" style="font-size:0.72rem;" x-text="a.no_rm"></td>
                                    <td class="fw-500" x-text="a.nama"></td>
                                    <td x-text="a.ruang"></td>
                                    <td class="fw-500" x-text="a.antibiotik"></td>
                                    <td>
                                        <span class="badge px-2 py-1" :class="'aware-' + a.aware" x-text="a.aware" style="font-size:0.7rem;"></span>
                                    </td>
                                    <td class="text-muted" x-text="a.dosis"></td>
                                    <td class="text-muted" style="font-size:0.78rem;" x-text="a.indikasi"></td>
                                    <td>
                                        <span class="badge px-2 py-1"
                                              :class="{
                                                'status-badge-approved': a.status === 'Approved',
                                                'status-badge-pending':  a.status === 'Pending',
                                                'status-badge-review':   a.status === 'Review',
                                                'status-badge-rejected': a.status === 'Rejected',
                                              }"
                                              style="font-size:0.7rem;"
                                              x-text="a.status"></span>
                                    </td>
                                    <td class="text-muted" style="font-size:0.78rem;" x-text="a.reviewer"></td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <button class="btn btn-sm btn-outline-secondary" style="border-radius:7px; font-size:0.72rem; padding:0.2rem 0.5rem;" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" style="border-radius:7px; font-size:0.72rem; padding:0.2rem 0.5rem;" title="Approve">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template x-if="filtered.length === 0">
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted" style="font-size:0.85rem;">
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

</div>
@endsection
