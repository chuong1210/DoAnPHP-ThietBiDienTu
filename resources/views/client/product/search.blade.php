@extends('client.layouts.client')

@section('title', 'Tìm kiếm: ' . $keyword)

@section('content')
    <div class="mb-4">
        <h3>
            <i class="fas fa-search"></i> Kết quả tìm kiếm cho:
            <span class="text-primary">"{{ $keyword }}"</span>
        </h3>
        <p class="text-muted">Tìm thấy {{ $products->total() }} sản phẩm</p>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card product-card h-100">
                        <a href="{{ route('client.product.show', $product->slug) }}">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                            @else
                                <div class="card-img-top product-image bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                        </a>

                        <div class="card-body d-flex flex-column">
                            <p class="text-muted small mb-2">{{ $product->brand->name }}</p>
                            <h6 class="card-title">
                                <a href="{{ route('client.product.show', $product->slug) }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($product->name, 60) }}
                                </a>
                            </h6>

                            <div class="mb-2">
                                @if($product->sale_price)
                                    <span class="h5 text-danger mb-0">{{ number_format($product->sale_price) }}đ</span>
                                    <br>
                                    <span class="price-old small">{{ number_format($product->price) }}đ</span>
                                @else
                                    <span class="h5 text-primary mb-0">{{ number_format($product->price) }}đ</span>
                                @endif
                            </div>

                            <div class="mt-auto">
                                <a href="{{ route('client.product.show', $product->slug) }}"
                                    class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-eye"></i> Xem Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->appends(['q' => $keyword])->links() }}
        </div>

    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-search fa-5x text-muted mb-4"></i>
                <h4>Không tìm thấy sản phẩm nào</h4>
                <p class="text-muted">Vui lòng thử lại với từ khóa khác</p>

                <div class="mt-4">
                    <h5>Gợi ý tìm kiếm:</h5>
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <a href="{{ route('client.search', ['q' => 'iPhone']) }}" class="badge bg-light text-dark">iPhone</a>
                        <a href="{{ route('client.search', ['q' => 'Samsung']) }}" class="badge bg-light text-dark">Samsung</a>
                        <a href="{{ route('client.search', ['q' => 'Laptop']) }}" class="badge bg-light text-dark">Laptop</a>
                        <a href="{{ route('client.search', ['q' => 'Tai nghe']) }}" class="badge bg-light text-dark">Tai
                            nghe</a>
                    </div>
                </div>

                <a href="{{ route('client.product.index') }}" class="btn btn-primary mt-4">
                    <i class="fas fa-shopping-bag"></i> Xem Tất Cả Sản Phẩm
                </a>
            </div>
        </div>
    @endif
@endsection