@props([
    'title'      => 'Stat',
    'value'      => '0',
    'unit'        => '',
    'icon'        => 'fa-solid fa-circle',
    'iconBg'      => 'linear-gradient(135deg, #10b981, #06b6d4)',
    'trend'       => null,   {{-- e.g. '+12%' --}}
    'trendUp'     => true,
    'description' => '',
])

<div class="card border-0 shadow-sm h-100" style="border-radius: 14px; overflow: hidden;">
    <div class="card-body p-3">
        <div class="d-flex align-items-start justify-content-between">
            <div>
                <p class="mb-1 text-muted" style="font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em;">
                    {{ $title }}
                </p>
                <h3 class="mb-0 fw-700" style="font-size: 1.6rem; color: #0f172a;">
                    {{ $value }}
                    @if($unit)
                        <span class="text-muted" style="font-size: 0.85rem; font-weight: 400;">{{ $unit }}</span>
                    @endif
                </h3>
                @if($description)
                    <p class="mb-0 mt-1 text-muted" style="font-size: 0.72rem;">{{ $description }}</p>
                @endif
            </div>
            <div class="stat-icon ms-3"
                 style="width: 48px; height: 48px; border-radius: 12px;
                        background: {{ $iconBg }};
                        display: flex; align-items: center; justify-content: center;
                        flex-shrink: 0; font-size: 1.2rem; color: #fff;">
                <i class="{{ $icon }}"></i>
            </div>
        </div>

        @if($trend)
        <div class="mt-2 pt-2 border-top d-flex align-items-center gap-1">
            <span class="{{ $trendUp ? 'text-success' : 'text-danger' }}" style="font-size: 0.75rem; font-weight: 600;">
                <i class="fa-solid {{ $trendUp ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                {{ $trend }}
            </span>
            <span class="text-muted" style="font-size: 0.72rem;">vs bulan lalu</span>
        </div>
        @endif
    </div>
</div>
