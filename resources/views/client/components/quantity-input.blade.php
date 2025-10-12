@props([
    'name' => 'quantity',
    'value' => 1,
    'min' => 1,
    'max' => 999,
])

<div {{ $attributes->merge(['class' => 'input-group']) }}>
    <button type="button"
            class="btn btn-outline-secondary"
            onclick="decreaseQuantity('{{ $name }}')">
        <i class="fas fa-minus"></i>
    </button>

    <input type="number"
           name="{{ $name }}"
           id="{{ $name }}"
           class="form-control text-center"
           value="{{ $value }}"
           min="{{ $min }}"
           max="{{ $max }}">

    <button type="button"
            class="btn btn-outline-secondary"
            onclick="increaseQuantity('{{ $name }}', {{ $max }})">
        <i class="fas fa-plus"></i>
    </button>
</div>

@once
@push('scripts')
<script>
function increaseQuantity(inputId, max) {
    const input = document.getElementById(inputId);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decreaseQuantity(inputId) {
    const input = document.getElementById(inputId);
    const current = parseInt(input.value);
    const min = parseInt(input.min);
    if (current > min) {
        input.value = current - 1;
    }
}
</script>
@endpush
@endonce
