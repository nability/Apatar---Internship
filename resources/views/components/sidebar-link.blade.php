@props([
    'href'       => '#',
    'icon'       => 'fa-solid fa-circle',
    'label'      => 'Link',
    'active'     => false,
    'badge'      => null,
    'badgeClass' => 'bg-secondary',
])

<a href="{{ $href }}"
   class="sidebar-link {{ $active ? 'active' : '' }}">
    <span class="nav-icon">
        <i class="{{ $icon }}"></i>
    </span>
    <span>{{ $label }}</span>
    @if($badge)
        <span class="nav-badge badge {{ $badgeClass }}">{{ $badge }}</span>
    @endif
</a>
