@extends('client.layouts.client')

@section('title', 'Tất cả sản phẩm')

@section('content')
    <style>
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --background: #F8FAFC;
            --text: #1E293B;
            --neutral: #CBD5E1;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
        }

        /* Page Header */
        .page-header-products {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 2px solid var(--neutral);
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .header-icon-wrapper {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(0, 102, 255, 0.3);
        }

        .header-icon-wrapper i {
            font-size: 2rem;
            color: white;
        }

        .page-header-products h1 {
            color: var(--text);
            font-weight: 800;
            margin: 0;
            font-size: 2rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Filter Bar */
        .filter-bar {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 2px solid var(--neutral);
        }

        .filter-bar .form-label {
            color: var(--text);
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-bar .form-label i {
            color: var(--primary);
        }

        .modern-input,
        .modern-select {
            border: 2px solid var(--neutral);
            border-radius: 12px;
            padding: 0.85rem 1.25rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
            color: var(--text);
        }

        .modern-input:focus,
        .modern-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1);
            outline: none;
        }

        .modern-input::placeholder {
            color: #94A3B8;
        }

        .btn-filter {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 102, 255, 0.3);
            color: white;
            width: 100%;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 102, 255, 0.4);
            color: white;
        }

        /* Product Card */
        .product-card-modern {
            background: white;
            border-radius: 20px;
            border: 2px solid var(--neutral);
            overflow: hidden;
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card-modern:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 50px rgba(0, 102, 255, 0.15);
            border-color: var(--primary);
        }

        /* Sale Badge */
        .sale-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 10;
            background: linear-gradient(135deg, var(--danger), #DC2626);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.85rem;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        /* Product Image */
        .product-image-wrapper {
            position: relative;
            height: 280px;
            overflow: hidden;
            background: var(--background);
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card-modern:hover .product-img {
            transform: scale(1.1);
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.05));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card-modern:hover .image-overlay {
            opacity: 1;
        }

        /* Product Body */
        .product-body {
            padding: 1.75rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-brand {
            color: #64748B;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .product-title {
            color: var(--text);
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 42px;
        }

        .product-description {
            color: #64748B;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5;
        }

        /* Product Price */
        .product-price-wrapper {
            margin-bottom: 1.25rem;
            margin-top: auto;
        }

        .price-current {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 800;
        }

        .price-sale {
            color: var(--danger);
            font-size: 1.5rem;
            font-weight: 800;
        }

        .price-old {
            color: #94A3B8;
            font-size: 1rem;
            text-decoration: line-through;
            margin-left: 0.5rem;
        }

        /* Product Button */
        .btn-view-detail {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-view-detail:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            background: white;
            border-radius: 24px;
            border: 2px solid var(--neutral);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .empty-state i {
            font-size: 6rem;
            color: var(--neutral);
            margin-bottom: 2rem;
            opacity: 0.5;
        }

        .empty-state h4 {
            color: var(--text);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #64748B;
            margin-bottom: 2rem;
        }

        /* Pagination */
        .pagination {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .pagination .page-link {
            border: 2px solid var(--neutral);
            color: var(--text);
            padding: 0.65rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            background: white;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
        }

        .pagination .page-link:hover {
            background: var(--background);
            color: var(--primary);
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .pagination .page-item.disabled .page-link {
            background: var(--background);
            border-color: var(--neutral);
            color: #94A3B8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header-products {
                padding: 1.5rem;
            }

            .page-header-products h1 {
                font-size: 1.5rem;
            }

            .filter-bar {
                padding: 1.5rem;
            }

            .product-image-wrapper {
                height: 220px;
            }

            .product-body {
                padding: 1.25rem;
            }

            .price-current,
            .price-sale {
                font-size: 1.25rem;
            }
        }
    </style>

    <div class="container py-4">
        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-12">
                <!-- Page Header -->
                <div class="page-header-products">
                    <div class="header-icon-wrapper">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <div>
                        <h1>Tất Cả Sản Phẩm</h1>
                        <p class="text-muted mb-0">Khám phá bộ sưu tập sản phẩm công nghệ của chúng tôi</p>
                    </div>
                </div>

                <!-- Filter Bar -->
                <div class="filter-bar">
                    <form method="GET" action="{{ route('client.product.index') }}" class="row g-3 align-items-end">
                        <!-- Search -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">
                                <i class="fas fa-search"></i> Tìm kiếm
                            </label>
                            <input type="text" name="keyword" class="form-control modern-input"
                                placeholder="Nhập tên sản phẩm..." value="{{ request('keyword') }}">
                        </div>

                        <!-- Category -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">
                                <i class="fas fa-layer-group"></i> Danh mục
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
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">
                                <i class="fas fa-tag"></i> Thương hiệu
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
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">
                                <i class="fas fa-sort-amount-down"></i> Sắp xếp
                            </label>
                            <select name="sort" class="form-select modern-select">
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Giá tăng dần</option>
                                <option value="price desc" {{ request('sort') == 'price desc' ? 'selected' : '' }}>Giá giảm dần</option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-3 col-md-12">
                            <button type="submit" class="btn btn-filter">
                                <i class="fas fa-filter me-2"></i> Lọc Sản Phẩm
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Products Grid -->
                <div class="row g-4">
                    @forelse($products as $index => $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6" style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="product-card-modern">
                                <!-- Sale Badge -->
                                @if($product->sale_price)
                                    <div class="sale-badge">
                                        -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                    </div>
                                @endif

                                <!-- Product Image -->
                                <div class="product-image-wrapper">
                                    @if($product->image)
                                        <img src="{{ asset($product->image) }}" class="product-img" alt="{{ $product->name }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="image-overlay"></div>
                                </div>

                                <!-- Product Body -->
                                <div class="product-body">
                                    @if($product->brand)
                                        <div class="product-brand">{{ $product->brand->name }}</div>
                                    @endif

                                    <h5 class="product-title">{{ $product->name }}</h5>

                                    @if($product->description)
                                        <p class="product-description">{{ $product->description }}</p>
                                    @endif

                                    <!-- Price -->
                                    <div class="product-price-wrapper">
                                        @if($product->sale_price)
                                            <div>
                                                <span class="price-sale">{{ number_format($product->sale_price) }}đ</span>
                                                <span class="price-old">{{ number_format($product->price) }}đ</span>
                                            </div>
                                        @else
                                            <span class="price-current">{{ number_format($product->price) }}đ</span>
                                        @endif
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('client.product.show', $product->slug) }}" class="btn-view-detail">
                                        <i class="fas fa-eye"></i> Xem Chi Tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <h4>Không Tìm Thấy Sản Phẩm</h4>
                                <p class="text-muted">Không có sản phẩm nào phù hợp với tiêu chí tìm kiếm của bạn</p>
                                <a href="{{ route('client.product.index') }}" class="btn btn-filter" style="width: auto; display: inline-flex;">
                                    <i class="fas fa-redo me-2"></i> Xem Tất Cả Sản Phẩm
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
