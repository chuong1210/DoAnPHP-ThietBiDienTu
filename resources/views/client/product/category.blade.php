@extends('client.layouts.client')

@section('title', $category['name'])

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">{{ $category['name'] }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>
            <i class="fas fa-list"></i> {{ $category['name'] }}
            <small class="text-muted">({{ $products->total() }} sản phẩm)</small>
        </h3>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    <a href="{{ route('client.product.show', $product->slug) }}">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                        @endif
                    </a>

                    <div class="card-body d-flex flex-column">
                        <p class="text-muted small mb-2">{{ $product->brand->name }}</p>
                        <h6 class="card-title">{{ Str::limit($product->name, 60) }}</h6>

                        <div class="mb-3">
                            @if($product->sale_price)
                                <span class="h5 text-danger mb-0">{{ number_format($product->sale_price) }}đ</span>
                                <br>
                                <span class="price-old small">{{ number_format($product->price) }}đ</span>
                            @else
                                <span class="h5 text-primary mb-0">{{ number_format($product->price) }}đ</span>
                            @endif
                        </div>

                        <div class="mt-auto d-grid gap-2">
                            <a href="{{ route('client.product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm">
                                Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <p class="mb-0">Danh mục này chưa có sản phẩm</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
@endsection