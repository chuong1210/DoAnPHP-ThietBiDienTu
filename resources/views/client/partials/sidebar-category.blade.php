<div class="category-sidebar-wrapper">
    <div class="category-sidebar">
        <!-- Header -->
        <div class="sidebar-header">
            <h5 class="mb-0">
                <i class="fas fa-layer-group"></i> Danh Mục
            </h5>
            <button class="btn-collapse d-md-none" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Categories List -->
        <div class="sidebar-content" id="sidebarContent">
            <div class="category-list">
                @foreach($categories as $index => $category)
                    <div class="category-item" data-category="{{ $category->id }}">
                        <a href="{{ route('client.product.category.index', $category->slug) }}"
                            class="category-link {{ request()->segment(3) == $category->slug ? 'active' : '' }}">
                            <span class="category-icon">
                                @if($category->icon)
                                    <i class="{{ $category->icon }}"></i>
                                @else
                                    <i class="fas fa-cube"></i>
                                @endif
                            </span>
                            <span class="category-name">{{ $category->name }}</span>
                            @if($category->children->count() > 0)
                                <i class="fas fa-chevron-down toggle-icon"></i>
                            @endif
                        </a>

                        {{-- Subcategories --}}
                        @if($category->children->count() > 0)
                            <div class="subcategory-list">
                                @foreach($category->children as $child)
                                    <a href="{{ route('client.product.category.index', $child->slug) }}"
                                        class="subcategory-link {{ request()->segment(3) == $child->slug ? 'active' : '' }}">
                                        <i class="fas fa-angle-right"></i>
                                        <span>{{ $child->name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Price Filter -->
            <div class="filter-box">
                <h6 class="filter-title">
                    <i class="fas fa-filter"></i> Lọc Giá
                </h6>
                <form action="{{ route('client.product.index') }}" method="GET" class="filter-form">
                    <div class="price-inputs">
                        <div class="price-input-group">
                            <label>Từ (VNĐ)</label>
                            <input type="number" name="price_from" class="form-control" placeholder="0"
                                value="{{ request('price_from') }}">
                        </div>
                        <div class="price-separator">-</div>
                        <div class="price-input-group">
                            <label>Đến (VNĐ)</label>
                            <input type="number" name="price_to" class="form-control" placeholder="10,000,000"
                                value="{{ request('price_to') }}">
                        </div>
                    </div>
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-search"></i> Áp Dụng
                    </button>
                </form>
            </div>

            <!-- Brand Filter -->
            @if(isset($brands) && $brands !== false && $brands->count() > 0)
                <div class="filter-box">
                    <h6 class="filter-title">
                        <i class="fas fa-tags"></i> Thương Hiệu
                    </h6>
                    <div class="brand-list">
                        @foreach($brands as $brand)
                            <div class="brand-item">
                                <input class="form-check-input" type="checkbox" id="brand{{ $brand->id }}"
                                    {{ in_array($brand->id, request('brand', [])) ? 'checked' : '' }}
                                    onchange="filterByBrand({{ $brand->id }})">
                                <label class="form-check-label" for="brand{{ $brand->id }}">
                                    {{ $brand->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quick Links -->
            <div class="quick-links">
                <h6 class="filter-title">
                    <i class="fas fa-bolt"></i> Truy Cập Nhanh
                </h6>
                <a href="#" class="quick-link">
                    <i class="fas fa-fire"></i> Sản phẩm hot
                </a>
                <a href="#" class="quick-link">
                    <i class="fas fa-star"></i> Đánh giá cao
                </a>
                <a href="#" class="quick-link">
                    <i class="fas fa-percentage"></i> Giảm giá
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #0066FF;
        --secondary: #00B4D8;
        --background: #F8FAFC;
        --text: #1E293B;
        --neutral: #CBD5E1;
    }

    .category-sidebar-wrapper {
        position: sticky;
        top: 100px;
    }

    .category-sidebar {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid var(--neutral);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    /* Header */
    .sidebar-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        padding: 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }

    .sidebar-header h5 {
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-collapse {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-collapse:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Sidebar Content */
    .sidebar-content {
        padding: 1rem;
        max-height: calc(100vh - 200px);
        overflow-y: auto;
        transition: all 0.3s ease;
    }

    .sidebar-content::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-content::-webkit-scrollbar-track {
        background: var(--background);
        border-radius: 10px;
    }

    .sidebar-content::-webkit-scrollbar-thumb {
        background: var(--neutral);
        border-radius: 10px;
    }

    .sidebar-content::-webkit-scrollbar-thumb:hover {
        background: var(--primary);
    }

    /* Category Item - COMPACT SPACING */
    .category-item {
        margin-bottom: 0.25rem; /* Giảm từ 0.5rem xuống 0.35rem */
        animation: fadeInLeft 0.5s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .category-link {
        display: flex;
        align-items: center;
        padding: 0.7rem 0.85rem; /* Giảm từ 0.85rem 1rem xuống 0.7rem 0.85rem */
        color: var(--text);
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-weight: 500;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .category-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        opacity: 0.1;
        transition: width 0.4s ease;
    }

    .category-link:hover::before {
        width: 100%;
    }

    .category-link:hover {
        color: var(--primary);
        background: var(--background);
        transform: translateX(4px);
        border-color: var(--primary);
    }

    .category-link.active {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
    }

    .category-link.active::before {
        display: none;
    }

    .category-icon {
        width: 32px; /* Giảm từ 35px xuống 32px */
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--background);
        border-radius: 10px;
        margin-right: 0.65rem; /* Giảm từ 0.75rem xuống 0.65rem */
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .category-link:hover .category-icon {
        background: white;
        transform: rotate(5deg) scale(1.1);
    }

    .category-link.active .category-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .category-name {
        flex: 1;
        font-size: 0.95rem;
    }

    .toggle-icon {
        margin-left: auto;
        font-size: 0.75rem;
        transition: transform 0.3s ease;
    }

    .category-item.open .toggle-icon {
        transform: rotate(180deg);
    }

    /* Subcategories - COMPACT SPACING */
    .subcategory-list {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease;
        padding-left: 2.75rem; /* Giảm từ 3rem xuống 2.75rem */
    }

    .category-item.open .subcategory-list {
        max-height: 500px;
        padding-top: 0.35rem; /* Giảm từ 0.5rem xuống 0.35rem */
    }

    .subcategory-link {
        display: flex;
        align-items: center;
        padding: 0.55rem 0.85rem; /* Giảm từ 0.65rem 1rem xuống 0.55rem 0.85rem */
        color: #64748B;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin-bottom: 0.2rem; /* Giảm từ 0.25rem xuống 0.2rem */
        font-size: 0.88rem; /* Giảm từ 0.9rem xuống 0.88rem */
    }

    .subcategory-link i {
        margin-right: 0.45rem; /* Giảm từ 0.5rem xuống 0.45rem */
        color: var(--primary);
        transition: all 0.3s ease;
        font-size: 0.85rem;
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
        font-weight: 600;
        border-left: 3px solid var(--primary);
    }

    /* Filter Box */
    .filter-box {
        margin-top: 1.25rem; /* Giảm từ 1.5rem xuống 1.25rem */
        padding-top: 1.25rem;
        border-top: 2px solid var(--background);
    }

    .filter-title {
        color: var(--text);
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 0.85rem; /* Giảm từ 1rem xuống 0.85rem */
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-title i {
        color: var(--primary);
    }

    .price-inputs {
        display: flex;
        align-items: center;
        gap: 0.65rem; /* Giảm từ 0.75rem xuống 0.65rem */
        margin-bottom: 0.85rem; /* Giảm từ 1rem xuống 0.85rem */
    }

    .price-input-group {
        flex: 1;
    }

    .price-input-group label {
        font-size: 0.78rem;
        color: #64748B;
        margin-bottom: 0.25rem;
        display: block;
    }

    .price-input-group .form-control {
        border: 2px solid var(--neutral);
        border-radius: 8px;
        padding: 0.45rem; /* Giảm từ 0.5rem xuống 0.45rem */
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .price-input-group .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
    }

    .price-separator {
        color: #64748B;
        font-weight: 600;
        padding-top: 1.5rem;
    }

    .btn-filter {
        width: 100%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.7rem; /* Giảm từ 0.75rem xuống 0.7rem */
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 102, 255, 0.3);
    }

    /* Brand List - COMPACT SPACING */
    .brand-list {
        display: flex;
        flex-direction: column;
        gap: 0.4rem; /* Giảm từ 0.5rem xuống 0.4rem */
    }

    .brand-item {
        display: flex;
        align-items: center;
        padding: 0.55rem 0.85rem; /* Giảm từ 0.65rem 1rem xuống 0.55rem 0.85rem */
        border-radius: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .brand-item:hover {
        background: var(--background);
    }

    .brand-item .form-check-input {
        margin-right: 0.65rem; /* Giảm từ 0.75rem xuống 0.65rem */
        cursor: pointer;
        border: 2px solid var(--neutral);
        width: 18px; /* Giảm từ 20px xuống 18px */
        height: 18px;
    }

    .brand-item .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .brand-item .form-check-label {
        cursor: pointer;
        font-size: 0.88rem; /* Giảm từ 0.9rem xuống 0.88rem */
        color: var(--text);
        margin-bottom: 0;
    }

    /* Quick Links - COMPACT SPACING */
    .quick-links {
        margin-top: 1.25rem; /* Giảm từ 1.5rem xuống 1.25rem */
        padding-top: 1.25rem;
        border-top: 2px solid var(--background);
    }

    .quick-link {
        display: flex;
        align-items: center;
        padding: 0.65rem 0.85rem; /* Giảm từ 0.75rem 1rem xuống 0.65rem 0.85rem */
        color: var(--text);
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        margin-bottom: 0.4rem; /* Giảm từ 0.5rem xuống 0.4rem */
        border: 2px solid transparent;
        font-size: 0.9rem;
    }

    .quick-link i {
        margin-right: 0.65rem; /* Giảm từ 0.75rem xuống 0.65rem */
        width: 18px;
        text-align: center;
        color: var(--primary);
    }

    .quick-link:hover {
        background: var(--background);
        border-color: var(--primary);
        color: var(--primary);
        transform: translateX(4px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .category-sidebar-wrapper {
            position: relative;
            top: 0;
            margin-bottom: 1rem;
        }

        .sidebar-content {
            max-height: 0;
            padding: 0;
            overflow: hidden;
        }

        .sidebar-content.show {
            max-height: 1000px;
            padding: 1rem;
        }
    }
</style>

<script>
    document.querySelectorAll('.category-link').forEach(link => {
        link.addEventListener('click', function (e) {
            const hasSubcategories = this.querySelector('.toggle-icon');
            if (hasSubcategories) {
                e.preventDefault();
                const categoryItem = this.closest('.category-item');
                categoryItem.classList.toggle('open');
            }
        });
    });

    // Toggle sidebar on mobile
    function toggleSidebar() {
        const content = document.getElementById('sidebarContent');
        content.classList.toggle('show');
    }

    // Filter by brand
    function filterByBrand(brandId) {
        const checkbox = document.getElementById('brand' + brandId);
        const url = new URL(window.location);

        if (checkbox.checked) {
            url.searchParams.append('brand', brandId);
        } else {
            const brands = url.searchParams.getAll('brand');
            url.searchParams.delete('brand');
            brands.filter(b => b != brandId).forEach(b => url.searchParams.append('brand', b));
        }

        window.location = url;
    }

    // Auto-open active category
    document.addEventListener('DOMContentLoaded', function () {
        const activeLink = document.querySelector('.category-link.active, .subcategory-link.active');
        if (activeLink) {
            const categoryItem = activeLink.closest('.category-item');
            if (categoryItem) {
                categoryItem.classList.add('open');
            }
        }
    });
</script>
