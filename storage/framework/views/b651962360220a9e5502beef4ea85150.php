<?php $__env->startSection('title', 'Đánh giá sản phẩm - ' . $product->name); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* Sử dụng biến màu "Tech Blue Pro" */
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --background: #F8FAFC;
            --text: #1E293B;
            --neutral: #CBD5E1;
            --warning: #F59E0B;
            --font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--background);
            font-family: var(--font-family);
        }

        .review-container {
            max-width: 800px;
            margin: 2rem auto;
        }

        .review-card {
            background-color: white;
            border: 1px solid var(--neutral);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 102, 255, 0.08);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .review-card-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 1.5rem 2rem;
            color: white;
        }

        .review-card-header h4 {
            font-weight: 700;
            margin: 0;
            font-size: 1.5rem;
        }

        .review-card-body {
            padding: 2rem;
        }

        /* Product Preview */
        .product-preview {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem;
            background-color: var(--background);
            border-radius: 16px;
            margin-bottom: 2rem;
            border: 1px solid var(--neutral);
        }

        .product-preview-image {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            object-fit: contain;
            background-color: white;
            flex-shrink: 0;
            padding: 5px;
        }

        .product-preview-info h5 {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.25rem;
        }

        .product-preview-info p {
            color: #64748B;
            margin: 0;
        }

        /* Rating Stars */
        .rating-stars-wrapper {
            margin-bottom: 2rem;
        }

        .rating-stars-wrapper .form-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.75rem;
        }

        .rating-stars {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .rating-stars .star {
            font-size: 2.25rem;
            cursor: pointer;
            color: var(--neutral);
            transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275), color 0.2s ease;
        }

        .rating-stars .star:hover {
            transform: scale(1.2);
        }

        .rating-stars .star.hover,
        .rating-stars .star.selected {
            color: var(--warning);
        }

        #rating-feedback {
            margin-left: 1.5rem;
            font-weight: 600;
            color: var(--text);
            font-size: 1.1rem;
            transition: opacity 0.3s;
        }

        /* Form Controls */
        .form-control {
            border: 2px solid var(--neutral);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--background);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1);
            background-color: white;
            outline: none;
        }

        /* Buttons */
        .btn-modern {
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-primary.btn-modern {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3);
        }

        .btn-primary.btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 102, 255, 0.4);
        }

        .btn-secondary.btn-modern {
            background-color: white;
            color: var(--text);
            border: 2px solid var(--neutral);
        }

        .btn-secondary.btn-modern:hover {
            border-color: var(--primary);
            background-color: var(--background);
            transform: translateY(-2px);
        }

        /* Breadcrumb */
        .breadcrumb {
            padding: 0.75rem 1rem;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-item.active {
            color: var(--text);
            font-weight: 600;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="review-container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('client.home.index')); ?>">Trang chủ</a></li>
                <li class="breadcrumb-item"><a
                        href="<?php echo e(route('client.product.show', $product->slug)); ?>"><?php echo e(Str::limit($product->name, 30)); ?></a>
                </li>
                <li class="breadcrumb-item active">Viết đánh giá</li>
            </ol>
        </nav>

        <div class="review-card">
            <div class="review-card-header">
                <h4 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Chia sẻ trải nghiệm của bạn
                </h4>
            </div>
            <div class="review-card-body">
                <!-- Product Preview -->
                <div class="product-preview">
                    <img src="<?php echo e(asset($product->image ?? 'placeholder.jpg')); ?>" class="product-preview-image"
                        alt="<?php echo e($product->name); ?>">
                    <div class="product-preview-info">
                        <h5 class="mb-1"><?php echo e($product->name); ?></h5>
                        <p class="text-muted"><?php echo e($product->brand->name ?? 'Thương hiệu chưa xác định'); ?></p>
                    </div>
                </div>

                <!-- Review Form -->
                <form action="<?php echo e(route('client.reviews.store', $product->slug)); ?>" method="POST" id="reviewForm">
                    <?php echo csrf_field(); ?>
                    <!-- Rating Stars -->
                    <div class="rating-stars-wrapper">
                        <label class="form-label">Bạn đánh giá sản phẩm này thế nào? <span
                                class="text-danger">*</span></label>
                        <div class="d-flex align-items-center">
                            <div class="rating-stars" id="rating-stars">
                                <i class="far fa-star star" data-rating="1" title="Rất tệ"></i>
                                <i class="far fa-star star" data-rating="2" title="Tệ"></i>
                                <i class="far fa-star star" data-rating="3" title="Bình thường"></i>
                                <i class="far fa-star star" data-rating="4" title="Tốt"></i>
                                <i class="far fa-star star" data-rating="5" title="Rất tốt"></i>
                            </div>
                            <span id="rating-feedback"></span>
                        </div>
                        <input type="hidden" name="rating" id="rating" value="<?php echo e(old('rating', 0)); ?>">
                        <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Comment Textarea -->
                    <div class="mb-4">
                        <label for="comment" class="form-label fw-bold">Nhận xét chi tiết (tùy chọn)</label>
                        <textarea name="comment" id="comment" rows="5"
                            class="form-control <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Sản phẩm dùng có tốt không? Bạn thích hay không thích điểm gì?"><?php echo e(old('comment')); ?></textarea>
                        <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?php echo e(route('client.product.show', $product->slug)); ?>" class="btn-modern btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Quay lại
                        </a>
                        <button type="submit" class="btn-modern btn-primary">
                            <i class="fas fa-paper-plane me-2"></i> Gửi Đánh Giá
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const starsContainer = document.getElementById('rating-stars');
            const stars = starsContainer.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');
            const ratingFeedback = document.getElementById('rating-feedback');
            const reviewForm = document.getElementById('reviewForm');

            const feedbackMessages = {
                0: '',
                1: 'Rất tệ',
                2: 'Tệ',
                3: 'Bình thường',
                4: 'Tốt',
                5: 'Rất tốt!'
            };

            // Hàm cập nhật giao diện sao và feedback
            function updateStars(rating) {
                stars.forEach(star => {
                    const starRating = parseInt(star.getAttribute('data-rating'));
                    if (starRating <= rating) {
                        star.classList.remove('far');
                        star.classList.add('fas', 'selected');
                    } else {
                        star.classList.remove('fas', 'selected');
                        star.classList.add('far');
                    }
                });
                ratingFeedback.textContent = feedbackMessages[rating] || '';
            }

            // Xử lý hover
            starsContainer.addEventListener('mouseover', function (e) {
                if (e.target.classList.contains('star')) {
                    const rating = e.target.getAttribute('data-rating');
                    stars.forEach(star => {
                        star.classList.remove('hover');
                        if (parseInt(star.getAttribute('data-rating')) <= rating) {
                            star.classList.add('hover');
                        }
                    });
                }
            });

            // Reset hover khi chuột rời khỏi
            starsContainer.addEventListener('mouseleave', function () {
                stars.forEach(star => star.classList.remove('hover'));
                // Phục hồi lại trạng thái đã chọn
                updateStars(ratingInput.value);
            });

            // Xử lý click
            starsContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('star')) {
                    const rating = e.target.getAttribute('data-rating');
                    ratingInput.value = rating;
                    updateStars(rating);
                }
            });

            // Khởi tạo trạng thái ban đầu nếu có old('rating')
            if (ratingInput.value > 0) {
                updateStars(ratingInput.value);
            }

            // Validate trước khi submit
            reviewForm.addEventListener('submit', function (e) {
                if (ratingInput.value === '0' || !ratingInput.value) {
                    e.preventDefault();
                    alert('Vui lòng chọn số sao để đánh giá sản phẩm.');
                    // Thêm hiệu ứng rung cho phần rating để thu hút sự chú ý
                    starsContainer.parentElement.style.animation = 'shake 0.5s';
                    setTimeout(() => {
                        starsContainer.parentElement.style.animation = '';
                    }, 500);
                }
            });
        });
    </script>
    <style>
        @keyframes shake {

            10%,
            90% {
                transform: translate3d(-1px, 0, 0);
            }

            20%,
            80% {
                transform: translate3d(2px, 0, 0);
            }

            30%,
            50%,
            70% {
                transform: translate3d(-4px, 0, 0);
            }

            40%,
            60% {
                transform: translate3d(4px, 0, 0);
            }
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client.layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/client/reviews/create.blade.php ENDPATH**/ ?>