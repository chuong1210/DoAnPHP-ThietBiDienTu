@extends('client.layouts.client')

@section('title', 'Trang Chủ')

@section('content')
    <!-- Banner Slider -->
    @if($banners->count() > 0)
        <div id="bannerCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($banners as $index => $banner)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('images/banners/' . $banner->image) }}" class="d-block w-100" alt="{{ $banner->title }}"
                            style="max-height: 400px; object-fit: cover;">
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    @endif

    <!-- Sản phẩm nổi bật -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><i class="fas fa-fire text-danger"></i> Sản Phẩm Nổi Bật</h3>
            <a href="{{ route('client.product.index') }}" class="btn btn-outline-primary">
                Xem Tất Cả <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="row">
            @foreach($featuredProducts as $product)
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                        @else
                            <div class="card-img-top product-image bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif

                        <div class="card-body">
                            <h6 class="card-title">{{ Str::limit($product->name, 50) }}</h6>
                            <p class="text-muted small mb-2">{{ $product->brand->name }}</p>

                            <div class="mb-2">
                                @if($product->sale_price)
                                    <span class="h5 text-danger mb-0">{{ number_format($product->sale_price) }}đ</span>
                                    <br>
                                    <span class="price-old small">{{ number_format($product->price) }}đ</span>
                                @else
                                    <span class="h5 text-primary mb-0">{{ number_format($product->price) }}đ</span>
                                @endif
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{ route('client.product.show', $product->slug) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Xem Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Sản phẩm mới -->
    <section>
        <h3 class="mb-3"><i class="fas fa-star text-warning"></i> Sản Phẩm Mới</h3>
        <div class="row">
            @foreach($newProducts as $product)
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                        @endif

                        <div class="card-body">
                            <h6 class="card-title">{{ Str::limit($product->name, 50) }}</h6>
                            <div class="mb-2">
                                <span class="h5 text-primary mb-0">{{ number_format($product->final_price) }}đ</span>
                            </div>
                            <a href="{{ route('client.product.show', $product->slug) }}"
                                class="btn btn-outline-primary btn-sm w-100">
                                Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection