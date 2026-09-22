@extends('layouts.kpra')

@section('title', 'Integrasi Farmasi')
@section('page-title', 'Integrasi — Farmasi')

@section('breadcrumb')
    <li class="breadcrumb-item">Integrasi</li>
    <li class="breadcrumb-item active">Farmasi</li>
@endsection

@push('styles')
<style>
    .table-kpra thead th {
        background: #f8fafc; font-size: 0.75rem; font-weight: 600;
        color: #64748b; text-transform: uppercase; letter-spacing: 0.04em;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-kpra tbody td { font-size: 0.83rem; vertical-align: middle; }

    /* Autocomplete dropdown */
    .search-result-item {
        padding: 0.6rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }
    .search-result-item:hover { background: #f8fafc; }
    .search-result-item:last-child { border-bottom: none; }
</style>
@endpush

@section('content')
@php
$obatFarmasi = [
    ['kode'=>'FAR-001','nama'=>'Amoxicillin 500mg Kapsul','aware'=>'Access','stok'=>2450,'satuan'=>'Kapsul','harga'=>1200,'kategori'=>'Penicillin'],
    ['kode'=>'FAR-002','nama'=>'Ceftriaxone 1g Inj','aware'=>'Watch','stok'=>380,'satuan'=>'Vial','harga'=>45000,'kategori'=>'Sefalosporin Gen-3'],
    ['kode'=>'FAR-003','nama'=>'Meropenem 1g Inj','aware'=>'Reserve','stok'=>124,'satuan'=>'Vial','harga'=>185000,'kategori'=>'Carbapenem'],
    ['kode'=>'FAR-004','nama'=>'Ciprofloxacin 500mg Tab','aware'=>'Watch','stok'=>1860,'satuan'=>'Tablet','harga'=>3800,'kategori'=>'Fluoroquinolone'],
    ['kode'=>'FAR-005','nama'=>'Metronidazole 500mg Inf','aware'=>'Access','stok'=>540,'satuan'=>'Botol','harga'=>12000,'kategori'=>'Nitroimidazole'],
    ['kode'=>'FAR-006','nama'=>'Vancomycin 500mg Inj','aware'=>'Reserve','stok'=>68,'satuan'=>'Vial','harga'=>320000,'kategori'=>'Glycopeptide'],
    ['kode'=>'FAR-007','nama'=>'Azithromycin 500mg Tab','aware'=>'Watch','stok'=>720,'satuan'=>'Tablet','harga'=>9500,'kategori'=>'Macrolide'],
    ['kode'=>'FAR-008','nama'=>'Ampicillin-Sulbactam 1.5g Inj','aware'=>'Access','stok'=>215,'satuan'=>'Vial','harga'=>38000,'kategori'=>'Penicillin+Inhibitor'],
];
@endphp

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <x-stat-card title="Total Item Antibiotik" value="48" unit="item" icon="fa-solid fa-prescription-bottle-medical" icon-bg="linear-gradient(135deg,#10b981,#06b6d4)" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Stok Kritis (< 100)" value="3" unit="item" icon="fa-solid fa-box-open" icon-bg="linear-gradient(135deg,#ef4444,#dc2626)" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Nilai Stok Reserve" value="Rp 28.4" unit="Juta" icon="fa-solid fa-money-bill-wave" icon-bg="linear-gradient(135deg,#6366f1,#8b5cf6)" />
    </div>
    <div class="col-6 col-xl-3">
        <x-stat-card title="Sinkronisasi Terakhir" value="09:15" unit="WIB" icon="fa-solid fa-rotate" icon-bg="linear-gradient(135deg,#f59e0b,#fbbf24)" description="Hari ini, Sep 2026" />
    </div>
</div>

{{-- Searchable Drug Autocomplete (Alpine.js simulation) --}}
<div class="card border-0 shadow-sm mb-3" style="border-radius:14px;"
     x-data="{
         query: '',
         focused: false,
         selected: null,
         drugs: {{ Js::from($obatFarmasi) }},
         get results() {
             if (this.query.length < 2) return [];
             return this.drugs.filter(d => d.nama.toLowerCase().includes(this.query.toLowerCase())
                                       || d.kategori.toLowerCase().includes(this.query.toLowerCase())).slice(0, 5);
         },
         select(drug) { this.selected = drug; this.query = drug.nama; this.focused = false; },
         clear() { this.selected = null; this.query = ''; }
     }">
    <div class="card-header bg-white border-0 pt-3 px-4">
        <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
            <i class="fa-solid fa-magnifying-glass-plus me-2" style="color:var(--kpra-green);"></i>
            Pencarian Obat Antibiotik (Simulasi API Farmasi)
        </h6>
    </div>
    <div class="card-body px-4 pb-4">
        <div class="row align-items-start g-3">
            <div class="col-md-6">
                <label class="form-label" style="font-size:0.8rem; font-weight:600; color:#374151;">Cari nama obat / kategori</label>
                <div class="position-relative">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius:10px 0 0 10px;">
                            <i class="fa-solid fa-pills text-muted" style="font-size:0.85rem;"></i>
                        </span>
                        <input type="text"
                               class="form-control border-start-0"
                               placeholder="Ketik nama obat (min. 2 karakter)…"
                               x-model="query"
                               @focus="focused = true"
                               @blur="setTimeout(()=>{ focused = false }, 200)"
                               style="border-radius: 0 10px 10px 0; font-size:0.85rem;">
                        <button class="btn btn-outline-secondary btn-sm" x-show="query" @click="clear()"
                                style="border-radius:8px; margin-left:0.5rem; font-size:0.8rem;">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    {{-- Autocomplete Dropdown --}}
                    <div class="position-absolute w-100 bg-white border shadow-sm mt-1"
                         style="border-radius:10px; z-index:200; overflow:hidden;"
                         x-show="focused && results.length > 0"
                         x-transition>
                        <template x-for="d in results" :key="d.kode">
                            <div class="search-result-item" @click="select(d)">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-0 fw-500" style="font-size:0.83rem;" x-text="d.nama"></p>
                                        <p class="mb-0 text-muted" style="font-size:0.7rem;" x-text="d.kode + ' · ' + d.kategori"></p>
                                    </div>
                                    <span class="badge ms-2"
                                          :class="{'badge-access':d.aware==='Access','badge-watch':d.aware==='Watch','badge-reserve':d.aware==='Reserve'}"
                                          style="font-size:0.65rem;" x-text="d.aware"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Selected Drug Detail Card --}}
            <div class="col-md-6" x-show="selected" x-transition>
                <label class="form-label" style="font-size:0.8rem; font-weight:600; color:#374151;">Detail Obat Terpilih</label>
                <div class="p-3" style="background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0;">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="mb-1 fw-600" style="font-size:0.88rem; color:#0f172a;" x-text="selected?.nama"></p>
                            <p class="mb-1 text-muted" style="font-size:0.75rem;">
                                <span x-text="selected?.kode"></span> &nbsp;·&nbsp; <span x-text="selected?.kategori"></span>
                            </p>
                        </div>
                        <span class="badge"
                              :class="{'badge-access':selected?.aware==='Access','badge-watch':selected?.aware==='Watch','badge-reserve':selected?.aware==='Reserve'}"
                              style="font-size:0.7rem;" x-text="selected?.aware"></span>
                    </div>
                    <div class="row g-2 mt-1">
                        <div class="col-6">
                            <p class="mb-0 text-muted" style="font-size:0.7rem;">Stok</p>
                            <p class="mb-0 fw-600" style="font-size:0.85rem; color:#0f172a;">
                                <span x-text="selected?.stok.toLocaleString('id-ID')"></span>
                                <span class="text-muted fw-400" style="font-size:0.75rem;" x-text="' ' + selected?.satuan"></span>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="mb-0 text-muted" style="font-size:0.7rem;">Harga Satuan</p>
                            <p class="mb-0 fw-600" style="font-size:0.85rem; color:#0f172a;"
                               x-text="'Rp ' + selected?.harga.toLocaleString('id-ID')"></p>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-kpra btn-sm px-3" style="border-radius:8px; font-size:0.78rem;">
                            <i class="fa-solid fa-circle-plus me-1"></i>Tambahkan ke Audit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Drug Stock Table --}}
