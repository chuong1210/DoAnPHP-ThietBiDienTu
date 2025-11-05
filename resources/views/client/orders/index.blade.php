@extends('client.layouts.client')

@section('title', 'Trang Chủ - Tech Shop')

@section('content')
    <!-- Hero Banner Slider -->
    @if($banners->count() > 0)
        <div id="bannerCarousel" class="carousel slide modern-carousel mb-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($banners as $index => $banner)
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>

            <div class="carousel-inner">
                @foreach($banners as $index => $banner)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="banner-wrapper">
                            <img src="{{ asset('images/banners/' . $banner->image) }}"
                                class="d-block w-100" alt="{{ $banner->title }}">
                            <div class="banner-overlay">
                                <div class="container">
                                    <div class="banner-content">
                                        <span class="banner-badge">Khuyến Mãi Hot</span>
                                        <h1 class="banner-title">{{ $banner->title }}</h1>
                                        <p class="banner-description">Công nghệ tiên tiến, giá tốt nhất</p>
                                        <a href="{{ route('client.product.index') }}" class="btn-banner">
                                            Khám Phá Ngay <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    @endif

    <!-- Features Section -->
    <section class="features-section mb-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Miễn Phí Vận Chuyển</h5>
                            <p>Đơn hàng từ 500.000đ</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Bảo Hành Chính Hãng</h5>
                            <p>Đổi trả trong 7 ngày</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Hỗ Trợ 24/7</h5>
                            <p>Tư vấn nhiệt tình</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Thanh Toán Linh Hoạt</h5>
                            <p>Nhiều phương thức</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="products-section mb-5">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="section-badge">
                        <i class="fas fa-fire"></i> Hot
                    </div>
                    <h2 class="section-title">Sản Phẩm Nổi Bật</h2>
                    <p class="section-subtitle">Những sản phẩm được yêu thích nhất</p>
                </div>
                <a href="{{ route('client.product.index') }}" class="btn-view-all">
                    Xem Tất Cả <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>

            <div class="row g-4">
                @foreach($featuredProducts as $index => $product)
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card" style="animation-delay: {{ $index * 0.1 }}s">
                            @if($product->sale_price)
                                <div class="product-badge sale">
                                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                </div>
                            @endif

                            <div class="product-image-wrapper">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" class="product-image" alt="{{ $product->name }}">
                                @else
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <div class="product-overlay">
                                    <a href="{{ route('client.product.show', $product->slug) }}" class="btn-quick-view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="product-info">
                                <div class="product-brand">{{ $product->brand->name }}</div>
                                <h6 class="product-name">
                                    <a href="{{ route('client.product.show', $product->slug) }}">
                                        {{ Str::limit($product->name, 50) }}
                                    </a>
                                </h6>

                                <div class="product-price">
                                    @if($product->sale_price)
                                        <span class="price-current">{{ number_format($product->sale_price) }}đ</span>
                                        <span class="price-old">{{ number_format($product->price) }}đ</span>
                                    @else
                                        <span class="price-current">{{ number_format($product->price) }}đ</span>
                                    @endif
                                </div>

                                <div class="product-actions">
                                    <a href="{{ route('client.product.show', $product->slug) }}"
                                        class="btn-add-cart">
                                        <i class="fas fa-shopping-cart me-2"></i> Xem Chi Tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- New Products -->
    <section class="products-section mb-5">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="section-badge new">
                        <i class="fas fa-star"></i> New
                    </div>
                    <h2 class="section-title">Sản Phẩm Mới</h2>
                    <p class="section-subtitle">Cập nhật những mẫu mới nhất</p>
                </div>
                <a href="{{ route('client.product.index') }}" class="btn-view-all">
                    Xem Tất Cả <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>

            <div class="row g-4">
                @foreach($newProducts as $index => $product)
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card" style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="product-badge new">New</div>

                            <div class="product-image-wrapper">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" class="product-image" alt="{{ $product->name }}">
                                @else
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <div class="product-overlay">
                                    <a href="{{ route('client.product.show', $product->slug) }}" class="btn-quick-view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="product-info">
                                <div class="product-brand">{{ $product->brand->name }}</div>
                                <h6 class="product-name">
                                    <a href="{{ route('client.product.show', $product->slug) }}">
                                        {{ Str::limit($product->name, 50) }}
                                    </a>
                                </h6>

                                <div class="product-price">
                                    <span class="price-current">{{ number_format($product->final_price) }}đ</span>
                                </div>

                                <div class="product-actions">
                                    <a href="{{ route('client.product.show', $product->slug) }}"
                                        class="btn-add-cart">
                                        <i class="fas fa-shopping-cart me-2"></i> Xem Chi Tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section mb-5">
        <div class="container">
            <div class="newsletter-wrapper">
                <div class="newsletter-content">
                    <div class="newsletter-icon">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <div>
                        <h3>Đăng Ký Nhận Tin</h3>
                        <p>Nhận thông tin ưu đãi và sản phẩm mới nhất</p>
                    </div>
                </div>
                <form class="newsletter-form">
                    <input type="email" class="form-control" placeholder="Nhập email của bạn...">
                    <button type="submit" class="btn-subscribe">
                        <i class="fas fa-paper-plane"></i> Đăng Ký
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

