@extends('client.layouts.client')

@section('title', 'Tất cả Sản Phẩm')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="products-header">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="header-content">
                        <div class="icon-wrapper">
                            <i class="fas fa-box"></i>
                        </div>
                        <div>
                            <h2 class="mb-1">Tất Cả Sản Phẩm</h2>
                            <p class="text-muted mb-0">Khám phá {{ $products->total() }} sản phẩm</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-controls">
                        <!-- Sort -->
                        <div class="sort-wrapper">
                            <i class="fas fa-sort-amount-down"></i>
                            <select class="form-select" onchange="sortProducts(this.value)">
                                <option value="">Sắp xếp</option>
                                <option value="created_at-DESC" {{ (request('sort') == 'created_at' || !request('sort')) && request('order', 'DESC') == 'DESC' ? 'selected' : '' }}>
                                    Mới nhất
                                </option>
                                <option value="price-ASC" {{ request('sort') == 'price' && request('order') == 'ASC' ? 'selected' : '' }}>
                                    Giá: Thấp → Cao
                                </option>
                                <option value="price-DESC" {{ request('sort') == 'price' && request('order') == 'DESC' ? 'selected' : '' }}>
                                    Giá: Cao → Thấp
                                </option>
                                <option value="name-ASC" {{ request('sort') == 'name' && request('order') == 'ASC' ? 'selected' : '' }}>
                                    Tên: A → Z
                                </option>
                                <option value="sold_count-DESC" {{ request('sort') == 'sold_count' && request('order') == 'DESC' ? 'selected' : '' }}>
                                    Bán chạy
                                </option>
                            </select>
                        </div>

                        <!-- View Toggle -->
                        <div class="view-toggle">
                            <button type="button" class="view-btn active" onclick="viewGrid()" data-view="grid">
                                <i class="fas fa-th"></i>
                            </button>
                            <button type="button" class="view-btn" onclick="viewList()" data-view="list">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Filters -->
        @if(request()->hasAny(['category_id', 'brand_id', 'price_from', 'price_to']))
            <div class="active-filters">
                <div class="filters-label">
                    <i class="fas fa-filter"></i> Bộ lọc đang áp dụng:
                </div>
                <div class="filters-list">
                    @if(request('category_id'))
                        <span class="filter-badge">
                            <i class="fas fa-tag"></i> Danh mục: {{ $categories->find(request('category_id'))->name ?? '' }}
                            <a href="{{ route('client.product.index', Illuminate\Support\Arr::except(request()->all(), 'category_id')) }}" class="remove-filter">×</a>
                        </span>
                    @endif

                    @if(request('brand_id'))
                        <span class="filter-badge">
                            <i class="fas fa-trademark"></i> Thương hiệu: {{ $brands->find(request('brand_id'))->name ?? '' }}
                            <a href="{{ route('client.product.index', Illuminate\Support\Arr::except(request()->all(), 'brand_id')) }}" class="remove-filter">×</a>
                        </span>
                    @endif

                    @if(request('price_from') || request('price_to'))
                        <span class="filter-badge">
                            <i class="fas fa-dollar-sign"></i> Giá: {{ number_format(request('price_from', 0)) }} - {{ number_format(request('price_to', 0)) }}đ
                            <a href="{{ route('client.product.index', request()->except(['price_from', 'price_to'])) }}" class="remove-filter">×</a>
                        </span>
                    @endif
                </div>
                <a href="{{ route('client.product.index') }}" class="clear-all-filters">
                    <i class="fas fa-times"></i> Xóa tất cả
                </a>
            </div>
        @endif

        <!-- Products Grid -->
        <div class="products-grid grid-view" id="productsGrid">
            @forelse($products as $index => $product)
                <div class="product-card-wrapper" style="animation-delay: {{ $index * 0.05 }}s">
                    <div class="product-card">
                        <!-- Badges -->
                        <div class="product-badges">
                            @if($product->is_featured)
                                <span class="badge-featured">
                                    <i class="fas fa-fire"></i> Nổi bật
                                </span>
                            @endif
                            @if($product->sale_price)
                                <span class="badge-discount">
                                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                </span>
                            @endif
                        </div>

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
                            <!-- Brand -->
                            <div class="product-brand">
                                <i class="fas fa-tag"></i> {{ $product->brand->name }}
                            </div>

                            <!-- Name -->
                            <h6 class="product-name">
                                <a href="{{ route('client.product.show', $product->slug) }}">
                                    {{ Str::limit($product->name, 60) }}
                                </a>
                            </h6>

                            <!-- Rating -->
                            <div class="product-rating">
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $product->average_rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-count">({{ $product->reviews->count() }})</span>
                            </div>

                            <!-- Price -->
                            <div class="product-price">
                                @if($product->sale_price)
                                    <span class="price-current sale">{{ number_format($product->sale_price) }}đ</span>
                                    <span class="price-old">{{ number_format($product->price) }}đ</span>
                                @else
                                    <span class="price-current">{{ number_format($product->price) }}đ</span>
                                @endif
                            </div>

                            <!-- Stock -->
                            <div class="product-stock">
                                @if($product->quantity > 0)
                                    <span class="stock-badge available">
                                        <i class="fas fa-check-circle"></i> Còn {{ $product->quantity }} sp
                                    </span>
                                @else
                                    <span class="stock-badge unavailable">
                                        <i class="fas fa-times-circle"></i> Hết hàng
                                    </span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="product-actions">
                                <a href="{{ route('client.product.show', $product->slug) }}" class="btn-view-detail">
                                    <i class="fas fa-eye"></i> Xem Chi Tiết
                                </a>
                                @if($product->quantity > 0)
                                    <form action="{{ route('client.cart.add', $product->id) }}" method="POST" class="add-cart-form">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn-add-cart">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="empty-products">
                        <div class="empty-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h3>Không Tìm Thấy Sản Phẩm</h3>
                        <p>Vui lòng thử tìm kiếm với từ khóa khác hoặc xóa bộ lọc</p>
                        <a href="{{ route('client.product.index') }}" class="btn-reset">
                            <i class="fas fa-redo"></i> Xem Tất Cả Sản Phẩm
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
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

    /* Page Header */
    .products-header {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid var(--neutral);
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

    .header-controls {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        align-items: center;
    }

    .sort-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: var(--background);
        padding: 0.75rem 1rem;
        border-radius: 12px;
        border: 2px solid var(--neutral);
    }

    .sort-wrapper i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .sort-wrapper .form-select {
        border: none;
        background: transparent;
        font-weight: 600;
        color: var(--text);
        padding: 0 2rem 0 0;
        min-width: 180px;
    }

    .sort-wrapper .form-select:focus {
        box-shadow: none;
    }

    .view-toggle {
        display: flex;
        gap: 0.5rem;
        background: var(--background);
        padding: 0.5rem;
        border-radius: 12px;
        border: 2px solid var(--neutral);
    }

    .view-btn {
        width: 40px;
        height: 40px;
        border: none;
        background: transparent;
        border-radius: 8px;
        color: #64748B;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .view-btn:hover {
        background: white;
        color: var(--primary);
    }

    .view-btn.active {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
    }

    /* Active Filters */
    .active-filters {
        background: white;
        border-radius: 16px;
        padding: 1.25rem 1.75rem;
        margin-bottom: 2rem;
        border: 2px solid var(--neutral);
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }

    .filters-label {
        color: var(--text);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filters-label i {
        color: var(--primary);
    }

    .filters-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        flex: 1;
    }

    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 0.65rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .filter-badge i {
        font-size: 0.85rem;
    }

    .remove-filter {
        color: white;
        text-decoration: none;
        font-size: 1.25rem;
        font-weight: 700;
        margin-left: 0.5rem;
        transition: all 0.3s ease;
    }

    .remove-filter:hover {
        transform: scale(1.2);
    }

    .clear-all-filters {
        padding: 0.65rem 1.25rem;
        background: var(--danger);
        color: white;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .clear-all-filters:hover {
        background: #DC2626;
        color: white;
        transform: translateY(-2px);
    }

    /* Products Grid */
    .products-grid {
        display: grid;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .products-grid.grid-view {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }

    .products-grid.list-view {
        grid-template-columns: 1fr;
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

    /* List View Styles */
    .products-grid.list-view .product-card {
        flex-direction: row;
        height: auto;
    }

    .products-grid.list-view .product-image-wrapper {
        width: 250px;
        height: 250px;
        flex-shrink: 0;
    }

    .products-grid.list-view .product-content {
        flex: 1;
        padding: 2rem;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 1.5rem;
    }

    .products-grid.list-view .product-name {
        font-size: 1.25rem;
        grid-column: 1 / -1;
    }

    .products-grid.list-view .product-actions {
        grid-column: 1 / -1;
        flex-direction: row;
    }

    .products-grid.list-view .btn-view-detail {
        flex: 1;
    }

    /* Product Badges */
    .product-badges {
        position: absolute;
        top: 1rem;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-between;
        padding: 0 1rem;
        z-index: 2;
    }

    .badge-featured,
    .badge-discount {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .badge-featured {
        background: linear-gradient(135deg, var(--danger), #DC2626);
        color: white;
    }

    .badge-discount {
        background: linear-gradient(135deg, var(--warning), #F97316);
        color: white;
    }

    /* Product Image */
    .product-image-link {
        display: block;
        position: relative;
    }

    .product-image-wrapper {
        position: relative;
        height: 300px;
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

    /* Product Content */
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

    .product-rating {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .rating-stars i {
        color: var(--warning);
        font-size: 1rem;
    }

    .rating-count {
        color: #64748B;
        font-size: 0.9rem;
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

    .product-stock {
        margin-bottom: 1rem;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .stock-badge.available {
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #065F46;
    }

    .stock-badge.unavailable {
        background: linear-gradient(135deg, #FEE2E2, #FECACA);
        color: #991B1B;
    }

    /* Product Actions */
    .product-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: auto;
    }

    .btn-view-detail {
        flex: 1;
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
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
    }

    .btn-view-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 102, 255, 0.4);
        color: white;
    }

    .add-cart-form {
        flex-shrink: 0;
    }

    .btn-add-cart {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--warning), #F97316);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-add-cart:hover {
        transform: translateY(-2px) rotate(15deg);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4);
    }

    /* Empty State */
    .empty-products {
        grid-column: 1 / -1;
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

    .empty-products h3 {
        color: var(--text);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .empty-products p {
        color: #64748B;
        margin-bottom: 2rem;
    }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(0, 102, 255, 0.3);
    }

    .btn-reset:hover {
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
        .products-grid.grid-view {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }

        .products-grid.list-view .product-card {
            flex-direction: column;
        }

        .products-grid.list-view .product-image-wrapper {
            width: 100%;
            height: 300px;
        }

        .products-grid.list-view .product-content {
            display: flex;
            flex-direction: column;
        }
    }

    @media (max-width: 768px) {
        .products-header {
            padding: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            text-align: center;
        }

        .header-controls {
            width: 100%;
            flex-direction: column;
        }

        .sort-wrapper,
        .view-toggle {
            width: 100%;
            justify-content: center;
        }

        .products-grid.grid-view {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .product-card {
            border-radius: 16px;
        }

        .product-content {
            padding: 1.25rem;
        }

        .active-filters {
            padding: 1rem;
        }

        .filters-list {
            width: 100%;
        }
    }
</style>

@section('scripts')
    <script>
        function sortProducts(value) {
            if (!value) {
                const url = new URL(window.location.href);
                url.searchParams.delete('sort');
                url.searchParams.delete('order');
                window.location.href = url.toString();
                return;
            }

            const [sort, order] = value.split('-');

            if (!sort || !order) {
                console.error('Invalid sort value:', value);
                return;
            }

            const url = new URL(window.location.href);
            url.searchParams.set('sort', sort);
            url.searchParams.set('order', order);
            window.location.href = url.toString();
        }

        function viewGrid() {
            const grid = document.getElementById('productsGrid');
            const buttons = document.querySelectorAll('.view-btn');

            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.closest('.view-btn').classList.add('active');

            grid.classList.remove('list-view');
            grid.classList.add('grid-view');
        }

        function viewList() {
            const grid = document.getElementById('productsGrid');
            const buttons = document.querySelectorAll('.view-btn');

            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.closest('.view-btn').classList.add('active');

            grid.classList.remove('grid-view');
            grid.classList.add('list-view');
        }
    </script>
@endsection
