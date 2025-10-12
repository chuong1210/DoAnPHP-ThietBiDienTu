@props([
    'type' => 'info', // success, error, warning, info
    'dismissible' => true,
    'icon' => true,
])
@php
    $config = [
        'success' => ['class' => 'alert-success', 'icon' => 'check-circle'],
        'error' => ['class' => 'alert-danger', 'icon' => 'exclamation-circle'],
        'warning' => ['class' => 'alert-warning', 'icon' => 'exclamation-triangle'],
        'info' => ['class' => 'alert-info', 'icon' => 'info-circle'],
    ];

    $alert = $config[$type] ?? $config['info'];
@endphp

<div {{ $attributes->merge(['class' => 'alert ' . $alert['class'] . ($dismissible ? ' alert-dismissible fade show' : '')]) }} role="alert">
    @if($icon)
        <i class="fas fa-{{ $alert['icon'] }} me-2"></i>
    @endif
    {{ $slot }}

    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @endif
</div>
