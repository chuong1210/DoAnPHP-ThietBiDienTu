@extends('client.layouts.client')

@section('title', $category['name'])

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb modern-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}"><i class="fas fa-home"></i> Trang Chủ</a></li>
            <li class="breadcrumb-item active">{{ $category['name'] }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Sidebar Categories -->
        <div class="col-lg-3">
            <div class="sidebar-sticky">
                <div class="categories-sidebar">
                    <div class="sidebar-header">
                        <i class="fas fa-layer-group"></i>
                        <span>Danh Mục</span>
                    </div>
                    <div class="categories-list">
                        @foreach($categories as $parentCategory)
                            <div class="category-item {{ request()->segment(2) == $parentCategory->slug ? 'active' : '' }}">
                                <a href="{{ route('client.product.category.index', $parentCategory->slug) }}" class="category-link">
                                    <span class="category-name">{{ $parentCategory->name }}</span>
                                    @if($parentCategory->children->count() > 0)
                                        <span class="category-count">{{ $parentCategory->children->count() }}</span>
                                    @endif
                                </a>
                                @if($parentCategory->children->count() > 0)
                                    <div class="subcategories {{ request()->segment(2) == $parentCategory->slug ? 'show' : '' }}">
                                        @foreach($parentCategory->children as $childCategory)
                                            <a href="{{ route('client.product.category.index', $childCategory->slug) }}"
                                                class="subcategory-link {{ request()->segment(2) == $childCategory->slug ? 'active' : '' }}">
                                                <i class="fas fa-angle-right"></i>
                                                {{ $childCategory->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Filter Banner -->
                <div class="filter-banner">
                    <div class="banner-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <h6>Ưu Đãi Đặc Biệt</h6>
                    <p>Giảm giá lên đến 50% cho danh mục này</p>
                    <a href="{{ route('client.product.index') }}" class="banner-link">
                        Xem Ngay <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content: Products -->
        <div class="col-lg-9">
            <!-- Category Header -->
            <div class="category-header">
                <div class="header-content">
                    <div class="icon-wrapper">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div>
                        <h2 class="mb-1">{{ $category['name'] }}</h2>
                        <p class="text-muted mb-0">{{ $products->total() }} sản phẩm</p>
                    </div>
                </div>
                <div class="header-actions">
                    <select class="form-select" onchange="window.location.href=this.value">
                        <option value="">Sắp xếp</option>
                        <option value="?sort=created_at&order=DESC">Mới nhất</option>
                        <option value="?sort=price&order=ASC">Giá: Thấp → Cao</option>
                        <option value="?sort=price&order=DESC">Giá: Cao → Thấp</option>
                        <option value="?sort=name&order=ASC">Tên: A → Z</option>
                    </select>
                </div>
            </div>

            @if($products->count() > 0)
                <!-- Products Grid -->
                <div class="products-grid">
                    @foreach($products as $index => $product)
                        <div class="product-card-wrapper" style="animation-delay: {{ $index * 0.05 }}s">
                            <div class="product-card">
                                <!-- Badges -->
                                @if($product->sale_price)
                                    <div class="product-badge">
                                        -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                    </div>
                                @endif

                                <!-- Image -->
                                <a href="{{ route('client.product.show', $product->slug) }}" class="product-image-link">
                                    <div class="product-image-wrapper">
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}" class="product-image" alt="{{ $product->name }}">
                                        @else
                                            <div class="image-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                        <div class="image-overlay">
                                            <i class="fas fa-eye"></i>
                                        </div>
                                    </div>
                                </a>

                                <!-- Content -->
                                <div class="product-content">
                                    <div class="product-brand">
                                        <i class="fas fa-tag"></i> {{ $product->brand->name ?? 'N/A' }}
                                    </div>

                                    <h6 class="product-name">
                                        <a href="{{ route('client.product.show', $product->slug) }}">
                                            {{ Str::limit($product->name, 50) }}
                                        </a>
                                    </h6>

                                    <div class="product-price">
                                        @if($product->sale_price)
                                            <span class="price-current sale">{{ number_format($product->sale_price) }}đ</span>
                                            <span class="price-old">{{ number_format($product->price) }}đ</span>
                                        @else
                                            <span class="price-current">{{ number_format($product->price) }}đ</span>
                                        @endif
                                    </div>

                                    <a href="{{ route('client.product.show', $product->slug) }}" class="btn-view-detail">
                                        <i class="fas fa-eye me-2"></i> Xem Chi Tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="pagination-wrapper">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3>Chưa Có Sản Phẩm</h3>
                    <p>Danh mục này chưa có sản phẩm nào</p>
                    <a href="{{ route('client.product.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left me-2"></i> Quay Lại Danh Sách
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

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

    /* Breadcrumb */
    .modern-breadcrumb {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        border: 2px solid var(--neutral);
    }

    .modern-breadcrumb a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .modern-breadcrumb a:hover {
        color: var(--secondary);
    }

    .modern-breadcrumb .active {
        color: #64748B;
    }

    /* Sidebar Sticky */
    .sidebar-sticky {
        position: sticky;
        top: 120px;
    }

    /* Categories Sidebar */
    .categories-sidebar {
        background: white;
        border-radius: 20px;
        border: 2px solid var(--neutral);
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
    }

    .sidebar-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .categories-list {
        padding: 1rem;
    }

    .category-item {
        margin-bottom: 0.5rem;
    }

    .category-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        color: var(--text);
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        font-weight: 600;
    }

    .category-link:hover {
        background: var(--background);
        border-color: var(--primary);
        color: var(--primary);
        transform: translateX(4px);
    }

    .category-item.active .category-link {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
    }

    .category-count {
        background: var(--neutral);
        color: var(--text);
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .category-item.active .category-count {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }

    .subcategories {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease;
        padding-left: 1rem;
    }

    .subcategories.show {
        max-height: 500px;
        padding-top: 0.5rem;
    }

    .subcategory-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.25rem;
        color: #64748B;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .subcategory-link i {
        color: var(--primary);
        transition: all 0.3s ease;
    }

    .subcategory-link:hover {
        background: var(--background);
        color: var(--primary);
        transform: translateX(4px);
    }

    .subcategory-link:hover i {
        transform: translateX(4px);
    }

    .subcategory-link.active {
        background: var(--background);
        color: var(--primary);
        font-weight: 700;
        border-left: 4px solid var(--primary);
    }

    /* Filter Banner */
    .filter-banner {
        background: linear-gradient(135deg, var(--warning), #F97316);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        color: white;
        box-shadow: 0 8px 24px rgba(245, 158, 11, 0.3);
    }

    .banner-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .banner-icon i {
        font-size: 1.75rem;
    }

    .filter-banner h6 {
        font-weight: 800;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
    }

    .filter-banner p {
        margin-bottom: 1.5rem;
        opacity: 0.95;
    }

    .banner-link {
        display: inline-flex;
        align-items: center;
        background: white;
        color: var(--warning);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .banner-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        color: var(--warning);
    }

    /* Category Header */
    .category-header {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid var(--neutral);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .icon-wrapper {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 16px rgba(0, 102, 255, 0.3);
    }

    .icon-wrapper i {
        font-size: 2rem;
        color: white;
    }

    .header-content h2 {
        color: var(--text);
        font-weight: 800;
        margin: 0;
    }

    .header-actions .form-select {
        border: 2px solid var(--neutral);
        border-radius: 12px;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        min-width: 200px;
        transition: all 0.3s ease;
    }

    .header-actions .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1);
    }

    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .product-card-wrapper {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
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

    .product-card {
        background: white;
        border-radius: 20px;
        border: 2px solid var(--neutral);
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        border-color: var(--primary);
        box-shadow: 0 12px 32px rgba(0, 102, 255, 0.15);
        transform: translateY(-8px);
    }

    .product-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, var(--danger), #DC2626);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.9rem;
        z-index: 2;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .product-image-link {
        display: block;
        position: relative;
    }

    .product-image-wrapper {
        position: relative;
        height: 280px;
        background: var(--background);
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral);
    }

    .image-placeholder i {
        font-size: 4rem;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .image-overlay {
        opacity: 1;
    }

    .image-overlay i {
        color: white;
        font-size: 2.5rem;
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }

    .product-card:hover .image-overlay i {
        transform: scale(1);
    }

    .product-content {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .product-brand {
        color: #64748B;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .product-brand i {
        color: var(--primary);
    }

    .product-name {
        margin-bottom: 1rem;
        min-height: 48px;
    }

    .product-name a {
        color: var(--text);
        text-decoration: none;
        font-weight: 700;
        font-size: 1.05rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s ease;
    }

    .product-name a:hover {
        color: var(--primary);
    }

    .product-price {
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .price-current {
        color: var(--primary);
        font-size: 1.5rem;
        font-weight: 800;
    }

    .price-current.sale {
        color: var(--danger);
    }

    .price-old {
        color: #94A3B8;
        font-size: 1rem;
        text-decoration: line-through;
    }

    .btn-view-detail {
        padding: 0.85rem 1.5rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
        margin-top: auto;
    }

    .btn-view-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 102, 255, 0.4);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        background: white;
        border-radius: 24px;
        border: 2px solid var(--neutral);
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 2rem;
        background: linear-gradient(135deg, var(--background), #E0F2FE);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-icon i {
        font-size: 4rem;
        color: var(--neutral);
    }

    .empty-state h3 {
        color: var(--text);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: #64748B;
        margin-bottom: 2rem;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(0, 102, 255, 0.3);
    }

    .btn-back:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 102, 255, 0.4);
        color: white;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .sidebar-sticky {
            position: static;
        }

        .categories-sidebar {
            margin-bottom: 2rem;
        }

        .filter-banner {
            display: none;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .category-header {
            padding: 1.5rem;
            flex-direction: column;
            align-items: flex-start;
        }

        .header-content {
            flex-direction: column;
            text-align: center;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .form-select {
            width: 100%;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem;
        }

        .product-image-wrapper {
            height: 200px;
        }

        .product-content {
            padding: 1.25rem;
        }
    }
</style>
@endsection