<div class="card border-0 shadow-sm" style="border-radius:14px;">
    <div class="card-header bg-white border-0 pt-3 px-4 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-600" style="font-size:0.9rem;">
            <i class="fa-solid fa-warehouse me-2" style="color:var(--kpra-cyan);"></i>
            Daftar Stok Antibiotik (Mock Farmasi)
        </h6>
        <button class="btn btn-sm btn-outline-secondary" style="border-radius:8px; font-size:0.78rem;">
            <i class="fa-solid fa-rotate me-1"></i>Sinkronisasi
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-kpra table-hover mb-0">
                <thead>
                    <tr>
                        <th class="px-4 py-3">Kode</th>
                        <th>Nama Obat</th>
                        <th>Kategori</th>
                        <th>AWaRe</th>
                        <th class="text-end">Stok</th>
                        <th>Satuan</th>
                        <th class="text-end">Harga</th>
                        <th>Status Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($obatFarmasi as $obat)
                    <tr>
                        <td class="px-4 py-3 text-muted" style="font-size:0.72rem;">{{ $obat['kode'] }}</td>
                        <td class="fw-500">{{ $obat['nama'] }}</td>
                        <td class="text-muted">{{ $obat['kategori'] }}</td>
                        <td>
                            @if($obat['aware'] === 'Access')
                                <span class="badge badge-access">Access</span>
                            @elseif($obat['aware'] === 'Watch')
                                <span class="badge badge-watch">Watch</span>
                            @else
                                <span class="badge badge-reserve">Reserve</span>
                            @endif
                        </td>
                        <td class="text-end fw-600">{{ number_format($obat['stok']) }}</td>
                        <td class="text-muted">{{ $obat['satuan'] }}</td>
                        <td class="text-end">Rp {{ number_format($obat['harga']) }}</td>
                        <td>
                            @if($obat['stok'] < 100)
                                <span class="badge" style="background:#fee2e2;color:#991b1b;font-size:0.7rem;">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i>Kritis
                                </span>
                            @elseif($obat['stok'] < 300)
                                <span class="badge" style="background:#fef9c3;color:#713f12;font-size:0.7rem;">
                                    <i class="fa-solid fa-circle-exclamation me-1"></i>Rendah
                                </span>
                            @else
                                <span class="badge" style="background:#d1fae5;color:#065f46;font-size:0.7rem;">
                                    <i class="fa-solid fa-circle-check me-1"></i>Aman
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

@endsection
