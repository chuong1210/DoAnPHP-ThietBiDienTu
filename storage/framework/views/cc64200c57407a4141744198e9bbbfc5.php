<?php $__env->startSection('title', 'Thanh Toán'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --bg: #F8FAFC;
            --text: #1E293B;
            --neutral: #CBD5E1;
            --danger: #EF4444;
        }

        .checkout-step {
            position: relative;
            padding: 1.5rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            border: 1px solid var(--neutral);
            transition: all 0.3s ease;
        }

        .checkout-step:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            border-color: var(--primary);
        }

        .step-number {
            position: absolute;
            top: -10px;
            left: 1.5rem;
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
        }

        .payment-method {
            border: 2px solid var(--neutral);
            border-radius: 12px;
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .payment-method:hover {
            border-color: var(--primary);
            background: var(--bg);
            transform: translateY(-2px);
        }

        .payment-method.active {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(0, 102, 255, 0.08), rgba(0, 180, 216, 0.08));
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.15);
        }

        .order-summary {
            position: sticky;
            top: 20px;
        }

        .coupon-badge {
            background: linear-gradient(135deg, var(--danger), #DC2626);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .voucher-item {
            border: 2px dashed var(--neutral);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .voucher-item:hover {
            border-color: var(--primary);
            background: var(--bg);
            transform: translateX(4px);
        }

        .voucher-item.active {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(0, 102, 255, 0.08), rgba(0, 180, 216, 0.08));
        }

        .progress-bar {
            background: var(--neutral);
            height: 6px;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            width: 66%;
            /* Step 2/3 */
            transition: width 0.4s ease;
        }

        /* Modern Form Controls */
        .form-control,
        .form-select {
            border: 2px solid var(--neutral);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1);
            outline: none;
        }

        .btn-modern {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
        }

        /* Loading Spinner */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid var(--neutral);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        \Log::info('Available coupons:', [$availablecoupons ?? null]);
    ?>
    <div class="container py-5">
        <hr class="my-3" id="discount-hr">

        <!-- Dòng giảm giá sẽ được JS chèn vào -->
        <div id="discount-row" class="d-flex justify-content-between mb-2 text-success" style="display: none;">
            <span class="fw-semibold">Giảm giá:</span>
            <strong id="discount" class="text-success">-0đ</strong>
        </div>

        <hr class="my-3">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white rounded-3 p-3 shadow-sm">
                <li class="breadcrumb-item"><a href="<?php echo e(route('client.home.index')); ?>" class="text-primary"><i
                            class="fas fa-home me-1"></i> Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('client.cart.index')); ?>" class="text-primary">Giỏ hàng</a>
                </li>
                <li class="breadcrumb-item active text-text" aria-current="page">Thanh toán</li>
            </ol>
        </nav>

        <!-- Progress Bar -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <div class="d-flex justify-content-between position-relative" style="z-index: 1;">
                    <div class="text-center flex-1">
                        <div class="bg-success text-white rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <small class="text-success fw-bold">Giỏ Hàng</small>
                    </div>
                    <div class="text-center flex-1">
                        <div class="bg-primary text-white rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <small class="text-primary fw-bold">Thanh Toán</small>
                    </div>
                    <div class="text-center flex-1">
                        <div class="bg-secondary text-white rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="fas fa-check"></i>
                        </div>
                        <small class="text-muted">Hoàn Thành</small>
                    </div>
                </div>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0">
                <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0">
                <i class="fas fa-exclamation-circle me-2"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('client.checkout.process')); ?>" method="POST" id="checkoutForm">
            <?php echo csrf_field(); ?>
            
            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($err); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <div class="row">
                <!-- Left Column - Checkout Steps -->
                <div class="col-lg-8">
                    <!-- Step 1: Thông tin giao hàng -->
                    <div class="checkout-step">
                        <div class="step-number">1</div>
                        <h5 class="mb-4 mt-2 text-text fw-bold">Thông Tin Giao Hàng</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-text">Họ và tên <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="customer_name"
                                    class="form-control <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('customer_name', Auth::user()->full_name ?? '')); ?>" required>
                                <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-text">Số điện thoại <span
                                        class="text-danger">*</span></label>
                                <input type="tel" name="customer_phone"
                                    class="form-control <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('customer_phone', Auth::user()->phone ?? '')); ?>" required>
                                <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-text">Email</label>
                                <input type="email" name="customer_email"
                                    class="form-control <?php $__errorArgs = ['customer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('customer_email', Auth::user()->email ?? '')); ?>">
                                <?php $__errorArgs = ['customer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Tỉnh/Thành phố -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-text">Tỉnh/Thành phố <span
                                        class="text-danger">*</span></label>
                                <select name="shipping_province" id="provinceSelect"
                                    class="form-select <?php $__errorArgs = ['shipping_province'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Chọn tỉnh/thành phố</option>
                                </select>
                                <?php $__errorArgs = ['shipping_province'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-text">Phường/Xã <span
                                        class="text-danger">*</span></label>
                                <select name="shipping_ward" id="wardSelect"
                                    class="form-select <?php $__errorArgs = ['shipping_ward'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" disabled required>
                                    <option value="">Chọn phường/xã</option>
                                </select>
                                <?php $__errorArgs = ['shipping_ward'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-text">Địa chỉ chi tiết <span
                                        class="text-danger">*</span></label>
                                <textarea name="shipping_address"
                                    class="form-control <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3"
                                    placeholder="Số nhà, tên đường, tòa nhà,..."
                                    required><?php echo e(old('shipping_address')); ?></textarea>
                                <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Hidden fields cho codes -->
                            <input type="hidden" name="shipping_province_code" id="provinceCode"
                                value="<?php echo e(old('shipping_province_code')); ?>">
                            <input type="hidden" name="shipping_ward_code" id="wardCode"
                                value="<?php echo e(old('shipping_ward_code')); ?>">


                            <!-- THÊM 2 TRƯỜNG NÀY -->
                            <input type="hidden" name="shipping_province_name" id="provinceName"
                                value="<?php echo e(old('shipping_province_name')); ?>">
                            <input type="hidden" name="shipping_ward_name" id="wardName"
                                value="<?php echo e(old('shipping_ward_name')); ?>">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-text">Ghi chú đơn hàng</label>
                                <textarea name="note" class="form-control" rows="2"
                                    placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."><?php echo e(old('note')); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Phương thức thanh toán (giữ nguyên, chỉ update style) -->
                    <div class="checkout-step">
                        <div class="step-number">2</div>
                        <h5 class="mb-4 mt-2 text-text fw-bold">Phương Thức Thanh Toán</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="payment-method active" onclick="selectPayment(this, 'cod')">
                                    <input type="radio" name="payment_method" value="cod" checked class="d-none">
                                    <div class="d-flex align-items-center">
                                        <div class="shrink-0 me-3">
                                            <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-1 fw-bold text-text">Thanh toán khi nhận hàng</h6>
                                            <small class="text-muted">Thanh toán bằng tiền mặt khi nhận hàng</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="payment-method" onclick="selectPayment(this, 'bank_transfer')">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="d-none">
                                    <div class="d-flex align-items-center">
                                        <div class="shrink-0 me-3">
                                            <i class="fas fa-university fa-2x text-primary"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-1 fw-bold text-text">Chuyển khoản ngân hàng</h6>
                                            <small class="text-muted">Chuyển khoản qua ngân hàng</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="payment-method" onclick="selectPayment(this, 'momo')">
                                    <input type="radio" name="payment_method" value="momo" class="d-none">
                                    <div class="d-flex align-items-center">
                                        <div class="shrink-0 me-3">
                                            <i class="fas fa-mobile-alt fa-2x text-danger"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-1 fw-bold text-text">Ví MoMo</h6>
                                            <small class="text-muted">Thanh toán qua ví điện tử MoMo</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="payment-method" onclick="selectPayment(this, 'vnpay')">
                                    <input type="radio" name="payment_method" value="vnpay" class="d-none">
                                    <div class="d-flex align-items-center">
                                        <div class="shrink-0 me-3">
                                            <i class="fas fa-credit-card fa-2x text-info"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-1 fw-bold text-text">VNPay</h6>
                                            <small class="text-muted">Thanh toán qua VNPay</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Xác nhận -->
                    <div class="checkout-step">
                        <div class="step-number">3</div>
                        <h5 class="mb-4 mt-2 text-text fw-bold">Xác Nhận Đơn Hàng</h5>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                            <label class="form-check-label fw-semibold text-text" for="agreeTerms">
                                Tôi đã đọc và đồng ý với <a href="#" class="text-primary fw-bold">Điều khoản và Điều
                                    kiện</a> của website
                            </label>
                        </div>

                        <div class="alert alert-info rounded-3 border-0">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            <strong>Lưu ý:</strong> Đơn hàng sẽ được xử lý trong vòng 24h. Vui lòng kiểm tra email và số
                            điện thoại để nhận thông tin đơn hàng.
                        </div>
                    </div>
                </div>

                <!-- Right Column - Order Summary (giữ nguyên, update style) -->
                <div class="col-lg-4">
                    <div class="order-summary">
                        <!-- Voucher/Coupon Section -->
                        <div class="card mb-3 border-0 shadow-sm rounded-3 overflow-hidden">
                            <div class="card-body p-4">
                                <h6 class="mb-3 fw-bold text-text">
                                    <i class="fas fa-ticket-alt me-2 text-warning"></i> Mã Giảm Giá
                                </h6>

                                <?php if(session('coupon')): ?>
                                    <div
                                        class="alert alert-success d-flex justify-content-between align-items-center mb-3 rounded-3 border-0">
                                        <div>
                                            <strong class="text-text"><?php echo e(session('coupon.code')); ?></strong>
                                            <br><small
                                                class="text-success">-<?php echo e(number_format(session('coupon.discount'))); ?>đ</small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill"
                                            onclick="removeCoupon()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                                <div class="input-group mb-3">
                                    <input type="text" id="couponCode" class="form-control rounded-end-0"
                                        placeholder="Nhập mã giảm giá">
                                    <button type="button" class="btn btn-modern rounded-start-0" onclick="applyCoupon()">
                                        <i class="fas fa-check me-1"></i> Áp Dụng
                                    </button>
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-3"
                                    data-bs-toggle="modal" data-bs-target="#voucherModal">
                                    <i class="fas fa-gift me-1"></i> Xem Voucher Có Sẵn
                                </button>
                            </div>
                        </div>

                        <!-- Order Summary Card -->
                        <div class="card border-0 shadow rounded-3 overflow-hidden">
                            <div class="card-header text-white p-4"
                                style="background: linear-gradient(135deg, var(--primary), var(--secondary));">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-receipt me-2"></i> Thông Tin Đơn Hàng
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <!-- Cart Items -->
                                <div class="mb-4">
                                    <h6 class="mb-3 fw-bold text-text">Sản phẩm (<?php echo e($cart->items->count()); ?>)</h6>
                                    <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="d-flex mb-3 pb-3 border-bottom border-neutral">
                                            <img src="<?php echo e(asset($item->product->image)); ?>" alt="<?php echo e($item->product->name); ?>"
                                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"
                                                class="me-3">
                                            <div class="grow">
                                                <h6 class="mb-1 small fw-bold text-text">
                                                    <?php echo e(Str::limit($item->product->name, 40)); ?>

                                                </h6>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted small">SL: <?php echo e($item->quantity); ?></span>
                                                    <strong
                                                        class="small text-primary"><?php echo e(number_format($item->subtotal)); ?>đ</strong>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <hr class="my-3">

                                <!-- Price Breakdown -->
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-semibold text-text">Tạm tính:</span>
                                    <strong id="subtotal" class="text-primary"><?php echo e(number_format($cart->total)); ?>đ</strong>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-semibold text-text">Phí vận chuyển:</span>
                                    <strong id="shipping" class="text-primary">30,000đ</strong>
                                </div>

                                <?php if(session('coupon')): ?>
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span class="fw-semibold">Giảm giá (<?php echo e(session('coupon.code')); ?>):</span>
                                        <strong id="discount"
                                            class="text-success">-<?php echo e(number_format(session('coupon.discount'))); ?>đ</strong>
                                    </div>
                                <?php endif; ?>

                                <hr class="my-3">

                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="fw-bold text-text">Tổng cộng:</h5>
                                    <h5 class="fw-bold text-danger" id="total">
                                        <?php echo e(number_format($cart->total + 30000 - (session('coupon.discount') ?? 0))); ?>đ


                                    </h5>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-lg w-100 text-white fw-bold rounded-3 mb-3 btn-modern">
                                    <i class="fas fa-check-circle me-2"></i> Xác Nhận Đặt Hàng
                                </button>

                                <div class="text-center">
                                    <small class="text-muted fw-semibold">
                                        <i class="fas fa-shield-alt me-1 text-success"></i> Thanh toán an toàn & bảo mật
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Voucher Modal (giữ nguyên, update style) -->
    <div class="modal fade" id="voucherModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-text">
                        <i class="fas fa-gift me-2 text-warning"></i> Voucher Có Sẵn
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <?php if(isset($availablecoupons) && $availablecoupons->count() > 0): ?>
                        <?php $__currentLoopData = $availablecoupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="voucher-item" onclick="applyVoucher('<?php echo e($voucher->code); ?>')">
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center">
                                        <div class="coupon-badge">
                                            <i class="fas fa-ticket-alt"></i> <?php echo e($voucher->code); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-1 fw-bold text-text"><?php echo e($voucher->name); ?></h6>
                                        <p class="mb-1 small text-primary">
                                            Giảm
                                            <?php echo e($voucher->type === 'percent' ? $voucher->value . '%' : number_format($voucher->value) . 'đ'); ?>

                                        </p>
                                        <p class="mb-0 small text-muted">
                                            Đơn tối thiểu: <?php echo e(number_format($voucher->min_order)); ?>đ
                                            <?php if($voucher->end_date): ?> - Hết hạn: <?php echo e($voucher->end_date->format('d/m/Y')); ?> <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <button type="button" class="btn btn-modern btn-sm"
                                            onclick="applyVoucher('<?php echo e($voucher->code); ?>')">
                                            <i class="fas fa-check me-1"></i> Áp Dụng
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-gift fa-4x text-muted mb-3"></i>
                            <p class="text-muted fw-semibold">Hiện tại không có voucher khả dụng</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        // ==== API V2 (2025) ====
        const API_BASE = 'http://provinces.open-api.vn/api/v2/';

        // Load khi trang sẵn sàng
        // document.addEventListener('DOMContentLoaded', function () {
        //     loadProvinces();

        //     // Default: TP. Hồ Chí Minh (code 79)
        //     setTimeout(() => {
        //         const select = document.getElementById('provinceSelect');
        //         if (select.options.length > 1) {
        //             select.value = '79';
        //             loadWards(79);
        //         }
        //     }, 800);
        // });
        document.addEventListener('DOMContentLoaded', function () {
            loadProvinces();
        });
        // ==== 1. Load Tỉnh/Thành ====
        // resources/views/client/checkout/index.blade.php -> section('scripts')

        // Sửa lại hàm này
        function loadProvinces() {
            fetch(`${API_BASE}`)
                .then(r => r.json())
                .then(data => {
                    const select = document.getElementById('provinceSelect');
                    select.innerHTML = '<option value="">Chọn tỉnh/thành phố</option>';

                    data.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.code;
                        opt.textContent = p.name;
                        select.appendChild(opt);
                    });

                    // === PHẦN SỬA ĐỔI QUAN TRỌNG ===
                    // Sau khi đã có danh sách tỉnh, hãy thiết lập giá trị mặc định
                    const defaultProvinceCode = '79'; // Mã TP.HCM
                    if (select.querySelector(`option[value="${defaultProvinceCode}"]`)) {
                        select.value = defaultProvinceCode;

                        // Chủ động kích hoạt sự kiện 'change'
                        // Điều này sẽ làm cho tất cả logic trong event listener chạy
                        // bao gồm cả việc cập nhật provinceName và tải phường/xã.
                        const event = new Event('change');
                        select.dispatchEvent(event);
                    }
                    // ===============================

                })
                .catch(err => {
                    console.error('Lỗi load tỉnh:', err);
                    alert('Không thể tải danh sách tỉnh/thành phố');
                });
        }

        // resources/views/client/checkout/index.blade.php -> section('scripts')

        // ==== 2. Khi chọn tỉnh → Load Phường/Xã ====
        document.getElementById('provinceSelect').addEventListener('change', function () {
            const code = this.value;
            const name = this.options[this.selectedIndex].text; // Lấy tên tỉnh
            const wardSelect = document.getElementById('wardSelect');

            // Cập nhật trường hidden với tên tỉnh
            document.getElementById('provinceName').value = name;

            // Reset
            wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
            wardSelect.disabled = true;
            document.getElementById('wardName').value = '';

            if (!code) {
                document.getElementById('provinceName').value = ''; // Reset nếu không chọn gì
                return;
            }

            loadWards(code);
        });



        // Bỏ phần code cũ không cần thiết này đi
        /*
        document.getElementById('wardSelect').addEventListener('change', function () {
            const provinceCode = document.getElementById('provinceSelect').value;
            const wardCode = this.value;
            const wardName = this.options[this.selectedIndex].text;

            document.getElementById('provinceCode').value = provinceCode;   // không cần
            document.getElementById('wardCode').value = wardCode;       // không cần
            document.getElementById('wardName').value = wardName;       // cần
        });
        */
        function loadWards(provinceCode) {
            const wardSelect = document.getElementById('wardSelect');
            wardSelect.innerHTML = '<option value="">Đang tải phường/xã...</option>';
            wardSelect.disabled = true;

            // DÙNG ENDPOINT /w/?province=
            fetch(`${API_BASE}w/?province=${provinceCode}`)
                .then(r => r.json())
                .then(wards => {
                    wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';

                    if (Array.isArray(wards) && wards.length > 0) {
                        wards.forEach(w => {
                            const opt = document.createElement('option');
                            opt.value = w.code;
                            opt.textContent = w.name;
                            wardSelect.appendChild(opt);
                        });
                    } else {
                        wardSelect.innerHTML = '<option value="">Không có phường/xã</option>';
                    }

                    wardSelect.disabled = false;
                })
                .catch(err => {
                    console.error('Lỗi load phường/xã:', err);
                    wardSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
                });
        }

        // ==== 3. Khi chọn phường → Lưu code + tên ====
        // Khi chọn phường
        document.getElementById('wardSelect').addEventListener('change', function () {
            const wardName = this.options[this.selectedIndex].text; // Lấy tên phường/xã

            // Cập nhật trường hidden với tên phường/xã
            document.getElementById('wardName').value = wardName;
        });
        // document.getElementById('wardSelect').addEventListener('change', function () {
        //     const provinceCode = document.getElementById('provinceSelect').value;
        //     const wardCode = this.value;
        //     const wardName = this.options[this.selectedIndex].text;

        //     document.getElementById('provinceCode').value = provinceCode;   // không cần
        //     document.getElementById('wardCode').value = wardCode;       // không cần
        //     document.getElementById('wardName').value = wardName;       // cần
        // });

        // Form submit – chỉ chặn nếu thiếu điều khoản hoặc địa chỉ
        document.getElementById('checkoutForm').addEventListener('submit', function (e) {
            const agree = document.getElementById('agreeTerms').checked;
            const prov = document.getElementById('provinceSelect').value;
            const ward = document.getElementById('wardSelect').value;

            if (!agree || !prov || !ward) {
                e.preventDefault();
                alert('Vui lòng đồng ý điều khoản và chọn đầy đủ địa chỉ');
                return false;
            }
            // để Laravel xử lý validation, không cần preventDefault nữa
        });

        // ==== Giữ nguyên các hàm cũ (payment, coupon...) ====
        function selectPayment(el, method) {
            document.querySelectorAll('.payment-method').forEach(e => e.classList.remove('active'));
            el.classList.add('active');
            el.querySelector('input[type="radio"]').checked = true;
        }

        if (document.querySelector('input[name="payment_method"]:checked').value === 'vnpay') {
            const btn = document.querySelector('button[type="submit"]');
            btn.innerHTML = '<span class="loading"></span> Đang chuyển đến VNPay...';
            btn.disabled = true;
        }
        function applyCoupon() {
            const code = document.getElementById('couponCode').value.trim();
            if (!code) return alert('Vui lòng nhập mã giảm giá');

            fetch('<?php echo e(route("client.checkout.apply-coupon")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ code })
            })
                .then(r => r.json())
                .then(d => {
                    if (d.success) {
                        alert('Áp dụng mã giảm giá thành công! Giảm ' + d.discount + 'đ');
                        location.reload(); // QUAN TRỌNG: RELOAD ĐỂ BLADE ĐỌC SESSION MỚI
                    } else {
                        alert('Lỗi: ' + d.message);
                    }
                })
                .catch(() => alert('Lỗi kết nối, vui lòng thử lại'));
        }
        function updateOrderSummary(discount, newTotal) {
            // Cập nhật dòng "Giảm giá"
            let discountRow = document.querySelector('#discount-row');
            if (!discountRow) {
                const hr = document.querySelector('#discount-hr');
                if (hr) {
                    discountRow = document.createElement('div');
                    discountRow.id = 'discount-row';
                    discountRow.className = 'd-flex justify-content-between mb-2 text-success';
                    discountRow.innerHTML = `
                                                                                                                                            <span class="fw-semibold">Giảm giá:</span>
                                                                                                                                            <strong id="discount" class="text-success">-0đ</strong>
                                                                                                                                        `;
                    hr.insertAdjacentElement('afterend', discountRow);
                }
            }
            document.getElementById('discount').textContent = '-' + discount + 'đ';

            // Cập nhật Tổng cộng
            document.getElementById('total').textContent = newTotal + 'đ';
        }

        function showAppliedCoupon(code, discount) {
            let couponAlert = document.querySelector('#applied-coupon-alert');
            if (!couponAlert) {
                const inputGroup = document.querySelector('.input-group');
                couponAlert = document.createElement('div');
                couponAlert.id = 'applied-coupon-alert';
                couponAlert.className = 'alert alert-success d-flex justify-content-between align-items-center mb-3 rounded-3 border-0';
                couponAlert.innerHTML = `
                                                                                                                                        <div>
                                                                                                                                            <strong class="text-text">${code}</strong><br>
                                                                                                                                            <small class="text-success">-${discount}đ</small>
                                                                                                                                        </div>
                                                                                                                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="removeCoupon()">
                                                                                                                                            <i class="fas fa-times"></i>
                                                                                                                                        </button>
                                                                                                                                    `;
                inputGroup.insertAdjacentElement('beforebegin', couponAlert);
            } else {
                couponAlert.querySelector('strong').textContent = code;
                couponAlert.querySelector('small').textContent = '-' + discount + 'đ';
            }
        }
        function applyVoucher(code) {
            document.getElementById('couponCode').value = code;
            applyCoupon();
        }


        function removeCoupon() {
            if (!confirm('Bạn có chắc muốn xóa mã giảm giá?')) return;

            fetch('<?php echo e(route("client.checkout.remove-coupon")); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(r => r.json())
                .then(d => {
                    if (d.success) {
                        // XÓA ALERT
                        const alert = document.querySelector('.alert.alert-success');
                        if (alert) alert.remove();

                        // ẨN DÒNG GIẢM GIÁ
                        const discountRow = document.getElementById('discount-row');
                        if (discountRow) discountRow.style.display = 'none';

                        // CẬP NHẬT TỔNG
                        const subtotal = <?php echo e($cart->total); ?>;
                        const shipping = 30000;
                        const total = subtotal + shipping;
                        document.getElementById('total').textContent = number_format(total) + 'đ';

                        alert('Đã xóa mã giảm giá!');
                    } else {
                        alert('Lỗi: ' + (d.message || 'Không thể xóa'));
                    }
                })
                .catch(() => {
                    alert('Lỗi kết nối, vui lòng thử lại');
                });
        }

        // Helper format số
        function number_format(number) {
            return new Intl.NumberFormat('vi-VN').format(number);
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client.layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/client/checkout/index.blade.php ENDPATH**/ ?>