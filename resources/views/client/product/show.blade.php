@extends('client.layouts.client')

@section('title', $product->name)

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('client.product.category.index', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-5 mb-4">
            <div class="card">
                <div class="card-body">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" class="img-fluid rounded mb-3"
                            alt="{{ $product->name }}" id="mainImage">
                    @else
                        <div class="bg-light text-center py-5 rounded mb-3">
                            <i class="fas fa-image fa-5x text-muted"></i>
                        </div>
                    @endif

                    <!-- Gallery -->
                    @if(!empty($product->images))
                        <div class="row g-2">
                            @foreach($product->images as $image)
                                <div class="col-3">
                                    <img src="{{ asset( $image) }}" class="img-thumbnail cursor-pointer"
                                        onclick="changeMainImage(this.src)" alt="Gallery">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <!-- Brand -->
                    <p class="text-muted mb-2">
                        <i class="fas fa-tag"></i> Thương hiệu:
                        <a href="{{ route('client.brand.index', $product->brand->slug) }}">
                            <strong>{{ $product->brand->name }}</strong>
                        </a>
                    </p>

                    <!-- Name -->
                    <h2 class="mb-3">{{ $product->name }}</h2>

                    <!-- Rating -->
                    <div class="mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $averageRating)
                                <i class="fas fa-star text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                        <span class="ms-2">
                            <strong>{{ number_format($averageRating, 1) }}</strong>
                            ({{ $reviews->total() }} đánh giá)
                        </span>
                        <span class="ms-3 text-muted">
                            <i class="fas fa-eye"></i> {{ number_format($product->view_count) }} lượt xem
                        </span>
                    </div>

                    <hr>

                    <!-- Price -->
                    <div class="mb-4">
                        @if($product->sale_price)
                            <div class="d-flex align-items-center gap-3">
                                <span class="h2 text-danger mb-0">{{ number_format($product->sale_price) }}đ</span>
                                <span class="h5 price-old mb-0 text-decoration-line-through">{{ number_format($product->price) }}đ</span>
                                @if($discountPercent > 0)
                                    <span class="badge bg-danger">-{{ $discountPercent }}%</span>
                                @endif
                            </div>
                        @else
                            <span class="h2 text-primary mb-0">{{ number_format($product->price) }}đ</span>
                        @endif
                    </div>

                    <!-- Stock -->
                    <div class="mb-4">
                        <strong>Tình trạng:</strong>
                        @if($product->quantity > 0)
                            <span class="badge bg-success ms-2">
                                <i class="fas fa-check"></i> Còn {{ $product->quantity }} sản phẩm
                            </span>
                        @else
                            <span class="badge bg-danger ms-2">
                                <i class="fas fa-times"></i> Hết hàng
                            </span>
                        @endif
                    </div>

                    <hr>

                    <!-- Add to Cart Form -->
                    @if($product->quantity > 0)
                        <form action="{{ route('client.cart.add', $product->id) }}" method="POST">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Số lượng:</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" id="quantity" class="form-control text-center"
                                            value="1" min="1" max="{{ $product->quantity }}">
                                        <button type="button" class="btn btn-outline-secondary" onclick="increaseQty()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-cart-plus"></i> Thêm Vào Giỏ Hàng
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-lg" onclick="buyNow()">
                                    <i class="fas fa-bolt"></i> Mua Ngay
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Sản phẩm hiện đang hết hàng
                        </div>
                    @endif

                    <!-- Features -->
                    <div class="mt-4 pt-4 border-top">
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="fas fa-shield-alt fa-2x text-primary mb-2"></i>
                                <p class="small mb-0">Bảo hành chính hãng</p>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-truck fa-2x text-primary mb-2"></i>
                                <p class="small mb-0">Giao hàng toàn quốc</p>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-undo fa-2x text-primary mb-2"></i>
                                <p class="small mb-0">Đổi trả trong 7 ngày</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Description & Reviews -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#description">
                                <i class="fas fa-info-circle"></i> Mô Tả
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#reviews">
                                <i class="fas fa-star"></i> Đánh Giá ({{ $reviews->total() }})
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Description Tab -->
                        <div class="tab-pane fade show active" id="description">
                            @if($product->description)
                                <div class="product-description">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            @else
                                <p class="text-muted">Chưa có mô tả chi tiết</p>
                            @endif
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews">
                            @if($reviews->count() > 0)
                                <div class="reviews-list">
                                    @foreach($reviews as $review)
                                        <div class="review-item mb-4 pb-4 border-bottom">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <strong class="me-2">{{ $review->user->full_name }}</strong>
                                                        <div class="text-warning">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= $review->rating)
                                                                    <i class="fas fa-star"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    @if($review->comment)
                                                        <p class="mt-2 mb-0 text-muted">{{ $review->comment }}</p>
                                                    @endif
                                                </div>
                                                <small class="text-muted ms-2">{{ $review->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center">
                                    {{ $reviews->links() }}
                                </div>
                            @else
                                <p class="text-muted text-center py-4">Chưa có đánh giá nào cho sản phẩm này.</p>
                            @endif

                            <!-- Add Review Button (nếu user đã mua) -->
                            @auth
                                @php
                                    $hasReviewed = $reviews->where('user_id', auth()->id())->count() > 0;
                                    $hasOrdered = \DB::table('order_items')
                                        ->join('orders', 'order_items.order_id', '=', 'orders.id')
                                        ->where('orders.user_id', auth()->id())
                                        ->where('order_items.product_id', $product->id)
                                        ->where('orders.status', 'delivered')
                                        ->exists();
                                @endphp
                                @if($hasOrdered && !$hasReviewed)
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('reviews.create', $product->slug) }}" class="btn btn-primary">
                                            <i class="fas fa-star"></i> Viết Đánh Giá Của Bạn
                                        </a>
                                    </div>
                                @elseif($hasReviewed)
                                    <div class="alert alert-info text-center mt-4">
                                        <i class="fas fa-check"></i> Bạn đã đánh giá sản phẩm này rồi.
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-info text-center mt-4">
                                    <i class="fas fa-sign-in-alt"></i> <a href="{{ route('auth.login') }}">Đăng nhập</a> để viết đánh giá.
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-5">
            <h4 class="mb-4">Sản Phẩm Liên Quan</h4>
            <div class="row">
                @foreach($relatedProducts as $related)
                    <div class="col-md-3 mb-4">
                        <div class="card product-card h-100">
                            <a href="{{ route('client.product.show', $related->slug) }}">
                                @if($related->image)
                                    <img src="{{ asset( $related->image) }}" class="card-img-top product-image"
                                        alt="{{ $related->name }}" loading="lazy">
                                @else
                                    <div class="card-img-top product-image bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ Str::limit($related->name, 50) }}</h6>
                                <p class="text-muted small mb-2">{{ $related->brand->name ?? 'N/A' }}</p>
                                <div class="mb-auto">
                                    <span class="h6 text-primary mb-0">
                                        @if($related->sale_price)
                                            {{ number_format($related->sale_price) }}đ
                                            <small class="text-decoration-line-through">{{ number_format($related->price) }}đ</small>
                                        @else
                                            {{ number_format($related->price) }}đ
                                        @endif
                                    </span>
                                </div>
                                <a href="{{ route('client.product.show', $related->slug) }}"
                                    class="btn btn-outline-primary btn-sm mt-auto">
                                    Xem Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
        }

        function increaseQty() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.max);
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
            }
        }

        function decreaseQty() {
            const input = document.getElementById('quantity');
            const current = parseInt(input.value);
            if (current > 1) {
                input.value = current - 1;
            }
        }

        function buyNow() {
            // Set quantity to 1 and submit form for buy now (có thể redirect to checkout)
            document.getElementById('quantity').value = 1;
            document.querySelector('form[action*="cart.add"]').submit();
        }
    </script>
@endsection
