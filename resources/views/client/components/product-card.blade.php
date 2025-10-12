@props([
    'product',
    'showAddToCart' => true,
    'cardClass' => '',
])

<div class="card product-card h-100 {{ $cardClass }}">
    <!-- Badges -->
    @if($product->is_featured)
        <x-product-badge type="featured" class="position-absolute top-0 start-0 m-2" />
    @endif

    @if($product->sale_price)
        <x-product-badge
            type="discount"
            :value="$product->discount_percent"
            class="position-absolute top-0 end-0 m-2"
        />
    @endif

    <!-- Image -->
    <a href="{{ route('client.product.show', $product->slug) }}">
        @if($product->image)
            <img src="{{ asset('images/products/' . $product->image) }}"
                 class="card-img-top product-image"
                 alt="{{ $product->name }}"
                 loading="lazy">
        @else
            <div class="card-img-top product-image bg-light d-flex align-items-center justify-content-center">
                <i class="fas fa-image fa-3x text-muted"></i>
            </div>
        @endif
    </a>

    <div class="card-body d-flex flex-column">
        <!-- Brand -->
        <p class="text-muted small mb-2">
            <i class="fas fa-tag"></i>
            <a href="{{ route('client.brand.index', $product->brand->slug) }}"
               class="text-decoration-none text-muted">
                {{ $product->brand->name }}
            </a>
        </p>

        <!-- Name -->
        <h6 class="card-title mb-2">
            <a href="{{ route('client.product.show', $product->slug) }}"
               class="text-decoration-none text-dark">
                {{ Str::limit($product->name, 60) }}
            </a>
        </h6>

        <!-- Rating -->
        <x-rating-stars
            :rating="$product->average_rating"
            :count="$product->reviews->count()"
            class="mb-2"
        />

        <!-- Price -->
        <x-product-price :product="$product" class="mb-3" />

        <!-- Stock -->
        <div class="mb-3">
            @if($product->quantity > 0)
                <span class="badge bg-success">
                    <i class="fas fa-check"></i> Còn hàng
                </span>
            @else
                <span class="badge bg-danger">
                    <i class="fas fa-times"></i> Hết hàng
                </span>
            @endif
        </div>

        <!-- Actions -->
        <div class="mt-auto d-grid gap-2">
            <a href="{{ route('client.product.show', $product->slug) }}"
               class="btn btn-outline-primary btn-sm">
                <i class="fas fa-eye"></i> Xem Chi Tiết
            </a>

            @if($showAddToCart && $product->quantity > 0)
                <form action="{{ route('client.cart.add', $product->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-cart-plus"></i> Thêm Vào Giỏ
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
