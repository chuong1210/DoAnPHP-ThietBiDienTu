@extends('client.layouts.client')

@section('title', 'Đánh Giá Của Tôi')
@php
    $hideSidebar = true;
@endphp
@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb modern-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}"><i class="fas fa-home"></i> Trang chủ</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('client.profile.index') }}">Hồ sơ</a></li>
            <li class="breadcrumb-item active">Đánh Giá Của Tôi</li>
        </ol>
    </nav>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="header-content">
                        <div class="icon-wrapper">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <h2 class="mb-1">Đánh Giá Của Tôi</h2>
                            <p class="text-muted mb-0">Quản lý các đánh giá sản phẩm bạn đã viết</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="stats-box">
                        <div class="stat-item">
                            <div class="stat-number">{{ $reviews->total() }}</div>
                            <div class="stat-label">Tổng đánh giá</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <button class="filter-tab {{ !request('status') ? 'active' : '' }}" data-status="all"
                onclick="filterReviews('all')">
                <i class="fas fa-list"></i>
                <span>Tất cả</span>
                <span class="badge">{{ $reviews->total() }}</span>
            </button>
            <button class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}" data-status="pending"
                onclick="filterReviews('pending')">
                <i class="fas fa-clock"></i>
                <span>Chờ duyệt</span>
                <span class="badge">{{ $reviews->where('status', 'pending')->count() }}</span>
            </button>
            <button class="filter-tab {{ request('status') == 'approved' ? 'active' : '' }}" data-status="approved"
                onclick="filterReviews('approved')">
                <i class="fas fa-check-circle"></i>
                <span>Đã duyệt</span>
                <span class="badge">{{ $reviews->where('status', 'approved')->count() }}</span>
            </button>
            <button class="filter-tab {{ request('status') == 'rejected' ? 'active' : '' }}" data-status="rejected"
                onclick="filterReviews('rejected')">
                <i class="fas fa-times-circle"></i>
                <span>Từ chối</span>
                <span class="badge">{{ $reviews->where('status', 'rejected')->count() }}</span>
            </button>
        </div>
        <!-- Reviews List -->
        @if($reviews->count() > 0)
            <div class="reviews-grid">
                @foreach($reviews as $review)
                    <div class="review-card">
                        <!-- Product Info -->
                        <div class="review-product-section">
                            <a href="{{ route('client.product.show', $review->product->slug) }}" class="product-link">
                                <div class="product-image-wrapper">
                                    @if($review->product->image)
                                        <img src="{{ asset($review->product->image) }}" alt="{{ $review->product->name }}">
                                    @else
                                        <div class="image-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="product-info">
                                    <h6 class="product-name">{{ Str::limit($review->product->name, 60) }}</h6>
                                    <div class="product-brand">{{ $review->product->brand->name }}</div>
                                </div>
                            </a>
                        </div>

                        <!-- Review Content -->
                        <div class="review-content-section">
                            <!-- Rating & Date -->
                            <div class="review-header">
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                    <span class="rating-number">{{ $review->rating }}/5</span>
                                </div>
                                <div class="review-date">
                                    <i class="far fa-calendar"></i>
                                    {{ $review->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>

                            <!-- Comment -->
                            @if($review->comment)
                                <div class="review-comment">
                                    <p>{{ $review->comment }}</p>
                                </div>
                            @else
                                <div class="no-comment">
                                    <i class="fas fa-info-circle"></i> Không có nhận xét
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="review-status">
                                @if($review->status === 'pending')
                                    <span class="status-badge pending">
                                        <i class="fas fa-clock"></i> Chờ duyệt
                                    </span>
                                @elseif($review->status === 'approved')
                                    <span class="status-badge approved">
                                        <i class="fas fa-check-circle"></i> Đã duyệt
                                    </span>
                                @else
                                    <span class="status-badge rejected">
                                        <i class="fas fa-times-circle"></i> Từ chối
                                    </span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="review-actions">
                                <a href="{{ route('client.product.show', $review->product->slug) }}" class="btn-action view">
                                    <i class="fas fa-eye"></i> Xem sản phẩm
                                </a>
                                @if($review->status === 'pending')
                                    <button type="button" class="btn-action edit"
                                        onclick="editReview({{ $review->id }}, {{ $review->rating }}, '{{ addslashes($review->comment) }}')">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <button type="button" class="btn-action delete" onclick="deleteReview({{ $review->id }})">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($reviews->hasPages())
                <div class="pagination-wrapper">
                    {{ $reviews->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3>Chưa Có Đánh Giá Nào</h3>
                <p>Bạn chưa đánh giá sản phẩm nào. Hãy mua sắm và chia sẻ trải nghiệm của bạn!</p>
                <a href="{{ route('client.product.index') }}" class="btn-empty-action">
                    <i class="fas fa-shopping-cart me-2"></i> Mua Sắm Ngay
                </a>
            </div>
        @endif
    </div>

    <!-- Edit Review Modal -->
    <div class="modal fade" id="editReviewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modern-modal">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i> Chỉnh Sửa Đánh Giá
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editReviewForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-star text-warning me-1"></i> Đánh giá của bạn
                            </label>
                            <div class="star-rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" id="edit_star{{ $i }}" value="{{ $i }}" required>
                                    <label for="edit_star{{ $i }}">
                                        <i class="fas fa-star"></i>
                                    </label>
                                @endfor
                            </div>
                        </div>

                        <!-- Comment -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-comment me-1"></i> Nhận xét (tùy chọn)
                            </label>
                            <textarea class="form-control" name="comment" id="edit_comment" rows="4"
                                placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..." maxlength="1000"></textarea>
                            <div class="form-text">Tối đa 1000 ký tự</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Hủy
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Cập Nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteReviewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modern-modal">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-exclamation-triangle me-2"></i> Xác Nhận Xóa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="deleteReviewForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Bạn có chắc chắn muốn xóa đánh giá này? Hành động này không thể hoàn tác!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Hủy
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i> Xóa Đánh Giá
                        </button>
                    </div>
                </form>
            </div>
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

    /* Page Header */
    .page-header {
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
        background: linear-gradient(135deg, var(--warning), #F97316);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 16px rgba(245, 158, 11, 0.3);
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

    .stats-box {
        background: linear-gradient(135deg, var(--warning), #F97316);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        color: white;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.95rem;
        opacity: 0.95;
    }

    /* Filter Tabs */
    .filter-tabs {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid var(--neutral);
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: center;
    }

    .filter-tab {
        background: var(--background);
        border: 2px solid var(--neutral);
        color: var(--text);
        padding: 0.85rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .filter-tab i {
        font-size: 1.1rem;
    }

    .filter-tab .badge {
        background: var(--neutral);
        color: var(--text);
        padding: 0.25rem 0.6rem;
        border-radius: 12px;
        font-size: 0.8rem;
    }

    .filter-tab.active {
        background: linear-gradient(135deg, var(--warning), #F97316);
        color: white;
        border-color: transparent;
        box-shadow: 0 6px 16px rgba(245, 158, 11, 0.3);
        transform: translateY(-2px);
    }

    .filter-tab.active .badge {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }

    .filter-tab:hover:not(.active) {
        border-color: var(--warning);
        background: white;
        transform: translateY(-2px);
    }

    /* Reviews Grid */
    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
        gap: 2rem;
    }

    .review-card {
        background: white;
        border-radius: 20px;
        border: 2px solid var(--neutral);
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.6s ease;
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

    .review-card:hover {
        border-color: var(--warning);
        box-shadow: 0 12px 32px rgba(245, 158, 11, 0.15);
        transform: translateY(-4px);
    }

    /* Product Section */
    .review-product-section {
        background: var(--background);
        padding: 1.5rem;
        border-bottom: 2px solid var(--neutral);
    }

    .product-link {
        display: flex;
        gap: 1.25rem;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
    }

    .product-link:hover {
        opacity: 0.8;
    }

    .product-image-wrapper {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        border: 2px solid white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-link:hover .product-image-wrapper img {
        transform: scale(1.1);
    }

    .image-placeholder {
        width: 100%;
        height: 100%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral);
    }

    .image-placeholder i {
        font-size: 2rem;
    }

    .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .product-name {
        color: var(--text);
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .product-brand {
        color: #64748B;
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* Review Content */
    .review-content-section {
        padding: 1.75rem;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .rating-stars {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .rating-stars i {
        color: var(--warning);
        font-size: 1.25rem;
    }

    .rating-number {
        color: var(--text);
        font-weight: 700;
        font-size: 1.1rem;
        margin-left: 0.5rem;
    }

    .review-date {
        color: #64748B;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .review-comment {
        background: var(--background);
        padding: 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.25rem;
        border: 2px solid var(--neutral);
    }

    .review-comment p {
        color: #475569;
        line-height: 1.7;
        margin: 0;
    }

    .no-comment {
        color: #94A3B8;
        font-style: italic;
        padding: 1rem;
        text-align: center;
        background: var(--background);
        border-radius: 12px;
        margin-bottom: 1.25rem;
    }

    /* Status Badge */
    .review-status {
        margin-bottom: 1.25rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.25rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .status-badge.pending {
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        color: #92400E;
    }

    .status-badge.approved {
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #065F46;
    }

    .status-badge.rejected {
        background: linear-gradient(135deg, #FEE2E2, #FECACA);
        color: #991B1B;
    }

    /* Actions */
    .review-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .btn-action {
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 2px solid;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-action.view {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
    }

    .btn-action.view:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 102, 255, 0.4);
        color: white;
    }

    .btn-action.edit {
        background: white;
        color: var(--warning);
        border-color: var(--warning);
    }

    .btn-action.edit:hover {
        background: var(--warning);
        color: white;
        transform: translateY(-2px);
    }

    .btn-action.delete {
        background: white;
        color: var(--danger);
        border-color: var(--danger);
    }

    .btn-action.delete:hover {
        background: var(--danger);
        color: white;
        transform: translateY(-2px);
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
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-icon i {
        font-size: 4rem;
        color: var(--warning);
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

    .btn-empty-action {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(0, 102, 255, 0.3);
    }

    .btn-empty-action:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 102, 255, 0.4);
        color: white;
    }

    /* Modal */
    .modern-modal {
        border-radius: 20px;
        border: none;
        overflow: hidden;
    }

    .modern-modal .modal-header {
        background: linear-gradient(135deg, var(--warning), #F97316);
        color: white;
        border: none;
        padding: 1.5rem;
    }

    .modern-modal .modal-header.bg-danger {
        background: linear-gradient(135deg, var(--danger), #DC2626) !important;
    }

    .modern-modal .modal-body {
        padding: 2rem;
    }

    .modern-modal .form-control {
        border: 2px solid var(--neutral);
        border-radius: 12px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .modern-modal .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1);
    }

    /* Star Rating Input */
    .star-rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 0.5rem;
    }

    .star-rating-input input {
        display: none;
    }

    .star-rating-input label {
        cursor: pointer;
        font-size: 2.5rem;
        color: var(--neutral);
        transition: all 0.3s ease;
        margin: 0;
    }

    .star-rating-input label:hover,
    .star-rating-input label:hover~label,
    .star-rating-input input:checked~label {
        color: var(--warning);
        transform: scale(1.1);
    }

    .modern-modal .modal-footer {
        padding: 1.5rem;
        border-top: 2px solid var(--neutral);
    }

    .modern-modal .btn {
        padding: 0.85rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .modern-modal .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
    }

    .modern-modal .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 102, 255, 0.4);
    }

    .modern-modal .btn-secondary {
        background: var(--background);
        border: 2px solid var(--neutral);
        color: var(--text);
    }

    .modern-modal .btn-secondary:hover {
        border-color: var(--primary);
        background: white;
    }

    .modern-modal .btn-danger {
        background: var(--danger);
        border: none;
    }

    .modern-modal .btn-danger:hover {
        background: #DC2626;
        transform: translateY(-2px);
    }

    .modern-modal .alert-warning {
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        color: #92400E;
        border: 2px solid #FCD34D;
        border-radius: 12px;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .reviews-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            padding: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            text-align: center;
        }

        .filter-tabs {
            flex-direction: column;
        }

        .filter-tab {
            width: 100%;
            justify-content: center;
        }

        .review-product-section {
            padding: 1.25rem;
        }

        .product-link {
            flex-direction: column;
            text-align: center;
        }

        .product-image-wrapper {
            width: 100%;
            height: 200px;
        }

        .review-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .review-actions {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>

@section('scripts')
    <script>
        function filterReviews(status) {
            if (status === 'all') {
                window.location.href = '{{ route("client.profile.reviews") }}';
            } else {
                window.location.href = '{{ route("client.profile.reviews") }}?status=' + status;
            }
        }

        function editReview(reviewId, rating, comment) {
            document.getElementById('editReviewForm').action = '/reviews/' + reviewId;

            // Set rating
            const ratingInput = document.querySelector(`#edit_star${rating}`);
            if (ratingInput) {
                ratingInput.checked = true;
            }

            // Set comment
            document.getElementById('edit_comment').value = comment || '';

            const modal = new bootstrap.Modal(document.getElementById('editReviewModal'));
            modal.show();
        }

        function deleteReview(reviewId) {
            document.getElementById('deleteReviewForm').action = '/reviews/' + reviewId;

            const modal = new bootstrap.Modal(document.getElementById('deleteReviewModal'));
            modal.show();
        }
    </script>
@endsection
