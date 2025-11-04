@extends('client.layouts.client')

@section('title', 'Tìm kiếm: ' . $keyword)

@section('styles')
    {{-- Thêm CSS riêng cho trang này để không ảnh hưởng các trang khác --}}
    <style>
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --background: #F8FAFC;
            --text: #1E293B;
            --neutral: #CBD5E1;
            --danger: #EF4444;
            --success: #10B981;
        }

        /* Search Header */
        .search-header {
            background-color: white;
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2.5rem;
            border: 1px solid var(--neutral);
            box-shadow: 0 8px 30px rgba(0, 102, 255, 0.05);
            text-align: center;
        }

        .search-header .icon-wrapper {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
        }

        /* Product Card Redesign */
        .product-card {
            background-color: white;
            border: 1px solid var(--neutral);
            border-radius: 18px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 102, 255, 0.1);
            border-color: var(--primary);
        }

        .product-card .img-container {
            position: relative;
            overflow: hidden;
            background-color: var(--background);
        }

        .product-card .product-image {
            height: 250px;
            width: 100%;
            object-fit: contain;
            /* 'contain' để không bị cắt xén sản phẩm */
            padding: 1rem;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.08);
        }

        .product-card .card-body {
            padding: 1.25rem;
        }

        .product-card .brand-name {
            color: #94A3B8;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .product-card .card-title a {
            color: var(--text);
            font-weight: 600;
            font-size: 1rem;
            line-height: 1.4;
            transition: color 0.2s;
        }

        .product-card .card-title a:hover {
            color: var(--primary);
        }

        .product-card .price-section .current-price {
            font-weight: 700;
            color: var(--primary);
        }

        .product-card .price-section .old-price {
            text-decoration: line-through;
            color: #94A3B8;
            margin-left: 0.5rem;
        }

        .product-card .btn-view-detail {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 0.6rem 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
        }

        .product-card .btn-view-detail:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
        }

        /* No Result Card */
        .no-result-card {
            background-color: white;
            border: 1px solid var(--neutral);
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 102, 255, 0.05);
        }

        .no-result-card .suggestion-badge {
            background-color: var(--background);
            color: var(--text);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            border: 1px solid var(--neutral);
            transition: all 0.2s ease;
        }

        .no-result-card .suggestion-badge:hover {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Pagination */
        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .pagination .page-link {
            color: var(--primary);
        }

        .pagination .page-link:hover {
            color: var(--secondary);
        }
    </style>
@endsection

@section('content')
    <div class="search-header">
        <div class="icon-wrapper">
            <i class="fas fa-search"></i>
        </div>
        <h3 class="mb-1" style="color: var(--text);">
            Kết quả tìm kiếm cho từ khóa:
        </h3>
        <h2 class="text-primary mb-3">"{{ $keyword }}"</h2>
        <p class="text-muted mb-0">Tìm thấy <strong class="text-success">{{ $products->total() }}</strong> sản phẩm phù hợp
        </p>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card h-100">
                        <div class="img-container">
                            <a href="{{ route('client.product.show', $product->slug) }}">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" class="product-image" alt="{{ $product->name }}">
                                @else
                                    <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </a>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <p class="brand-name mb-1">{{ $product->brand->name }}</p>
                            <h6 class="card-title grow">
                                <a href="{{ route('client.product.show', $product->slug) }}" class="text-decoration-none">
                                    {{ Str::limit($product->name, 50) }}
                                </a>
                            </h6>

                            <div class="price-section my-3">
                                @if($product->sale_price)
                                    <span class="h5 current-price text-danger mb-0">{{ number_format($product->sale_price) }}đ</span>
                                    <span class="small old-price">{{ number_format($product->price) }}đ</span>
                                @else
                                    <span class="h5 current-price mb-0">{{ number_format($product->price) }}đ</span>
                                @endif
                            </div>

                            <a href="{{ route('client.product.show', $product->slug) }}" class="btn btn-view-detail w-100 mt-auto">
                                <i class="fas fa-eye me-2"></i> Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->appends(['q' => $keyword])->links() }}
        </div>

    @else
        <div class="no-result-card">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <img src="https://i.imgur.com/e1YxP38.png" alt="No results found" style="width: 150px;">
                </div>

                <h4 style="color: var(--text); font-weight: 600;">Không tìm thấy sản phẩm nào</h4>
                <p class="text-muted mb-4">Chúng tôi không thể tìm thấy sản phẩm nào khớp với từ khóa của bạn. <br>Vui lòng thử
                    lại với từ khóa khác.</p>

                <div class="mt-4">
                    <h6 class="mb-3" style="color: var(--text);">Gợi ý tìm kiếm phổ biến:</h6>
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <a href="{{ route('client.search', ['q' => 'iPhone 15']) }}"
                            class="suggestion-badge text-decoration-none">iPhone 15</a>
                        <a href="{{ route('client.search', ['q' => 'Samsung Galaxy']) }}"
                            class="suggestion-badge text-decoration-none">Samsung Galaxy</a>
                        <a href="{{ route('client.search', ['q' => 'Laptop Dell']) }}"
                            class="suggestion-badge text-decoration-none">Laptop Dell</a>
                        <a href="{{ route('client.search', ['q' => 'Tai nghe Sony']) }}"
                            class="suggestion-badge text-decoration-none">Tai nghe Sony</a>
                    </div>
                </div>

                <a href="{{ route('client.product.all') }}" class="btn btn-view-detail mt-4">
                    <i class="fas fa-shopping-bag me-2"></i> Xem Tất Cả Sản Phẩm
                </a>
            </div>
        </div>
    @endif
@endsection