@props([
    'icon' => 'box-open',
    'title' => 'Không có dữ liệu',
    'message' => '',
    'actionUrl' => null,
    'actionText' => 'Quay lại',
])
<div {{ $attributes->merge(['class' => 'text-center py-5']) }}>
    <i class="fas fa-{{ $icon }} fa-5x text-muted mb-4"></i>
    <h4 class="mb-3">{{ $title }}</h4>

    @if($message)
        <p class="text-muted mb-4">{{ $message }}</p>
       @endif
    {{ $slot }}

    @if($actionUrl)
        <a href="{{ $actionUrl }}" class="btn btn-primary mt-3">
            {{ $actionText }}
        </a>
    @endif
</div>
