<div class="category-sidebar">
    <h5 class="mb-3">
        <i class="fas fa-list"></i> Danh Mục Sản Phẩm
    </h5>

    <div class="list-group list-group-flush" id="categoryAccordion">
        @foreach ($categories as $category)
            <div class="category-item">
                <a href="javascript:void(0);"
                    class="d-flex justify-content-between align-items-center category-parent py-1"
                    data-id="{{ $category->id }}">
                    @if ($category->icon)
                        <i class="{{ $category->icon }} me-1"></i>
                    @endif
                    {{ $category->name }}
                </a>

                {{-- Subcategories --}}
                @if ($category->children->count() > 0)
                    <div class="subcategories ps-3 mt-1 d-none">
                        @foreach ($category->children as $child)
                            <div class="py-1">
                                <a href="{{ route('client.product.category.index', $child->slug) }}"
                                    class="subcategory text-muted small d-block">
                                    <i class="fas fa-angle-right me-1"></i> {{ $child->name }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Filter Box --}}
    <div class="mt-4 pt-3 border-top">
        <h6 class="mb-3">Lọc Giá</h6>
        <form action="{{ route('client.product.index') }}" method="GET">
            <div class="mb-2">
                <input type="number" name="price_from" class="form-control form-control-sm" placeholder="Từ (VNĐ)"
                    value="{{ request('price_from') }}">
            </div>
            <div class="mb-2">
                <input type="number" name="price_to" class="form-control form-control-sm" placeholder="Đến (VNĐ)"
                    value="{{ request('price_to') }}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm w-100">
                <i class="fas fa-filter"></i> Lọc
            </button>
        </form>
    </div>

    {{-- Brands --}}
    @if (isset($brands) && $brands->count() > 0)
        <div class="mt-4 pt-3 border-top">
            <h6 class="mb-3">Thương Hiệu</h6>
            <div class="brand-list">
                @foreach ($brands as $brand)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="brand{{ $brand->id }}"
                            onchange="filterByBrand({{ $brand->id }})">
                        <label class="form-check-label small" for="brand{{ $brand->id }}">
                            {{ $brand->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<style>
    .subcategory.active {
        color: #007bff;
        font-weight: 600;
    }

    .category-parent {
        cursor: pointer;
    }

    .category-item .subcategory {
        font-size: 0.875rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const parents = document.querySelectorAll('.category-parent');

        parents.forEach(parent => {
            parent.addEventListener('click', function(event) {
                event.preventDefault(); // Ngăn hành vi mặc định của thẻ a
                const parentId = this.dataset.id;
                const currentSub = this.nextElementSibling;

                // Đóng các danh mục con của các cha khác
                document.querySelectorAll('.category-parent').forEach(p => {
                    if (p.dataset.id !== parentId) {
                        const otherSub = p.nextElementSibling;
                        otherSub?.classList.add('d-none');
                    }
                });

                // Bật/tắt danh mục con hiện tại
                if (currentSub) {
                    currentSub.classList.toggle('d-none');
                }
            });
        });

        // Đánh dấu danh mục con khi nhấn và giữ cha mở rộng
        const subLinks = document.querySelectorAll('.subcategory');
        subLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                // Ngăn sự kiện lan tỏa lên cha để không thu gọn danh mục
                event.stopPropagation();
                subLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                // Cho phép chuyển hướng theo link của mục con
            });
        });
    });
</script>
