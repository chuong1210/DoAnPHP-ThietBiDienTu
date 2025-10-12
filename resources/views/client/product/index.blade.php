@extends('client.layouts.client')

@section('title', 'Danh Sách Sản Phẩm')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="fas fa-box"></i> Tất Cả Sản Phẩm
            <small class="text-muted">({{ $products->total() }} sản phẩm)</small>
        </h3>

        <!-- Sort -->
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" onchange="sortProducts(this.value)" style="width: 200px;">
                <option value="">Sắp xếp</option>
                <option value="created_at-DESC" {{ request('sort') == 'created_at' && request('order') == 'DESC' ? 'selected' : '' }}>
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

            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-outline-secondary active" onclick="viewGrid()">
                    <i class="fas fa-th"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="viewList()">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Active Filters -->
    @if(request()->hasAny(['category_id', 'brand_id', 'price_from', 'price_to']))
        <div class="mb-3">
            <span class="fw-bold">Bộ lọc đang áp dụng:</span>

            @if(request('category_id'))
                <span class="badge bg-primary">
                    Danh mục: {{ $categories->find(request('category_id'))->name ?? '' }}
                    <a href="{{ route('client.product.index', Illuminate\Support\Arr::except(request()->all(), 'category_id')) }}"
                        class="text-white ms-1">×</a>
                </span>
            @endif

            @if(request('brand_id'))
                <span class="badge bg-primary">
                    Thương hiệu: {{ $brands->find(request('brand_id'))->name ?? '' }}
                    <a href="{{ route('client.product.index', Illuminate\Support\Arr::except(request()->all(), 'brand_id')) }}"
                        class="text-white ms-1">×</a>
                </span>
            @endif

            @if(request('price_from') || request('price_to'))
                <span class="badge bg-primary">
                    Giá: {{ number_format(request('price_from', 0)) }} - {{ number_format(request('price_to', 0)) }}đ
                    <a href="{{ route('client.product.index', request()->except(['price_from', 'price_to'])) }}"
                        class="text-white ms-1">×</a>
                </span>
            @endif

            <a href="{{ route('client.product.index') }}" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-times"></i> Xóa tất cả
            </a>
        </div>
    @endif

    <!-- Products Grid -->
    <div class="row" id="productsGrid">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    <!-- Badge -->
                    @if($product->is_featured)
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                            <i class="fas fa-fire"></i> Nổi bật
                        </span>
                    @endif

                    @if($product->sale_price)
                        <span class="badge bg-warning position-absolute top-0 end-0 m-2">
                            -{{ $product->discount_percent }}%
                        </span>
                    @endif

                    <!-- Image -->
                    <a href="{{ route('client.product.show', $product->slug) }}">
                        @if($product->image)
                            <img src="{{ asset('images/products/' . $product->image) }}" class="card-img-top product-image"
                                alt="{{ $product->name }}">
                        @else
                            <div class="card-img-top product-image bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    </a>

                    <div class="card-body d-flex flex-column">
                        <!-- Brand -->
                        <p class="text-muted small mb-2">
                            <i class="fas fa-tag"></i> {{ $product->brand->name }}
                        </p>

                        <!-- Name -->
                        <h6 class="card-title">
                            <a href="{{ route('client.product.show', $product->slug) }}" class="text-decoration-none text-dark">
                                {{ Str::limit($product->name, 60) }}
                            </a>
                        </h6>

                        <!-- Rating -->
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $product->average_rating)
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                            <span class="text-muted small">({{ $product->reviews->count() }})</span>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            @if($product->sale_price)
                                <span class="h5 text-danger mb-0">{{ number_format($product->sale_price) }}đ</span>
                                <br>
                                <span class="price-old small">{{ number_format($product->price) }}đ</span>
                            @else
                                <span class="h5 text-primary mb-0">{{ number_format($product->price) }}đ</span>
                            @endif
                        </div>

                        <!-- Stock -->
                        <div class="mb-3">
                            @if($product->quantity > 0)
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> Còn hàng
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times"></i> Hết hàng
                                </span>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="mt-auto">
                            <div class="d-grid gap-2">
                                <a href="{{ route('client.product.show', $product->slug) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i> Xem Chi Tiết
                                </a>

                                @if($product->quantity > 0)
                                    <form action="{{ route('client.cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-cart-plus"></i> Thêm Vào Giỏ
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h5>Không tìm thấy sản phẩm nào</h5>
                    <p class="mb-0">Vui lòng thử tìm kiếm với từ khóa khác hoặc xóa bộ lọc</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(request()->query())->links() }}
    </div>
@endsection

@section('scripts')
    <script>
        function sortProducts(value) {
            if (!value) return;

            const [sort, order] = value.split('-');
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sort);
            url.searchParams.set('order', order);
            window.location.href = url.toString();
        }

        function viewGrid() {
            // Toggle active button
            document.querySelectorAll('.btn-group button').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.closest('button').classList.add('active');
        }

        function viewList() {
            // Toggle active button
            document.querySelectorAll('.btn-group button').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.closest('button').classList.add('active');

            // TODO: Implement list view
            alert('Chế độ xem danh sách - Coming soon!');
        }
    </script>
@endsection