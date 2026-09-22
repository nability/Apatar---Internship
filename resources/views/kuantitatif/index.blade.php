@extends('layouts.kpra')

@section('title', 'Kuantitatif DDD')
@section('page-title', 'Analisis Kuantitatif (DDD)')

@section('breadcrumb')
    <li class="breadcrumb-item active">Kuantitatif</li>
@endsection

@push('styles')
<style>
    .chart-placeholder {
        height: 280px;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 12px;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        border: 2px dashed #e2e8f0;
        color: #94a3b8;
    }
    .chart-placeholder i { font-size: 2.5rem; margin-bottom: 0.5rem; }
    .table-kpra thead th {
        background: #f8fafc;
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-kpra tbody td { font-size: 0.83rem; vertical-align: middle; }
    .ddd-bar {
        height: 6px;
        border-radius: 3px;
        background: linear-gradient(90deg, #10b981, #06b6d4);
    }
</style>
@endpush

@section('content')
@php
$dddData = [
    ['antibiotik' => 'Amoxicillin', 'kelas' => 'Penicillin', 'aware' => 'Access', 'jan' => 210, 'feb' => 198, 'mar' => 225, 'unit' => 'DDD/100HH'],
    ['antibiotik' => 'Ceftriaxone', 'kelas' => 'Sefalosporin Gen-3', 'aware' => 'Watch', 'jan' => 165, 'feb' => 182, 'mar' => 194, 'unit' => 'DDD/100HH'],
    ['antibiotik' => 'Ciprofloxacin', 'kelas' => 'Fluoroquinolone', 'aware' => 'Watch', 'jan' => 98, 'feb' => 105, 'mar' => 112, 'unit' => 'DDD/100HH'],
    ['antibiotik' => 'Meropenem', 'kelas' => 'Carbapenem', 'aware' => 'Reserve', 'jan' => 42, 'feb' => 51, 'mar' => 67, 'unit' => 'DDD/100HH'],
    ['antibiotik' => 'Metronidazole', 'kelas' => 'Nitroimidazole', 'aware' => 'Access', 'jan' => 88, 'feb' => 79, 'mar' => 83, 'unit' => 'DDD/100HH'],
    ['antibiotik' => 'Vancomycin', 'kelas' => 'Glycopeptide', 'aware' => 'Reserve', 'jan' => 28, 'feb' => 33, 'mar' => 30, 'unit' => 'DDD/100HH'],
    ['antibiotik' => 'Azithromycin', 'kelas' => 'Macrolide', 'aware' => 'Watch', 'jan' => 54, 'feb' => 48, 'mar' => 61, 'unit' => 'DDD/100HH'],
];
@endphp

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <x-stat-card title="Total DDD (Mar)" value="772" unit="DDD/100HH" icon="fa-solid fa-chart-column" icon-bg="linear-gradient(135deg,#10b981,#06b6d4)" trend="+8.3%" :trend-up="false" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Access" value="308" unit="DDD" icon="fa-solid fa-shield-check" icon-bg="linear-gradient(135deg,#10b981,#34d399)" trend="+5%" :trend-up="true" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Watch" value="367" unit="DDD" icon="fa-solid fa-eye" icon-bg="linear-gradient(135deg,#f59e0b,#fbbf24)" trend="+12%" :trend-up="false" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Reserve" value="97" unit="DDD" icon="fa-solid fa-triangle-exclamation" icon-bg="linear-gradient(135deg,#ef4444,#dc2626)" trend="+28%" :trend-up="false" />
    </div>
</div>

<div class="row g-3">
    {{-- Chart placeholder --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-header bg-white border-0 pt-3 px-4 d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
                    <i class="fa-solid fa-chart-bar me-2" style="color:var(--kpra-green);"></i>
                    Tren DDD per Bulan (Jan – Mar 2026)
                </h6>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="font-size:0.78rem; width:auto; border-radius:8px;">
                        <option>Semua Antibiotik</option>
                        <option>Access saja</option>
                        <option>Watch saja</option>
                        <option>Reserve saja</option>
                    </select>
                </div>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="chart-placeholder">
                    <i class="fa-solid fa-chart-bar" style="color: var(--kpra-green);"></i>
                    <p class="mb-1 fw-500" style="font-size:0.88rem; color:#475569;">Chart akan dirender di sini</p>
                    <p class="mb-0" style="font-size:0.75rem;">Integrasikan Chart.js atau ApexCharts</p>
                </div>
            </div>
        </div>
    </div>

    {{-- AWaRe Distribution --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-header bg-white border-0 pt-3 px-4">
                <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
                    <i class="fa-solid fa-chart-pie me-2" style="color:var(--kpra-cyan);"></i>
                    Distribusi AWaRe (Mar 2026)
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="chart-placeholder mb-3" style="height:180px;">
                    <i class="fa-solid fa-chart-pie" style="color: var(--kpra-cyan);"></i>
                    <p class="mb-0" style="font-size:0.75rem;">Donut Chart AWaRe</p>
                </div>
                <div class="d-flex flex-column gap-2">
                    @foreach([['Access','#10b981','39.9%'],['Watch','#f59e0b','47.5%'],['Reserve','#ef4444','12.6%']] as $w)
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:10px;height:10px;border-radius:3px;background:{{$w[1]}};flex-shrink:0;"></div>
                            <span style="font-size:0.78rem;color:#475569;">{{$w[0]}}</span>
                        </div>
                        <span style="font-size:0.78rem; font-weight:600; color:#0f172a;">{{$w[2]}}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- DDD Table --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-header bg-white border-0 pt-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
                    <i class="fa-solid fa-table me-2" style="color:var(--kpra-green);"></i>
                    Tabel DDD per Antibiotik
                </h6>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Cari antibiotik…"
                           style="width:200px; border-radius:8px; font-size:0.8rem;">
                    <button class="btn btn-kpra btn-sm px-3" style="border-radius:8px; font-size:0.78rem;">
                        <i class="fa-solid fa-download me-1"></i>Export
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-kpra table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="px-4 py-3">Antibiotik</th>
                                <th>Kelas</th>
                                <th>AWaRe</th>
                                <th class="text-end">Jan 2026</th>
                                <th class="text-end">Feb 2026</th>
                                <th class="text-end">Mar 2026</th>
                                <th>Tren</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dddData as $row)
                            <tr>
                                <td class="px-4 py-3 fw-500">{{ $row['antibiotik'] }}</td>
                                <td class="text-muted">{{ $row['kelas'] }}</td>
                                <td>
                                    @if($row['aware'] === 'Access')
                                        <span class="badge badge-access">Access</span>
                                    @elseif($row['aware'] === 'Watch')
                                        <span class="badge badge-watch">Watch</span>
                                    @else
                                        <span class="badge badge-reserve">Reserve</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ $row['jan'] }}</td>
                                <td class="text-end">{{ $row['feb'] }}</td>
                                <td class="text-end fw-600">{{ $row['mar'] }}</td>
                                <td style="min-width:100px;">
                                    @php $pct = min(($row['mar'] / 250) * 100, 100); @endphp
                                    <div style="background:#e2e8f0; height:6px; border-radius:3px;">
                                        <div class="ddd-bar" style="width:{{ $pct }}%;"></div>
                                    </div>
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
