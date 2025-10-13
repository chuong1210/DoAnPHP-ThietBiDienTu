@extends('client.layouts.client')

@section('title', $category['name'])

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category['name'] }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Categories -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh Mục</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($categories as $parentCategory)
                            <li class="list-group-item">
                                <a href="{{ route('client.category.index', $parentCategory->slug) }}"
                                    class="d-flex justify-content-between align-items-center {{ request()->segment(2) == $parentCategory->slug ? 'fw-bold text-primary' : '' }}">
                                    {{ $parentCategory->name }}
                                    @if($parentCategory->children->count() > 0)
                                        <span
                                            class="badge bg-secondary rounded-pill">{{ $parentCategory->children->count() }}</span>
                                    @endif
                                </a>
                                @if($parentCategory->children->count() > 0)
                                    <ul class="list-unstyled ms-3 mt-1">
                                        @foreach($parentCategory->children as $childCategory)
                                            <li>
                                                <a href="{{ route('client.category.index', $childCategory->slug) }}"
                                                    class="text-muted small {{ request()->segment(2) == $childCategory->slug ? 'text-primary' : '' }}">
                                                    {{ $childCategory->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content: Products -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">{{ $category['name'] }}</h2>
                <small class="text-muted">Có {{ $products->total() }} sản phẩm</small>
            </div>

            @if($products->count() > 0)
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card product-card h-100">
                                @if($product->image)
                                    <img src="{{  asset($product->image) }}" class="card-img-top product-image"
                                        alt="{{ $product->name }}" loading="lazy">
                                @else
                                    <div class="card-img-top product-image bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">{{ Str::limit($product->name, 50) }}</h6>
                                    <p class="text-muted small mb-2">{{ $product->brand->name ?? 'N/A' }}</p>

                                    <div class="mb-auto">
                                        @if($product->sale_price)
                                            <span class="h5 text-danger mb-0">{{ number_format($product->sale_price) }}đ</span>
                                            <br>
                                            <span
                                                class="price-old small text-decoration-line-through">{{ number_format($product->price) }}đ</span>
                                        @else
                                            <span class="h5 text-primary mb-0">{{ number_format($product->price) }}đ</span>
                                        @endif
                                    </div>

                                    <div class="mt-2">
                                        <a href="{{ route('client.product.show', $product->slug) }}"
                                            class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-eye"></i> Xem Chi Tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Chưa có sản phẩm nào trong danh mục này.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Không tìm thấy sản phẩm nào.</p>
                    <a href="{{ route('client.product.index') }}" class="btn btn-outline-primary">Quay lại danh sách sản
                        phẩm</a>
                </div>
            @endif
        </div>
    </div>
@endsection