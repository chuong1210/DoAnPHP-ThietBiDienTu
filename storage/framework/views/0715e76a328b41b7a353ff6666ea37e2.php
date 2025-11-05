<?php $__env->startSection('title', 'Giỏ Hàng'); ?>
<?php
    $hideSidebar = true;
?>
<?php $__env->startSection('content'); ?>
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

        /* Page Header */
        .cart-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 2px solid var(--neutral);
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .cart-header-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(0, 102, 255, 0.3);
        }

        .cart-header-icon i {
            font-size: 2rem;
            color: white;
        }

        .cart-header h3 {
            color: var(--text);
            font-weight: 800;
            margin: 0;
        }

        /* Alert */
        .alert {
            border-radius: 16px;
            border: none;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
            color: #065F46;
        }

        /* Cart Card */
        .cart-card {
            background: white;
            border-radius: 20px;
            border: 2px solid var(--neutral);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .cart-card .card-body {
            padding: 2rem;
        }

        /* Table Styles */
        .table {
            margin: 0;
        }

        .table thead th {
            background: var(--background);
            color: var(--text);
            font-weight: 700;
            border: none;
            padding: 1.25rem 1rem;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 1.5rem 1rem;
            vertical-align: middle;
            border-bottom: 2px solid var(--background);
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: var(--background);
        }

        /* Product Image */
        .product-image-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid var(--neutral);
            flex-shrink: 0;
        }

        .product-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info h6 {
            margin-bottom: 0.5rem;
            font-weight: 700;
            font-size: 1rem;
        }

        .product-info h6 a {
            color: var(--text);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .product-info h6 a:hover {
            color: var(--primary);
        }

        .product-info small {
            color: #64748B;
            font-weight: 600;
        }

        /* Quantity Input */
        .input-group-sm {
            width: 130px;
        }

        .input-group-sm .btn {
            border: 2px solid var(--neutral);
            background: white;
            color: var(--text);
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .input-group-sm .btn:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .input-group-sm .form-control {
            border: 2px solid var(--neutral);
            border-left: none;
            border-right: none;
            font-weight: 700;
            color: var(--text);
        }

        .input-group-sm .form-control:focus {
            box-shadow: none;
            border-color: var(--primary);
        }

        /* Buttons */
        .btn-outline-danger {
            border: 2px solid var(--danger);
            color: var(--danger);
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .btn-outline-danger:hover {
            background: var(--danger);
            color: white;
            transform: scale(1.1);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
            padding: 0.85rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        /* Summary Card */
        .summary-card {
            background: white;
            border-radius: 20px;
            border: 2px solid var(--neutral);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            position: sticky;
            top: 120px;
        }

        .summary-card .card-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem;
            border: none;
        }

        .summary-card .card-header h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .summary-card .card-body {
            padding: 2rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            color: #64748B;
            font-size: 1rem;
        }

        .summary-row strong {
            color: var(--text);
            font-weight: 700;
        }

        .summary-row.discount strong {
            color: var(--success);
        }

        .summary-divider {
            height: 2px;
            background: var(--neutral);
            margin: 1.5rem 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .summary-total h5 {
            color: var(--text);
            font-weight: 800;
            margin: 0;
            font-size: 1.25rem;
        }

        .summary-total .total-amount {
            color: var(--danger);
            font-size: 2rem;
            font-weight: 800;
        }

        .btn-checkout {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.05rem;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 102, 255, 0.3);
            color: white;
        }

        .btn-checkout:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 102, 255, 0.4);
            color: white;
        }

        .btn-coupon {
            background: white;
            border: 2px solid var(--neutral);
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            color: var(--text);
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-coupon:hover {
            border-color: var(--warning);
            background: var(--background);
            color: var(--warning);
        }

        /* Payment Methods */
        .payment-methods {
            background: var(--background);
            padding: 1.5rem;
            border-radius: 16px;
            margin-top: 1.5rem;
        }

        .payment-methods h6 {
            color: var(--text);
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
        }

        .payment-icons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .payment-icon {
            width: 60px;
            height: 40px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border: 2px solid var(--neutral);
            transition: all 0.3s ease;
        }

        .payment-icon:hover {
            border-color: var(--primary);
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
        }

        .payment-icon img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* Security Card */
        .security-card {
            background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            border: 2px solid #10B981;
            margin-top: 2rem;
        }

        .security-card i {
            font-size: 3rem;
            color: #065F46;
            margin-bottom: 1rem;
        }

        .security-card h6 {
            color: #065F46;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .security-card p {
            color: #047857;
            margin: 0;
            font-size: 0.9rem;
        }

        /* Empty Cart */
        .empty-cart {
            background: white;
            border-radius: 24px;
            padding: 5rem 2rem;
            text-align: center;
            border: 2px solid var(--neutral);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .empty-cart i {
            font-size: 6rem;
            color: var(--neutral);
            margin-bottom: 2rem;
            opacity: 0.5;
        }

        .empty-cart h4 {
            color: var(--text);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .empty-cart .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 700;
            box-shadow: 0 6px 20px rgba(0, 102, 255, 0.3);
            transition: all 0.3s ease;
        }

        .empty-cart .btn-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 102, 255, 0.4);
        }

        /* Modal */
        .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem 2rem;
            border: none;
        }

        .modal-header .modal-title {
            font-weight: 700;
            font-size: 1.25rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-body .form-label {
            color: var(--text);
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .modal-body .input-group .form-control {
            border: 2px solid var(--neutral);
            border-right: none;
            padding: 0.85rem 1.25rem;
            border-radius: 12px 0 0 12px;
        }

        .modal-body .input-group .form-control:focus {
            border-color: var(--primary);
            box-shadow: none;
        }

        .modal-body .input-group .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            padding: 0.85rem 1.5rem;
            border-radius: 0 12px 12px 0;
            font-weight: 700;
        }

        .list-group-item {
            border: 2px solid var(--neutral);
            border-radius: 12px !important;
            margin-bottom: 0.75rem;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.1);
        }

        .list-group-item strong {
            color: var(--primary);
            font-size: 1.1rem;
        }

        .list-group-item .btn-outline-primary {
            padding: 0.5rem 1.25rem;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cart-header {
                padding: 1.5rem;
            }

            .cart-card .card-body {
                padding: 1rem;
            }

            .summary-card {
                position: static;
                margin-top: 2rem;
            }

            .table-responsive {
                border-radius: 12px;
            }

            .product-image-wrapper {
                width: 60px;
                height: 60px;
            }

            .input-group-sm {
                width: 100px;
            }
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="cart-header">
                <div class="cart-header-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <h3>Giỏ Hàng Của Bạn</h3>
                    <p class="text-muted mb-0">Quản lý sản phẩm bạn muốn mua</p>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i>
                    <span><?php echo e(session('success')); ?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($cart && $cart->items->count() > 0): ?>
                <div class="row">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="cart-card card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Sản Phẩm</th>
                                                <th>Đơn Giá</th>
                                                <th style="width: 150px;">Số Lượng</th>
                                                <th>Thành Tiền</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <?php if($item->product->image): ?>
                                                                <div class="product-image-wrapper">
                                                                    <img src="<?php echo e(asset($item->product->image)); ?>"
                                                                        alt="<?php echo e($item->product->name); ?>">
                                                                </div>
                                                            <?php endif; ?>
                                                            <div class="product-info">
                                                                <h6>
                                                                    <a
                                                                        href="<?php echo e(route('client.product.show', $item->product->slug)); ?>">
                                                                        <?php echo e($item->product->name); ?>

                                                                    </a>
                                                                </h6>
                                                                <small><?php echo e($item->product->brand->name); ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <strong style="color: var(--text); font-size: 1.1rem;">
                                                            <?php echo e(number_format($item->price)); ?>đ
                                                        </strong>
                                                    </td>
                                                    <td>
                                                        <form action="<?php echo e(route('client.cart.update', $item->id)); ?>" method="POST"
                                                            class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PUT'); ?>
                                                            <div class="input-group input-group-sm">
                                                                <button type="button" class="btn btn-outline-secondary"
                                                                    onclick="updateQty(<?php echo e($item->id); ?>, -1, <?php echo e($item->product->quantity); ?>)">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                                <input type="number" name="quantity" id="qty<?php echo e($item->id); ?>"
                                                                    class="form-control text-center" value="<?php echo e($item->quantity); ?>"
                                                                    min="1" max="<?php echo e($item->product->quantity); ?>"
                                                                    onchange="this.form.submit()">
                                                                <button type="button" class="btn btn-outline-secondary"
                                                                    onclick="updateQty(<?php echo e($item->id); ?>, 1, <?php echo e($item->product->quantity); ?>)">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <strong style="color: var(--danger); font-size: 1.25rem; font-weight: 800;">
                                                            <?php echo e(number_format($item->subtotal)); ?>đ
                                                        </strong>
                                                    </td>
                                                    <td>
                                                        <form action="<?php echo e(route('client.cart.remove', $item->id)); ?>" method="POST"
                                                            onsubmit="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="<?php echo e(route('client.product.index')); ?>" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i> Tiếp Tục Mua Sắm
                            </a>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-lg-4">
                        <div class="summary-card card">
                            <div class="card-header">
                                <h5><i class="fas fa-receipt me-2"></i>Thông Tin Đơn Hàng</h5>
                            </div>
                            <div class="card-body">
                                <div class="summary-row">
                                    <span>Tạm tính:</span>
                                    <strong><?php echo e(number_format($cart->total)); ?>đ</strong>
                                </div>

                                <div class="summary-row">
                                    <span>Phí vận chuyển:</span>
                                    <strong>30,000đ</strong>
                                </div>

                                <?php if(session('coupon')): ?>
                                    <div class="summary-row discount">
                                        <span>Mã giảm giá (<?php echo e(session('coupon.code')); ?>):</span>
                                        <strong>-<?php echo e(number_format(session('coupon.discount'))); ?>đ</strong>
                                    </div>
                                <?php endif; ?>

                                <div class="summary-divider"></div>

                                <div class="summary-total">
                                    <h5>Tổng cộng:</h5>
                                    <div class="total-amount">
                                        <?php echo e(number_format($cart->total + 30000 - (session('coupon.discount') ?? 0))); ?>đ
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <a href="<?php echo e(route('client.checkout.index')); ?>" class="btn btn-checkout">
                                        <i class="fas fa-credit-card me-2"></i> Thanh Toán
                                    </a>
                                    <button type="button" class="btn btn-coupon" data-bs-toggle="modal"
                                        data-bs-target="#couponModal">
                                        <i class="fas fa-tag me-2"></i> Nhập Mã Giảm Giá
                                    </button>
                                </div>

                                <!-- Payment Methods -->
                                <div class="payment-methods">
                                    <h6>Phương thức thanh toán</h6>
                                    <div class="payment-icons">
                                        <div class="payment-icon">
                                            <img src="https://static.vecteezy.com/system/resources/previews/019/053/701/original/money-symbol-icon-png.png"
                                                alt="COD">
                                        </div>
                                        <div class="payment-icon">
                                            <img src="https://developers.momo.vn/v3/assets/images/icon-52bd5808cecdb1970e1aeec3c31a3ee1.png"
                                                alt="Momo">
                                        </div>
                                        <div class="payment-icon">
                                            <img src="https://vinadesign.vn/uploads/images/2023/05/vnpay-logo-vinadesign-25-12-57-55.jpg"
                                                alt="VNPay">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security -->
                        <div class="security-card">
                            <i class="fas fa-shield-alt"></i>
                            <h6>Mua Hàng An Toàn</h6>
                            <p>
                                Thanh toán được mã hóa SSL<br>
                                Bảo vệ thông tin khách hàng
                            </p>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <!-- Empty Cart -->
                <div class="empty-cart card">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart"></i>
                        <h4>Giỏ Hàng Trống</h4>
                        <p class="text-muted mb-4">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                        <a href="<?php echo e(route('client.product.index')); ?>" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i> Mua Sắm Ngay
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Coupon Modal -->
    <div class="modal fade" id="couponModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-tag me-2"></i>Nhập Mã Giảm Giá</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="couponForm" action="<?php echo e(route('client.checkout.apply-coupon')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Mã giảm giá</label>
                            <div class="input-group">
                                <input type="text" name="code" id="couponCode" class="form-control"
                                    placeholder="Nhập mã giảm giá" required>
                                <button type="submit" class="btn btn-primary">Áp Dụng</button>
                            </div>
                            <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </form>

                    <hr>

                    <div class="mt-4">
                        <h6 style="color: var(--text); font-weight: 700; margin-bottom: 1rem;">Mã giảm giá có sẵn:</h6>
                        <?php if($coupons->count() > 0): ?>
                            <div class="list-group">
                                <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo e($coupon->code); ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <?php if($coupon->type === 'percent'): ?>
                                                        Giảm <?php echo e($coupon->value); ?>% (từ <?php echo e(number_format($coupon->min_order)); ?>đ)
                                                    <?php else: ?>
                                                        Giảm <?php echo e(number_format($coupon->value)); ?>đ (từ
                                                        <?php echo e(number_format($coupon->min_order)); ?>đ)
                                                    <?php endif; ?>
                                                    <?php if($coupon->end_date): ?>
                                                        - Hết hạn: <?php echo e($coupon->end_date->format('d/m/Y')); ?>

                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="copyCoupon('<?php echo e($coupon->code); ?>', this)">
                                                Sao chép
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Chưa có mã giảm giá nào.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        function updateQty(itemId, change, maxQty) {
            const input = document.getElementById('qty' + itemId);
            const currentQty = parseInt(input.value);
            const newQty = currentQty + change;

            if (newQty >= 1 && newQty <= maxQty) {
                input.value = newQty;
                input.form.submit();
            } else if (newQty > maxQty) {
                alert('Số lượng tối đa là ' + maxQty);
            }
        }

        // Copy coupon code to clipboard (fixed: use `this` for button)
        function copyCoupon(code, button) {
            navigator.clipboard.writeText(code).then(function () {
                // Show success feedback on button
                const originalText = button.innerHTML;
                const originalClass = button.className;

                button.innerHTML = '<i class="fas fa-check"></i> Đã sao chép!';
                button.className = 'btn btn-sm btn-success';

                setTimeout(function () {
                    button.innerHTML = originalText;
                    button.className = originalClass;
                }, 2000);
            }).catch(function (err) {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = code;
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    alert('Đã sao chép mã: ' + code);
                } catch (err) {
                    alert('Không thể sao chép mã: ' + code + '. Vui lòng copy thủ công.');
                }
                document.body.removeChild(textArea);
            });
        }

        // Optional: Close modal after successful apply (listen to form submit)
        document.getElementById('couponForm').addEventListener('submit', function (e) {
            const code = document.getElementById('couponCode').value.trim();
            if (!code) {
                e.preventDefault();
                alert('Vui lòng nhập mã giảm giá');
                return;
            }
        });

        // AJAX apply coupon
        document.getElementById('couponForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang áp dụng...';
            submitBtn.disabled = true;

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Áp dụng thành công! Giảm ' + data.discount + 'đ');
                        location.reload(); // Reload để update summary
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(err => {
                    alert('Lỗi kết nối: ' + err);
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client.layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/client/cart/index.blade.php ENDPATH**/ ?>