<style>
    :root {
        --primary: #0066FF;
        --secondary: #00B4D8;
        --background: #F8FAFC;
        --text: #1E293B;
        --neutral: #CBD5E1;
    }

    /* Banner Carousel */
    .modern-carousel {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .banner-wrapper {
        position: relative;
        height: 500px;
    }

    .banner-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 102, 255, 0.8), rgba(0, 180, 216, 0.6));
        display: flex;
        align-items: center;
    }

    .banner-content {
        color: white;
        max-width: 600px;
    }

    .banner-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .banner-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .banner-description {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        opacity: 0.95;
    }

    .btn-banner {
        display: inline-flex;
        align-items: center;
        background: white;
        color: var(--primary);
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .btn-banner:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
        color: var(--primary);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        padding: 2rem;
    }

    .carousel-indicators [data-bs-target] {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 6px;
    }

    /* Features Section */
    .feature-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        border: 2px solid var(--neutral);
        transition: all 0.3s ease;
    }

    .feature-card:hover {
        border-color: var(--primary);
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0, 102, 255, 0.15);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .feature-icon i {
        font-size: 2rem;
        color: white;
    }

    .feature-content h5 {
        color: var(--text);
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1.1rem;
    }

    .feature-content p {
        color: #64748B;
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    /* Section Header */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
    }

    .section-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        color: #92400E;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 0.75rem;
        border: 2px solid #FCD34D;
    }

    .section-badge.new {
        background: linear-gradient(135deg, #DBEAFE, #BFDBFE);
        color: #1E40AF;
        border-color: #93C5FD;
    }

    .section-title {
        color: var(--text);
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .section-subtitle {
        color: #64748B;
        font-size: 1.1rem;
    }

    .btn-view-all {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 0.85rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
    }

    .btn-view-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
        color: white;
    }

    /* Product Card */
    .product-card {
        background: white;
        border-radius: 20px;
        border: 2px solid var(--neutral);
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
        from {
            opacity: 0;
            transform: translateY(20px);
        }
    }

    .product-card:hover {
        border-color: var(--primary);
        transform: translateY(-8px);
        box-shadow: 0 16px 40px rgba(0, 102, 255, 0.15);
    }

    .product-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        z-index: 2;
    }

    .product-badge.sale {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: white;
    }

    .product-badge.new {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .product-image-wrapper {
        position: relative;
        height: 280px;
        overflow: hidden;
        background: var(--background);
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

    .product-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral);
    }

    .product-image-placeholder i {
        font-size: 4rem;
    }

    .product-overlay {
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

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .btn-quick-view {
        width: 50px;
        height: 50px;
        background: white;
        color: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        transform: scale(0.8);
    }

    .product-card:hover .btn-quick-view {
        transform: scale(1);
    }

    .btn-quick-view:hover {
        background: var(--primary);
        color: white;
        transform: scale(1.1) rotate(360deg);
    }

    .product-info {
        padding: 1.5rem;
    }

    .product-brand {
        color: #64748B;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .product-name {
        margin-bottom: 1rem;
        min-height: 48px;
    }

    .product-name a {
        color: var(--text);
        text-decoration: none;
        font-weight: 600;
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
    }

    .price-current {
        color: var(--primary);
        font-size: 1.5rem;
        font-weight: 800;
    }

    .price-old {
        color: #94A3B8;
        font-size: 1rem;
        text-decoration: line-through;
    }

    .btn-add-cart {
        width: 100%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 0.85rem;
        border-radius: 12px;
        text-align: center;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
    }

    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
        color: white;
    }

    /* Newsletter */
    .newsletter-wrapper {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 24px;
        padding: 3rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        box-shadow: 0 10px 40px rgba(0, 102, 255, 0.2);
    }

    .newsletter-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        color: white;
    }

    .newsletter-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .newsletter-icon i {
        font-size: 2rem;
    }

    .newsletter-content h3 {
        margin-bottom: 0.25rem;
        font-weight: 700;
    }

    .newsletter-content p {
        margin-bottom: 0;
        opacity: 0.9;
    }

    .newsletter-form {
        display: flex;
        gap: 1rem;
        flex: 1;
        max-width: 500px;
    }

    .newsletter-form .form-control {
        flex: 1;
        border: 2px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        padding: 0.85rem 1.5rem;
        border-radius: 50px;
    }

    .newsletter-form .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .newsletter-form .form-control:focus {
        background: rgba(255, 255, 255, 0.3);
        border-color: white;
        color: white;
        box-shadow: none;
    }

    .btn-subscribe {
        background: white;
        color: var(--primary);
        padding: 0.85rem 2rem;
        border: none;
        border-radius: 50px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-subscribe:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .banner-title {
            font-size: 2.5rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .newsletter-wrapper {
            flex-direction: column;
            text-align: center;
        }

        .newsletter-content {
            flex-direction: column;
        }

        .newsletter-form {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .banner-wrapper {
            height: 350px;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
</style>
