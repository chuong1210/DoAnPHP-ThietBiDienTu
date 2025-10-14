@extends('client.layouts.client')

@section('title', 'Đánh giá sản phẩm - ' . $product->name)

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('client.product.show', $product->slug) }}">{{ $product->name }}</a></li>
            <li class="breadcrumb-item active">Viết đánh giá</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-star text-warning me-2"></i>
                        Viết đánh giá cho {{ $product->name }}
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Product Preview -->
                    <div class="text-center mb-4">
                        @if($product->image)
                            <img src="{{ asset('images/products/' . $product->image) }}" class="img-fluid rounded"
                                alt="{{ $product->name }}" style="max-width: 200px; max-height: 200px;">
                        @else
                            <div class="bg-light d-inline-block p-4 rounded">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        <h5 class="mt-2">{{ $product->name }}</h5>
                        <p class="text-muted">{{ $product->brand->name ?? 'N/A' }}</p>
                    </div>

                    <!-- Review Form -->
                    <form action="{{ route('client.reviews.store', $product->slug) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Điểm đánh giá của bạn <span
                                    class="text-danger">*</span></label>
                            <div class="rating-stars mt-2" id="rating-stars">
                                <i class="far fa-star star" data-rating="1"
                                    style="cursor: pointer; font-size: 1.5rem; color: #dee2e6;"></i>
                                <i class="far fa-star star" data-rating="2"
                                    style="cursor: pointer; font-size: 1.5rem; color: #dee2e6;"></i>
                                <i class="far fa-star star" data-rating="3"
                                    style="cursor: pointer; font-size: 1.5rem; color: #dee2e6;"></i>
                                <i class="far fa-star star" data-rating="4"
                                    style="cursor: pointer; font-size: 1.5rem; color: #dee2e6;"></i>
                                <i class="far fa-star star" data-rating="5"
                                    style="cursor: pointer; font-size: 1.5rem; color: #dee2e6;"></i>
                            </div>
                            <input type="hidden" name="rating" id="rating" value="0" required>
                            <div class="form-text">Chọn số sao để đánh giá sản phẩm (1-5 sao)</div>
                            @error('rating')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Nhận xét của bạn</label>
                            <textarea name="comment" id="comment" rows="5" class="form-control"
                                placeholder="Hãy chia sẻ trải nghiệm của bạn về sản phẩm này... (tùy chọn)">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('client.product.show', $product->slug) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Quay lại sản phẩm
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i> Gửi Đánh Giá
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const rating = this.getAttribute('data-rating');
                    ratingInput.value = rating;

                    // Highlight stars
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.className = 'fas fa-star star text-warning';
                        } else {
                            s.className = 'far fa-star star';
                        }
                    });
                });

                // Hover effect
                star.addEventListener('mouseover', function () {
                    const rating = this.getAttribute('data-rating');
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.className = 'fas fa-star star text-warning';
                        } else {
                            s.className = 'far fa-star star';
                        }
                    });
                });
            });

            // Reset on mouseout
            document.querySelector('.rating-stars').addEventListener('mouseleave', function () {
                const currentRating = ratingInput.value;
                stars.forEach((s, index) => {
                    if (index < currentRating) {
                        s.className = 'fas fa-star star text-warning';
                    } else {
                        s.className = 'far fa-star star';
                    }
                });
            });
        });
    </script>
@endsection