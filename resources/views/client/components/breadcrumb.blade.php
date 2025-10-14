@props(['items' => []])

<nav aria-label="breadcrumb" {{ $attributes->merge(['class' => 'mb-4']) }}>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('client.home.index') }}">
                <i class="fas fa-home"></i> Trang chủ
            </a>
        </li>

        @foreach($items as $item)
            @if($loop->last)
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $item['name'] }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>