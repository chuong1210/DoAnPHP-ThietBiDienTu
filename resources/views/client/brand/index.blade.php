@extends('client.layouts.client')

@section('title', $brand->name)

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">{{ $brand->name }}</li>
        </ol>
    </nav>

    <!-- Brand Header -->
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            @if($brand->logo)
                <img src="{{ asset('images/brands/' . $brand->logo) }}" class="img-fluid mb-2" alt="{{ $brand->name }}"
                    style="max-height: 80px;">
            @endif
            <h2 class="mb-0">{{ $brand->name }}</h2>
            <p class="text-muted">Khám phá các sản phẩm chất lượng từ {{ $brand->name }}</p>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 product-card">
                    <a href="{{ route('client.product.show', $product->slug) }}">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                        @else
                            <div class="bg-light text-center py-5">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">
                            <a href="{{ route('client.product.show', $product->slug) }}" class="text-decoration-none">
                                {{ Str::limit($product->name, 50) }}
                            </a>
                        </h6>
                        <div class="mt-auto">
                            @if($product->sale_price)
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h6 text-danger">{{ number_format($product->sale_price) }}đ</span>
                                    <small
                                        class="text-muted text-decoration-line-through">{{ number_format($product->price) }}đ</small>
                                </div>
                                <small class="text-danger">-{{ $product->discount_percent }}%</small>
                            @else
                                <h6 class="text-primary">{{ number_format($product->price) }}đ</h6>
                            @endif
                        </div>
                        @if($product->quantity > 0)
                            <div class="mt-2">
                                <form action="{{ route('client.cart.add', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-cart-plus"></i> Thêm giỏ
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="mt-2">
                                <span class="badge bg-danger w-100 text-center py-2">Hết hàng</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Chưa có sản phẩm nào cho thương hiệu này.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    @endif
@endsection