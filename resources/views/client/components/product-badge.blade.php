@props([
    'type' => 'featured', // featured, discount, new, hot
    'value' => null,
])

@php
    $config = [
        'featured' => ['bg' => 'danger', 'icon' => 'fire', 'text' => 'Nổi bật'],
        'discount' => ['bg' => 'warning', 'icon' => 'percent', 'text' => '-' . $value . '%'],
        'new' => ['bg' => 'info', 'icon' => 'star', 'text' => 'Mới'],
        'hot' => ['bg' => 'danger', 'icon' => 'fire', 'text' => 'Hot'],
    ];

    $badge = $config[$type] ?? $config['featured'];
@endphp

<span {{ $attributes->merge(['class' => 'badge bg-' . $badge['bg']]) }}>
    <i class="fas fa-{{ $badge['icon'] }}"></i> {{ $badge['text'] }}
</span>

<!-- ==========================================
FILE: resources/views/components/rating-stars.blade.php
COMPONENT RATING SAO
========================================== -->
@props([
    'rating' => 0,
    'count' => null,
    'size' => 'normal', // small, normal, large
])

@php
    $sizeClass = match($size) {
        'small' => 'small',
        'large' => 'h5',
        default => '',
    };
@endphp

<div {{ $attributes->merge(['class' => $sizeClass]) }}>
    @for($i = 1; $i <= 5; $i++)
        @if($i <= $rating)
            <i class="fas fa-star text-warning"></i>
        @else
            <i class="far fa-star text-warning"></i>
        @endif
    @endfor

    @if($count !== null)
        <span class="text-muted small ms-1">({{ $count }})</span>
    @endif
</div>
