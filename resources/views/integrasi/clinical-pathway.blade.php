@extends('layouts.kpra')

@section('title', 'Clinical Pathway')
@section('page-title', 'Integrasi — Clinical Pathway (CP)')

@section('breadcrumb')
    <li class="breadcrumb-item">Integrasi</li>
    <li class="breadcrumb-item active">Clinical Pathway</li>
@endsection

@push('styles')
<style>
    .table-kpra thead th {
        background: #f8fafc; font-size: 0.75rem; font-weight: 600;
        color: #64748b; text-transform: uppercase; letter-spacing: 0.04em;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-kpra tbody td { font-size: 0.83rem; vertical-align: middle; }

    .cp-card {
        border: 1px solid #e2e8f0; border-radius:12px;
        padding: 1rem; background: #fff;
        transition: all 0.2s;
    }
    .cp-card:hover { box-shadow: 0 6px 16px rgba(0,0,0,0.07); transform: translateY(-2px); }

    .timeline-line {
        position: relative;
        padding-left: 1.5rem;
    }
    .timeline-line::before {
        content: '';
        position: absolute; left: 0.4rem; top: 0; bottom: 0;
        width: 2px; background: #e2e8f0;
    }
    .timeline-dot {
        position: absolute; left: 0;
        width: 14px; height: 14px;
        border-radius: 50%;
        border: 2px solid #fff;
        top: 0.2rem;
    }
</style>
@endpush

@section('content')
@php
$cpList = [
    ['kode'=>'CP-001','nama'=>'Pneumonia Komuniti (CAP) Dewasa','departemen'=>'Paru','antibiotic_cp'=>'Amoxicillin 500mg PO + Azithromycin 500mg','aware'=>'Access + Watch','durasi'=>'7 hari','status'=>'Aktif'],
    ['kode'=>'CP-002','nama'=>'Sepsis dengan Sumber Tidak Diketahui','departemen'=>'ICU','antibiotic_cp'=>'Meropenem 1g IV q8h + Vancomycin','aware'=>'Reserve','durasi'=>'10-14 hari','status'=>'Aktif'],
    ['kode'=>'CP-003','nama'=>'ISK (Infeksi Saluran Kemih) Sederhana','departemen'=>'Interne','antibiotic_cp'=>'Ciprofloxacin 500mg PO BID','aware'=>'Watch','durasi'=>'3-5 hari','status'=>'Aktif'],
    ['kode'=>'CP-004','nama'=>'Post-Operasi Laparotomi','departemen'=>'Bedah','antibiotic_cp'=>'Ceftriaxone 2g IV (profilaksis)','aware'=>'Watch','durasi'=>'24 jam (profilaksis)','status'=>'Aktif'],
    ['kode'=>'CP-005','nama'=>'Endokarditis Infektif','departemen'=>'Jantung','antibiotic_cp'=>'Ampicillin + Gentamicin IV','aware'=>'Access','durasi'=>'4-6 minggu','status'=>'Review'],
    ['kode'=>'CP-006','nama'=>'Infeksi Kulit & Jaringan Lunak','departemen'=>'Bedah','antibiotic_cp'=>'Cloxacillin 1g IV q6h','aware'=>'Access','durasi'=>'5-7 hari','status'=>'Aktif'],
];

$pasienCP = [
    ['no_rm'=>'RM-2024-00891','nama'=>'Budi Santoso','cp'=>'Post-Operasi Laparotomi','hari_ke'=>3,'total_hari'=>1,'status_cp'=>'Selesai','varian'=>'Ya'],
    ['no_rm'=>'RM-2024-00876','nama'=>'Siti Rahayu','cp'=>'Sepsis dengan Sumber Tidak Diketahui','hari_ke'=>5,'total_hari'=>14,'status_cp'=>'Berjalan','varian'=>'Tidak'],
    ['no_rm'=>'RM-2024-00903','nama'=>'Ahmad Fauzi','cp'=>'Sepsis dengan Sumber Tidak Diketahui','hari_ke'=>8,'total_hari'=>14,'status_cp'=>'Berjalan','varian'=>'Ya'],
    ['no_rm'=>'RM-2024-00845','nama'=>'Dewi Kartika','cp'=>'ISK Sederhana','hari_ke'=>3,'total_hari'=>5,'status_cp'=>'Berjalan','varian'=>'Tidak'],
    ['no_rm'=>'RM-2024-00921','nama'=>'Eko Prasetyo','cp'=>'Pneumonia Komuniti (CAP) Dewasa','hari_ke'=>7,'total_hari'=>7,'status_cp'=>'Selesai','varian'=>'Tidak'],
];
@endphp

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <x-stat-card title="Total CP Aktif" value="6" unit="pathway" icon="fa-solid fa-notes-medical" icon-bg="linear-gradient(135deg,#10b981,#06b6d4)" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Pasien On CP" value="38" unit="pasien" icon="fa-solid fa-user-injured" icon-bg="linear-gradient(135deg,#6366f1,#8b5cf6)" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Varian CP" value="9" unit="kasus" icon="fa-solid fa-code-branch" icon-bg="linear-gradient(135deg,#f59e0b,#ef4444)" description="Deviasi dari standar CP" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Kepatuhan CP" value="76" unit="%" icon="fa-solid fa-chart-line" icon-bg="linear-gradient(135deg,#10b981,#34d399)" trend="+3%" :trend-up="true" />
    </div>
</div>

<div class="row g-3">

    {{-- CP Library --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
            <div class="card-header bg-white border-0 pt-3 px-4">
                <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
                    <i class="fa-solid fa-book-medical me-2" style="color:var(--kpra-green);"></i>
                    Direktori Clinical Pathway
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="d-flex flex-column gap-2">
                    @foreach($cpList as $cp)
                    <div class="cp-card">
                        <div class="d-flex align-items-start justify-content-between gap-2">
                            <div style="flex:1;">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="text-muted" style="font-size:0.68rem;">{{ $cp['kode'] }}</span>
                                    @if($cp['status'] === 'Review')
                                        <span class="badge" style="background:#fef9c3;color:#713f12;font-size:0.62rem;">Review</span>
                                    @endif
                                </div>
                                <p class="mb-1 fw-600" style="font-size:0.82rem; color:#0f172a;">{{ $cp['nama'] }}</p>
                                <p class="mb-1 text-muted" style="font-size:0.72rem;">
                                    <i class="fa-solid fa-building-columns me-1"></i>{{ $cp['departemen'] }}
                                    &nbsp;·&nbsp; <i class="fa-regular fa-clock me-1"></i>{{ $cp['durasi'] }}
                                </p>
                                <p class="mb-0 text-muted" style="font-size:0.7rem;">
                                    <i class="fa-solid fa-pills me-1"></i>{{ $cp['antibiotic_cp'] }}
                                </p>
                            </div>
                            <span class="badge flex-shrink-0
                                @if(str_contains($cp['aware'], 'Reserve')) badge-reserve
                                @elseif(str_contains($cp['aware'], 'Watch')) badge-watch
                                @else badge-access @endif"
                                style="font-size:0.65rem; white-space:nowrap;">
                                {{ str_contains($cp['aware'], '+') ? 'Mix' : $cp['aware'] }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Pasien on CP --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
            <div class="card-header bg-white border-0 pt-3 px-4 d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
                    <i class="fa-solid fa-table me-2" style="color:var(--kpra-cyan);"></i>
                    Pasien Dalam Clinical Pathway
                </h6>
                <button class="btn btn-kpra btn-sm px-3" style="border-radius:8px; font-size:0.78rem;">
                    <i class="fa-solid fa-link me-1"></i>Sinkronisasi CP
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-kpra table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="px-4 py-3">No. RM</th>
                                <th>Nama</th>
                                <th>Clinical Pathway</th>
                                <th class="text-center">Progress</th>
                                <th>Status CP</th>
                                <th class="text-center">Varian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pasienCP as $p)
                            <tr>
                                <td class="px-4 py-3 text-muted" style="font-size:0.72rem;">{{ $p['no_rm'] }}</td>
                                <td class="fw-500">{{ $p['nama'] }}</td>
                                <td class="text-muted" style="font-size:0.78rem;">{{ $p['cp'] }}</td>
                                <td>
                                    @php $pct = min(($p['hari_ke'] / $p['total_hari']) * 100, 100); @endphp
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="flex:1; background:#e2e8f0; height:6px; border-radius:3px;">
                                            <div style="width:{{$pct}}%; height:6px; border-radius:3px; background: linear-gradient(90deg,#10b981,#06b6d4);"></div>
                                        </div>
                                        <span style="font-size:0.7rem; color:#64748b; white-space:nowrap;">H{{ $p['hari_ke'] }}/{{ $p['total_hari'] }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($p['status_cp'] === 'Selesai')
                                        <span class="badge" style="background:#d1fae5;color:#065f46;font-size:0.7rem;">Selesai</span>
                                    @else
                                        <span class="badge" style="background:#dbeafe;color:#1e40af;font-size:0.7rem;">Berjalan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($p['varian'] === 'Ya')
                                        <span class="badge" style="background:#fee2e2;color:#991b1b;font-size:0.7rem;">
                                            <i class="fa-solid fa-triangle-exclamation me-1"></i>Ada
                                        </span>
                                    @else
                                        <span class="badge" style="background:#d1fae5;color:#065f46;font-size:0.7rem;">
                                            <i class="fa-solid fa-check me-1"></i>Tidak
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
