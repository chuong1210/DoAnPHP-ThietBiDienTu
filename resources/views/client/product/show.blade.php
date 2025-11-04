@extends('client.layouts.client')

@section('title', $product->name)

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb modern-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}"><i class="fas fa-home"></i> Trang chủ</a>
            </li>
            <li class="breadcrumb-item"><a
                    href="{{ route('client.product.category.index', $product->category->slug) }}">{{ $product->category->name }}</a>
            </li>
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 50) }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Product Images -->
        <div class="col-lg-5">
            <div class="product-images-section">
                <div class="main-image-wrapper">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" class="main-image" alt="{{ $product->name }}" id="mainImage">
                    @else
                        <div class="image-placeholder">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif

                    @if($product->sale_price)
                        <div class="discount-badge">
                            -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                        </div>
                    @endif
                </div>

                <!-- Gallery Thumbnails -->
                @if(!empty($product->images))
                    <div class="gallery-thumbnails">
                        <div class="thumbnail-item active">
                            <img src="{{ asset($product->image) }}" alt="Main"
                                onclick="changeMainImage('{{ asset($product->image) }}', this)">
                        </div>
                        @foreach($product->images as $image)
                            <div class="thumbnail-item">
                                <img src="{{ asset($image) }}" alt="Gallery" onclick="changeMainImage('{{ asset($image) }}', this)">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-7">
            <div class="product-info-section">
                <!-- Brand -->
                <div class="product-brand">
                    <i class="fas fa-tag"></i>
                    <a href="{{ route('client.brand.index', $product->brand->slug) }}">
                        {{ $product->brand->name }}
                    </a>
                </div>

                <!-- Name -->
                <h1 class="product-title">{{ $product->name }}</h1>

                <!-- Rating & Views -->
                <div class="product-stats">
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $averageRating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span class="rating-score">{{ number_format($averageRating, 1) }}</span>
                        <span class="rating-count">({{ $reviews->total() }} đánh giá)</span>
                    </div>
                    <div class="view-count">
                        <i class="fas fa-eye"></i>
                        <span>{{ number_format($product->view_count) }} lượt xem</span>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Price -->
                <div class="product-pricing">
                    @if($product->sale_price)
                        <div class="price-wrapper sale">
                            <span class="current-price">{{ number_format($product->sale_price) }}đ</span>
                            <span class="original-price">{{ number_format($product->price) }}đ</span>
                        </div>
                    @else
                        <div class="price-wrapper">
                            <span class="current-price">{{ number_format($product->price) }}đ</span>
                        </div>
                    @endif
                </div>

                <!-- Stock Status -->
                <div class="stock-status">
                    <div class="status-label">Tình trạng:</div>
                    @if($product->quantity > 0)
                        <div class="status-badge available">
                            <i class="fas fa-check-circle"></i>
                            Còn {{ $product->quantity }} sản phẩm
                        </div>
                    @else
                        <div class="status-badge unavailable">
                            <i class="fas fa-times-circle"></i>
                            Hết hàng
                        </div>
                    @endif
                </div>

                <div class="divider"></div>

                <!-- Add to Cart Form -->
                @if($product->quantity > 0)
                    <form action="{{ route('client.cart.add', $product->id) }}" method="POST" class="cart-form">
                        @csrf
                        <div class="quantity-selector">
                            <label class="quantity-label">Số lượng:</label>
                            <div class="quantity-input">
                                <button type="button" class="qty-btn minus" onclick="decreaseQty()">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1"
                                    max="{{ $product->quantity }}" readonly>
                                <button type="button" class="qty-btn plus" onclick="increaseQty()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button type="submit" class="btn-add-cart">
                                <i class="fas fa-cart-plus"></i> Thêm Vào Giỏ Hàng
                            </button>
                            <!-- Thay nút cũ -->
                            <button type="button" class="btn-buy-now" onclick="openBuyNowModal()">
                                <i class="fas fa-bolt"></i> Mua Ngay
                            </button>
                        </div>
                    </form>
                @else
                    <div class="out-of-stock-alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Sản phẩm hiện đang hết hàng. Vui lòng quay lại sau!</span>
                    </div>
                @endif

                <!-- Features -->
                <div class="product-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <strong>Bảo hành chính hãng</strong>
                            <span>12 tháng toàn quốc</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="feature-text">
                            <strong>Giao hàng miễn phí</strong>
                            <span>Đơn từ 500.000đ</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-undo"></i>
                        </div>
                        <div class="feature-text">
                            <strong>Đổi trả dễ dàng</strong>
                            <span>Trong vòng 7 ngày</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details & Reviews -->
    <div class="product-details-section">
        <div class="details-card">
            <ul class="nav nav-tabs details-tabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#description">
                        <i class="fas fa-info-circle"></i> Mô Tả Sản Phẩm
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews">
                        <i class="fas fa-star"></i> Đánh Giá <span class="tab-count">({{ $reviews->total() }})</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content details-content">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="description">
                    @if($product->description)
                        <div class="description-content">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    @else
                        <div class="empty-content">
                            <i class="fas fa-file-alt"></i>
                            <p>Chưa có mô tả chi tiết cho sản phẩm này</p>
                        </div>
                    @endif
                </div>

                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews">
                    @if($reviews->count() > 0)
                        <div class="reviews-summary">
                            <div class="summary-score">
                                <div class="score-number">{{ number_format($averageRating, 1) }}</div>
                                <div class="score-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $averageRating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <div class="score-count">{{ $reviews->total() }} đánh giá</div>
                            </div>
                        </div>

                        <div class="reviews-list">
                            @foreach($reviews as $review)
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-avatar">
                                            {{ substr($review->user->full_name, 0, 1) }}
                                        </div>
                                        <div class="reviewer-info">
                                            <strong class="reviewer-name">{{ $review->user->full_name }}</strong>
                                            <div class="review-rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="review-date">
                                            {{ $review->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    @if($review->comment)
                                        <div class="review-comment">
                                            {{ $review->comment }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($reviews->hasPages())
                            <div class="reviews-pagination">
                                {{ $reviews->links() }}
                            </div>
                        @endif
                    @else
                        <div class="empty-content">
                            <i class="fas fa-star"></i>
                            <p>Chưa có đánh giá nào cho sản phẩm này</p>
                        </div>
                    @endif

                    <!-- Add Review Button -->
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
                            <div class="review-action">
                                <a href="{{ route('client.reviews.create', $product->slug) }}" class="btn-write-review">
                                    <i class="fas fa-star me-2"></i> Viết Đánh Giá Của Bạn
                                </a>
                            </div>
                        @elseif($hasReviewed)
                            <div class="review-notice success">
                                <i class="fas fa-check-circle"></i>
                                Bạn đã đánh giá sản phẩm này
                            </div>
                        @endif
                    @else
                        <div class="review-notice info">
                            <i class="fas fa-sign-in-alt"></i>
                            <a href="{{ route('login') }}">Đăng nhập</a> để viết đánh giá
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="related-products-section">
            <h3 class="section-title">
                <i class="fas fa-box-open me-2"></i> Sản Phẩm Liên Quan
            </h3>
            <div class="row g-4">
                @foreach($relatedProducts as $related)
                    <div class="col-lg-3 col-md-6">
                        <div class="related-product-card">
                            <a href="{{ route('client.product.show', $related->slug) }}" class="product-link">
                                <div class="product-image-wrapper">
                                    @if($related->image)
                                        <img src="{{ asset($related->image) }}" alt="{{ $related->name }}" loading="lazy">
                                    @else
                                        <div class="image-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="product-info">
                                    <div class="product-brand-small">{{ $related->brand->name ?? 'N/A' }}</div>
                                    <h6 class="product-name-small">{{ Str::limit($related->name, 50) }}</h6>
                                    <div class="product-price-small">
                                        @if($related->sale_price)
                                            <span class="price-current">{{ number_format($related->sale_price) }}đ</span>
                                            <span class="price-old">{{ number_format($related->price) }}đ</span>
                                        @else
                                            <span class="price-current">{{ number_format($related->price) }}đ</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Buy Now Modal -->
    <div class="modal fade" id="buyNowModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                <!-- Header -->
                <div class="modal-header bg-gradient-primary text-white border-0"
                    style="background: linear-gradient(135deg, #0066FF, #00B4D8); padding: 1.5rem;">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-bolt me-2"></i> Xác nhận mua ngay
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4">
                    <div class="d-flex gap-3 mb-4">
                        <img id="modalImage" src="" alt="" class="rounded-3"
                            style="width: 80px; height: 80px; object-fit: cover; border: 2px solid #e2e8f0;">
                        <div>
                            <h6 id="modalName" class="fw-bold text-text mb-1"></h6>
                            <div id="modalPrice" class="text-primary fw-bold fs-5"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Số lượng:</label>
                        <div class="quantity-input d-flex align-items-center border rounded-3 overflow-hidden"
                            style="width: fit-content;">
                            <button type="button" class="btn qty-btn" onclick="decreaseModalQty()">-</button>
                            <input type="number" id="modalQuantity" value="1" min="1"
                                class="form-control text-center border-0" style="width: 60px;" readonly>
                            <button type="button" class="btn qty-btn" onclick="increaseModalQty()">+</button>
                        </div>
                        <small class="text-muted d-block mt-1">
                            Còn <span id="modalStock"></span> sản phẩm
                        </small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-lg btn-primary fw-bold" onclick="confirmBuyNow()">
                            <i class="fas fa-check me-2"></i> Xác nhận mua ngay
                        </button>
                        <button type="button" class="btn btn-lg btn-outline-secondary" data-bs-dismiss="modal">
                            Hủy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount);
        }
        const buyNowProduct = {
            id: {{ $product->id }},
            name: "{{ $product->name }}",
            image: "{{ asset($product->image) }}",
            price: {{ $product->sale_price ?? $product->price }},
            stock: {{ $product->quantity }}
                                };

        let modalQty = 1;

        function openBuyNowModal() {
            document.getElementById('modalName').textContent = buyNowProduct.name;
            document.getElementById('modalImage').src = buyNowProduct.image;
            document.getElementById('modalPrice').textContent = formatCurrency(buyNowProduct.price) + 'đ';
            document.getElementById('modalStock').textContent = buyNowProduct.stock;
            document.getElementById('modalQuantity').value = 1;
            document.getElementById('modalQuantity').max = buyNowProduct.stock;
            modalQty = 1;
            new bootstrap.Modal(document.getElementById('buyNowModal')).show();
        }

        function increaseModalQty() {
            if (modalQty < buyNowProduct.stock) {
                modalQty++;
                document.getElementById('modalQuantity').value = modalQty;
            }
        }


        function decreaseModalQty() {
            if (modalQty > 1) {
                modalQty--;
                document.getElementById('modalQuantity').value = modalQty;
            }
        }

        function confirmBuyNow() {
            const form = document.createElement('form');
            // DÙNG URL TRỰC TIẾP, KHÔNG DÙNG route()
            form.action = '{{ route("client.cart.add", ":id") }}'.replace(':id', buyNowProduct.id); form.method = 'POST';
            form.style.display = 'none';

            // CSRF
            const csrf = document.createElement('input');
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            // Quantity
            const qty = document.createElement('input');
            qty.name = 'quantity';
            qty.value = modalQty;
            form.appendChild(qty);

            // Buy now flag
            const buyNow = document.createElement('input');
            buyNow.name = 'buy_now';
            buyNow.value = '1';
            form.appendChild(buyNow);

            document.body.appendChild(form);
            form.submit();
        }

        // Các hàm khác giữ nguyên
        function changeMainImage(src, element) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumbnail-item').forEach(item => item.classList.remove('active'));
            element.closest('.thumbnail-item').classList.add('active');
        }

        function increaseQty() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.max);
            const cur = parseInt(input.value);
            if (cur < max) input.value = cur + 1;
        }

        function decreaseQty() {
            const input = document.getElementById('quantity');
            const cur = parseInt(input.value);
            if (cur > 1) input.value = cur - 1;
        }
    </script>
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

    /* Product Images */
    .product-images-section {
        position: sticky;
        top: 120px;
    }

    .main-image-wrapper {
        position: relative;
        background: white;
        border-radius: 20px;
        padding: 2rem;
        border: 2px solid var(--neutral);
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .main-image {
        width: 100%;
        height: auto;
        border-radius: 16px;
        transition: transform 0.3s ease;
    }

    .main-image:hover {
        transform: scale(1.05);
    }

    .image-placeholder {
        width: 100%;
        aspect-ratio: 1;
        background: var(--background);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral);
    }

    .image-placeholder i {
        font-size: 5rem;
    }

    .discount-badge {
        position: absolute;
        top: 2rem;
        right: 2rem;
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 800;
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    /* Gallery Thumbnails */
    .gallery-thumbnails {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 0.75rem;
    }

    .thumbnail-item {
        border: 3px solid var(--neutral);
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
        aspect-ratio: 1;
    }

    .thumbnail-item:hover,
    .thumbnail-item.active {
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
    }

    .thumbnail-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Product Info */
    .product-info-section {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        border: 2px solid var(--neutral);
    }

    .product-brand {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748B;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .product-brand a {
        color: var(--primary);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .product-brand a:hover {
        color: var(--secondary);
    }

    .product-title {
        color: var(--text);
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 1.5rem;
        line-height: 1.3;
    }

    .product-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .rating-stars {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .rating-stars i {
        color: #F59E0B;
        font-size: 1.25rem;
    }

    .rating-score {
        color: var(--text);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .rating-count {
        color: #64748B;
        font-size: 0.95rem;
    }

    .view-count {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748B;
        font-size: 0.95rem;
    }

    .divider {
        height: 2px;
        background: var(--neutral);
        margin: 1.5rem 0;
    }

    .product-pricing {
        margin-bottom: 1.5rem;
    }

    .price-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .current-price {
        color: var(--primary);
        font-size: 2.5rem;
        font-weight: 800;
    }

    .price-wrapper.sale .current-price {
        color: #EF4444;
    }

    .original-price {
        color: #94A3B8;
        font-size: 1.5rem;
        text-decoration: line-through;
    }

    .stock-status {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .status-label {
        color: var(--text);
        font-weight: 700;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.25rem;
        border-radius: 50px;
        font-weight: 700;
    }

    .status-badge.available {
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #065F46;
    }

    .status-badge.unavailable {
        background: linear-gradient(135deg, #FEE2E2, #FECACA);
        color: #991B1B;
    }

    /* Cart Form */
    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .quantity-label {
        color: var(--text);
        font-weight: 700;
        font-size: 1.05rem;
    }

    .quantity-input {
        display: flex;
        align-items: center;
        border: 2px solid var(--neutral);
        border-radius: 12px;
        overflow: hidden;
    }

    .qty-btn {
        width: 45px;
        height: 50px;
        background: var(--background);
        border: none;
        color: var(--text);
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .qty-btn:hover {
        background: var(--primary);
        color: white;
    }

    .quantity-input input {
        width: 80px;
        height: 50px;
        border: none;
        text-align: center;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text);
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-add-cart,
    .btn-buy-now {
        flex: 1;
        padding: 1.25rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.05rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .btn-add-cart {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        box-shadow: 0 6px 20px rgba(0, 102, 255, 0.3);
    }

    .btn-add-cart:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 102, 255, 0.4);
    }

    .btn-buy-now {
        background: linear-gradient(135deg, #F59E0B, #F97316);
        color: white;
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.3);
    }

    .btn-buy-now:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.4);
    }

    .out-of-stock-alert {
        background: linear-gradient(135deg, #FEE2E2, #FECACA);
        color: #991B1B;
        padding: 1.25rem 1.5rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 600;
        border: 2px solid #FCA5A5;
    }

    /* Product Features */
    .product-features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid var(--neutral);
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .feature-icon i {
        font-size: 1.5rem;
        color: white;
    }

    .feature-text {
        display: flex;
        flex-direction: column;
    }

    .feature-text strong {
        color: var(--text);
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .feature-text span {
        color: #64748B;
        font-size: 0.85rem;
    }

    /* Product Details Section */
    .product-details-section {
        margin-top: 3rem;
    }

    .details-card {
        background: white;
        border-radius: 20px;
        border: 2px solid var(--neutral);
        overflow: hidden;
    }

    .details-tabs {
        background: var(--background);
        border: none;
        padding: 1rem 1.5rem 0;
        display: flex;
        gap: 0.5rem;
    }

    .details-tabs .nav-link {
        border: none;
        border-radius: 12px 12px 0 0;
        padding: 1rem 2rem;
        color: #64748B;
        font-weight: 700;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .details-tabs .nav-link:hover {
        background: white;
        color: var(--primary);
    }

    .details-tabs .nav-link.active {
        background: white;
        color: var(--primary);
    }

    .tab-count {
        background: var(--neutral);
        color: var(--text);
        padding: 0.25rem 0.65rem;
        border-radius: 50px;
        font-size: 0.85rem;
        margin-left: 0.25rem;
    }

    .details-tabs .nav-link.active .tab-count {
        background: var(--primary);
        color: white;
    }

    .details-content {
        padding: 2.5rem;
    }

    .description-content {
        color: #475569;
        line-height: 1.8;
        font-size: 1.05rem;
    }

    .empty-content {
        text-align: center;
        padding: 4rem 2rem;
        color: #94A3B8;
    }

    .empty-content i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Reviews */
    .reviews-summary {
        background: var(--background);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .score-number {
        font-size: 4rem;
        font-weight: 800;
        color: var(--primary);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .score-stars i {
        color: #F59E0B;
        font-size: 1.5rem;
        margin: 0 0.25rem;
    }

    .score-count {
        color: #64748B;
        font-size: 1.1rem;
        margin-top: 0.5rem;
    }

    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .review-item {
        background: var(--background);
        border-radius: 16px;
        padding: 1.75rem;
        border: 2px solid var(--neutral);
        transition: all 0.3s ease;
    }

    .review-item:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.1);
    }

    .review-header {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        margin-bottom: 1rem;
    }

    .reviewer-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .reviewer-info {
        flex: 1;
    }

    .reviewer-name {
        color: var(--text);
        font-size: 1.05rem;
        display: block;
        margin-bottom: 0.5rem;
    }

    .review-rating i {
        color: #F59E0B;
        font-size: 1rem;
    }

    .review-date {
        color: #94A3B8;
        font-size: 0.9rem;
    }

    .review-comment {
        color: #475569;
        line-height: 1.7;
        font-size: 1rem;
    }

    .reviews-pagination {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .review-action {
        text-align: center;
        margin-top: 2rem;
    }

    .btn-write-review {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(0, 102, 255, 0.3);
    }

    .btn-write-review:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 102, 255, 0.4);
        color: white;
    }

    .review-notice {
        text-align: center;
        padding: 1.25rem 1.5rem;
        border-radius: 12px;
        margin-top: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        font-weight: 600;
    }

    .review-notice.success {
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #065F46;
        border: 2px solid #A7F3D0;
    }

    .review-notice.info {
        background: linear-gradient(135deg, #DBEAFE, #BFDBFE);
        color: #1E40AF;
        border: 2px solid #BFDBFE;
    }

    .review-notice a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 700;
    }

    /* Related Products */
    .related-products-section {
        margin-top: 4rem;
    }

    .section-title {
        color: var(--text);
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
    }

    .section-title i {
        color: var(--primary);
    }

    .related-product-card {
        background: white;
        border-radius: 20px;
        border: 2px solid var(--neutral);
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }

    .related-product-card:hover {
        border-color: var(--primary);
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0, 102, 255, 0.15);
    }

    .product-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .product-image-wrapper {
        position: relative;
        height: 250px;
        background: var(--background);
        overflow: hidden;
    }

    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .related-product-card:hover .product-image-wrapper img {
        transform: scale(1.1);
    }

    .product-image-wrapper .image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral);
    }

    .product-image-wrapper .image-placeholder i {
        font-size: 3rem;
    }

    .related-product-card .product-info {
        padding: 1.5rem;
    }

    .product-brand-small {
        color: #64748B;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .product-name-small {
        color: var(--text);
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 1rem;
        min-height: 48px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-price-small {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .product-price-small .price-current {
        color: var(--primary);
        font-size: 1.35rem;
        font-weight: 800;
    }

    .product-price-small .price-old {
        color: #94A3B8;
        font-size: 1rem;
        text-decoration: line-through;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .product-images-section {
            position: static;
        }

        .product-title {
            font-size: 1.75rem;
        }

        .current-price {
            font-size: 2rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-add-cart,
        .btn-buy-now {
            width: 100%;
        }

        .product-features {
            grid-template-columns: 1fr;
        }

        .details-tabs {
            padding: 0.75rem 1rem 0;
        }

        .details-tabs .nav-link {
            padding: 0.85rem 1.25rem;
            font-size: 0.95rem;
        }

        .details-content {
            padding: 1.75rem;
        }
    }

    @media (max-width: 768px) {
        .product-info-section {
            padding: 1.75rem;
        }

        .product-title {
            font-size: 1.5rem;
        }

        .product-stats {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .current-price {
            font-size: 1.75rem;
        }

        .quantity-selector {
            flex-direction: column;
            align-items: flex-start;
        }

        .gallery-thumbnails {
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
        }

        .score-number {
            font-size: 3rem;
        }

        .review-header {
            flex-wrap: wrap;
        }

        .reviewer-avatar {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .section-title {
            font-size: 1.5rem;
        }
    }
</style>