@props([
    'title'      => 'Stat',
    'value'      => '0',
    'unit'        => '',
    'icon'        => 'fa-solid fa-circle',
    'iconBg'      => 'linear-gradient(135deg, #10b981, #06b6d4)',
    'trend'       => null,
    'trendUp'     => true,
    'description' => '',
])

<div class="card border-0 h-100" style="border-radius: 16px; border: 1px solid #E7EBE9; background: #FFFFFF; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); overflow: hidden;">
    <div class="card-body p-4">
        <div class="d-flex align-items-start justify-content-between">
            <div>
                <p class="mb-2" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #7A858F;">
                    {{ $title }}
                </p>
                <h3 class="mb-0 fw-700" style="font-size: 1.8rem; color: #1F2933;">
                    {{ $value }}
                    @if($unit)
                        <span style="font-size: 0.9rem; font-weight: 500; color: #7A858F;">{{ $unit }}</span>
                    @endif
                </h3>
                @if($description)
                    <p class="mb-0 mt-2" style="font-size: 0.8rem; color: #7A858F;">{{ $description }}</p>
                @endif
            </div>
            <div class="stat-icon ms-3"
                 style="width: 56px; height: 56px; border-radius: 12px;
                        background: #E7F5EF;
                        display: flex; align-items: center; justify-content: center;
                        flex-shrink: 0; font-size: 1.3rem; color: #087F5B;">
                <i class="{{ $icon }}"></i>
            </div>
        </div>

        @if($trend)
        <div class="mt-3 pt-3 d-flex align-items-center gap-2" style="border-top: 1px solid #E7EBE9;">
            <span class="{{ $trendUp ? 'text-success' : 'text-danger' }}" style="font-size: 0.8rem; font-weight: 700;">
                <i class="fa-solid {{ $trendUp ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                {{ $trend }}
            </span>
            <span style="font-size: 0.75rem; color: #7A858F;">vs bulan lalu</span>
        </div>
        @endif
    </div>
</div>
