{{-- resources/views/client/product/all.blade.php --}}
@extends('client.layouts.client')

@section('title', 'Tất cả sản phẩm')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            {{-- <div class="col-lg-3 col-md-4">
                @include('client.partials.sidebar-category', ['categories' => $categories])
            </div> --}}

            <!-- Main content -->
            <div class="col-lg-9 col-md-8">
                <div class="row">
                    <div class="col-12">
                        <h1 class="mb-4">Tất cả sản phẩm</h1>
                    </div>
                </div>

                <!-- Filter form -->
                <div class="row mb-4">
                    <div class="col-12">
                        <form method="GET" action="{{ route('client.product.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="keyword" class="form-control"
                                        placeholder="Tìm kiếm sản phẩm..." value="{{ request('keyword') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="category_id" class="form-control">
                                        <option value="">Tất cả danh mục</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="brand_id" class="form-control">
                                        <option value="">Tất cả thương hiệu</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="sort" class="form-control">
                                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Mới
                                            nhất</option>
                                        <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Giá tăng dần
                                        </option>
                                        <option value="price" {{ request('sort') == 'price desc' ? 'selected' : '' }}>Giá giảm
                                            dần</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Products grid -->
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card product-card h-100">
                                <img src="{{ asset( $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if($product->sale_price)
                                            <div>
                                                <span
                                                    class="text-danger fw-bold fs-5">{{ number_format($product->sale_price) }}đ</span>
                                                <span
                                                    class="text-muted text-decoration-line-through ms-2">{{ number_format($product->price) }}đ</span>
                                            </div>
                                        @else
                                            <span class="text-primary fw-bold fs-5">{{ number_format($product->price) }}đ</span>
                                        @endif
                                        <a href="{{ route('client.product.show', $product->slug) }}"
                                            class="btn btn-outline-primary">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center">Không có sản phẩm nào.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-12">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
