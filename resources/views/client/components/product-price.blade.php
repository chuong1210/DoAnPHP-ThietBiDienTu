@props([
    'product',
    'size' => 'normal', // normal, large, small
])

@php
    $priceClass = match($size) {
        'large' => 'h2',
        'small' => 'h6',
        default => 'h5',
    };
@endphp

<div {{ $attributes }}>
    @if($product->sale_price)
        <span class="{{ $priceClass }} text-danger mb-0">
            {{ number_format($product->sale_price) }}đ
        </span>
        <br>
        <span class="price-old small">
            {{ number_format($product->price) }}đ
        </span>
    @else
        <span class="{{ $priceClass }} text-primary mb-0">
            {{ number_format($product->price) }}đ
        </span>
    @endif
</div>
