@extends('client.layouts.client')

@section('title', 'Tất cả sản phẩm')

@section('content')
    <div class="container py-5">
        <div class="row g-5">
            <!-- Sidebar (nếu cần sau này) -->
            <div class="col-lg-3 d-none d-lg-block">
                <!-- Sidebar sẽ thêm sau nếu cần -->
            </div>

            <!-- Main Content -->
            <div class="col-lg-12">
                <!-- Page Title -->
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-cubes me-3 text-primary" style="font-size: 2rem;"></i>
                    <h1 class="fw-bold text-gradient mb-0">Tất cả sản phẩm</h1>
                </div>

                <!-- Filter Bar -->
                <div class="filter-bar bg-white rounded-4 shadow-sm p-4 mb-5 border border-neutral">
                    <form method="GET" action="{{ route('client.product.index') }}" class="row g-3 align-items-end">
                        <!-- Search -->
                        <div class="col-md-3 col-12">
                            <label class="form-label fw-semibold text-text small">
                                <i class="fas fa-search me-1 text-secondary"></i> Tìm kiếm
                            </label>
                            <input type="text" name="keyword" class="form-control modern-input"
                                placeholder="Tên sản phẩm..." value="{{ request('keyword') }}">
                        </div>

                        <!-- Category -->
                        <div class="col-md-2 col-6">
                            <label class="form-label fw-semibold text-text small">
                                <i class="fas fa-layer-group me-1 text-secondary"></i> Danh mục
                            </label>
                            <select name="category_id" class="form-select modern-select">
                                <option value="">Tất cả</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brand -->
                        <div class="col-md-2 col-6">
                            <label class="form-label fw-semibold text-text small">
                                <i class="fas fa-tag me-1 text-secondary"></i> Thương hiệu
                            </label>
                            <select name="brand_id" class="form-select modern-select">
                                <option value="">Tất cả</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="col-md-2 col-6">
                            <label class="form-label fw-semibold text-text small">
                                <i class="fas fa-sort me-1 text-secondary"></i> Sắp xếp
                            </label>
                            <select name="sort" class="form-select modern-select">
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Mới nhất
                                </option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Giá tăng dần</option>
                                <option value="price desc" {{ request('sort') == 'price desc' ? 'selected' : '' }}>Giá giảm
                                    dần</option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <div class="col-md-3 col-12">
                            <button type="submit" class="btn btn-primary w-100 btn-modern">
                                <i class="fas fa-filter me-1"></i> Lọc sản phẩm
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Products Grid -->
                <div class="row g-4">
                    @forelse($products as $product)
                        <div class="col-lg-3 col-md-4 col-6">
                            <div
                                class="product-card-modern h-100 position-relative overflow-hidden rounded-4 shadow-sm hover-lift">
                                <!-- Sale Badge -->
                                @if($product->sale_price)
                                    <div class="position-absolute top-0 start-0 m-3 z-3">
                                        <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold">
                                            -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                        </span>
                                    </div>
                                @endif

                                <!-- Image -->
                                <div class="position-relative overflow-hidden rounded-4">
                                    <img src="{{ asset($product->image) }}" class="card-img-top product-img"
                                        alt="{{ $product->name }}"
                                        style="height: 220px; object-fit: cover; transition: transform .4s ease;">
                                    <div class="overlay"></div>
                                </div>

                                <!-- Body -->
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-bold text-text mb-2 line-clamp-2">
                                        {{ $product->name }}
                                    </h5>
                                    <p class="card-text text-muted small line-clamp-2 mb-3">
                                        {{ Str::limit($product->description, 80) }}
                                    </p>

                                    <!-- Price -->
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        @if($product->sale_price)
                                            <div>
                                                <span class="h5 fw-bold text-danger mb-0">
                                                    {{ number_format($product->sale_price) }}đ
                                                </span>
                                                <del class="text-muted small ms-2">
                                                    {{ number_format($product->price) }}đ
                                                </del>
                                            </div>
                                        @else
                                            <span class="h5 fw-bold text-primary mb-0">
                                                {{ number_format($product->price) }}đ
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Action -->
                                    <a href="{{ route('client.product.show', $product->slug) }}"
                                        class="btn btn-outline-primary w-100 btn-sm rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-2">
                                        <i class="fas fa-eye"></i>
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-box-open fa-3x text-neutral mb-3"></i>
                            <p class="text-muted">Không tìm thấy sản phẩm nào.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- CSS ĐẶC BIỆT CHO TRANG NÀY --}}
@push('styles')
    <style>
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --bg: #F8FAFC;
            --text: #1E293B;
            --neutral: #CBD5E1;
            --danger: #EF4444;
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .filter-bar {
            background: white;
            border: 1.5px solid var(--neutral);
        }

        .modern-input,
        .modern-select {
            border: 1.5px solid var(--neutral);
            border-radius: 12px;
            padding: 0.65rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .modern-input:focus,
        .modern-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1);
            outline: none;
        }

        .btn-modern {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 12px;
            padding: 0.7rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
        }

        .product-card-modern {
            background: white;
            border: 1.5px solid var(--neutral);
            transition: all 0.4s ease;
            cursor: pointer;
        }

        .product-card-modern:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .product-card-modern:hover .product-img {
            transform: scale(1.08);
        }

        .product-img {
            transition: transform 0.4s ease;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.05));
            pointer-events: none;
        }

        .hover-lift {
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Pagination */
        .pagination .page-link {
            border: none;
            color: var(--text);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            margin: 0 4px;
            font-weight: 500;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
        }

        .pagination .page-link:hover {
            background: var(--bg);
            color: var(--primary);
        }
    </style>
@endpush