<div class="category-sidebar">
    <h5 class="mb-3">
        <i class="fas fa-list"></i> Danh Mục Sản Phẩm
    </h5>

    <div class="list-group list-group-flush">
        @foreach($categories as $category)
            <div class="category-item">
                <a href="{{ route('client.product.category.index', $category->slug) }}"
                    class="d-flex justify-content-between align-items-center">
                    <span>
                        @if($category->icon)
                            <i class="{{ $category->icon }}"></i>
                        @endif
                        {{ $category->name }}
                    </span>
                    @if($category->children->count() > 0)
                        <i class="fas fa-chevron-right"></i>
                    @endif
                </a>

                {{-- Subcategories --}}
                @if($category->children->count() > 0)
                    <div class="ps-3 mt-2">
                        @foreach($category->children as $child)
                            <div class="py-1">
                                <a href="{{ route('client.product.category.index', $child->slug) }}" class="text-muted small">
                                    <i class="fas fa-angle-right"></i> {{ $child->name }}
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
    @if(isset($brands) && $brands->count() > 0)
        <div class="mt-4 pt-3 border-top">
            <h6 class="mb-3">Thương Hiệu</h6>
            <div class="brand-list">
                @foreach($brands as $brand)
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