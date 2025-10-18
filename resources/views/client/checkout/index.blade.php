@extends('client.layouts.client')

@section('title', 'Thanh Toán')

@section('styles')
    <style>
        .checkout-step {
            position: relative;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .step-number {
            position: absolute;
            top: -15px;
            left: 20px;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.4);
        }

        .payment-method {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-method:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }

        .payment-method.active {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        }

        .order-summary {
            position: sticky;
            top: 20px;
        }

        .coupon-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            display: inline-block;
        }

        .voucher-item {
            border: 2px dashed #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .voucher-item:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }

        .voucher-item.active {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        }

        .progress-bar {
            background: #e9ecef;
            height: 4px;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            width: 50%; /* Adjust based on step */
            transition: width 0.3s ease;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.cart.index') }}">Giỏ hàng</a></li>
                <li class="breadcrumb-item active">Thanh toán</li>
            </ol>
        </nav>

        <!-- Progress Bar -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <div class="d-flex justify-content-between position-relative" style="z-index: 1;">
                    <div class="text-center" style="flex: 1;">
                        <div class="bg-success text-white rounded-circle mx-auto mb-2"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                        </div>
                        <small class="text-success fw-bold">Giỏ Hàng</small>
                    </div>
                    <div class="text-center" style="flex: 1;">
                        <div class="bg-primary text-white rounded-circle mx-auto mb-2"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-credit-card fa-lg"></i>
                        </div>
                        <small class="text-primary fw-bold">Thanh Toán</small>
                    </div>
                    <div class="text-center" style="flex: 1;">
                        <div class="bg-secondary text-white rounded-circle mx-auto mb-2"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check fa-lg"></i>
                        </div>
                        <small class="text-muted">Hoàn Thành</small>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @enderror

        <form action="{{ route('client.checkout.process') }}" method="POST" id="checkoutForm">
            @csrf

            <div class="row">
                <!-- Left Column - Checkout Steps -->
                <div class="col-lg-8">
                    <!-- Step 1: Thông tin giao hàng -->
                    <div class="checkout-step">
                        <div class="step-number">1</div>
                        <h5 class="mb-4 mt-2">Thông Tin Giao Hàng</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name"
                                    class="form-control @error('customer_name') is-invalid @enderror"
                                    value="{{ old('customer_name', Auth::user()->full_name) }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" name="customer_phone"
                                    class="form-control @error('customer_phone') is-invalid @enderror"
                                    value="{{ old('customer_phone', Auth::user()->phone) }}" required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="customer_email"
                                    class="form-control @error('customer_email') is-invalid @enderror"
                                    value="{{ old('customer_email', Auth::user()->email) }}">
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                <textarea name="shipping_address"
                                    class="form-control @error('shipping_address') is-invalid @enderror" rows="3"
                                    required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phường/Xã <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_ward"
                                    class="form-control @error('shipping_ward') is-invalid @enderror"
                                    value="{{ old('shipping_ward') }}" required>
                                @error('shipping_ward')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Quận/Huyện <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_district"
                                    class="form-control @error('shipping_district') is-invalid @enderror"
                                    value="{{ old('shipping_district') }}" required>
                                @error('shipping_district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_city"
                                    class="form-control @error('shipping_city') is-invalid @enderror"
                                    value="{{ old('shipping_city', 'TP. Hồ Chí Minh') }}" required>
                                @error('shipping_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Ghi chú đơn hàng</label>
                                <textarea name="note" class="form-control" rows="2"
                                    placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn.">{{ old('note') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Phương thức thanh toán -->
                    <div class="checkout-step">
                        <div class="step-number">2</div>
                        <h5 class="mb-4 mt-2">Phương Thức Thanh Toán</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="payment-method active" onclick="selectPayment(this, 'cod')">
                                    <input type="radio" name="payment_method" value="cod" checked class="d-none">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-money-bill-wave fa-3x text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">Thanh toán khi nhận hàng</h6>
                                            <small class="text-muted">Thanh toán bằng tiền mặt khi nhận hàng</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="payment-method" onclick="selectPayment(this, 'bank_transfer')">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="d-none">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-university fa-3x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">Chuyển khoản ngân hàng</h6>
                                            <small class="text-muted">Chuyển khoản qua ngân hàng</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="payment-method" onclick="selectPayment(this, 'momo')">
                                    <input type="radio" name="payment_method" value="momo" class="d-none">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-mobile-alt fa-3x text-danger"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">Ví MoMo</h6>
                                            <small class="text-muted">Thanh toán qua ví điện tử MoMo</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="payment-method" onclick="selectPayment(this, 'vnpay')">
                                    <input type="radio" name="payment_method" value="vnpay" class="d-none">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-credit-card fa-3x text-info"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">VNPay</h6>
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
                        <h5 class="mb-4 mt-2">Xác Nhận Đơn Hàng</h5>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                            <label class="form-check-label" for="agreeTerms">
                                Tôi đã đọc và đồng ý với <a href="#" class="text-primary">Điều khoản và Điều kiện</a> của
                                website
                            </label>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Lưu ý:</strong> Đơn hàng sẽ được xử lý trong vòng 24h.
                            Vui lòng kiểm tra email và số điện thoại để nhận thông tin đơn hàng.
                        </div>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="col-lg-4">
                    <div class="order-summary">
                        <!-- Voucher/Coupon Section -->
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="mb-3">
                                    <i class="fas fa-ticket-alt text-warning"></i> Mã Giảm Giá
                                </h6>

                                <!-- Applied Coupon -->
                                @if(session('coupon'))
                                    <div class="alert alert-success d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <strong>{{ session('coupon.code') }}</strong>
                                            <br>
                                            <small>-{{ number_format(session('coupon.discount')) }}đ</small>
                                        </div>
                                        <form action="{{ route('client.checkout.remove-coupon') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                <!-- Coupon Input -->
                                <div class="input-group mb-3">
                                    <input type="text" id="couponCode" class="form-control" placeholder="Nhập mã giảm giá">
                                    <button type="button" class="btn btn-primary" onclick="applyCoupon()">
                                        Áp Dụng
                                    </button>
                                </div>

                                <!-- Available Vouchers Button -->
                                <button type="button" class="btn btn-outline-primary btn-sm w-100" data-bs-toggle="modal"
                                    data-bs-target="#voucherModal">
                                    <i class="fas fa-gift"></i> Xem Voucher Có Sẵn
                                </button>
                            </div>
                        </div>

                        <!-- Order Summary Card -->
                        <div class="card border-0 shadow">
                            <div class="card-header bg-gradient text-white"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <h5 class="mb-0">
                                    <i class="fas fa-receipt"></i> Thông Tin Đơn Hàng
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Cart Items -->
                                <div class="mb-3">
                                    <h6 class="mb-3">Sản phẩm ({{ $cart->items->count() }})</h6>
                                    @foreach($cart->items as $item)
                                        <div class="d-flex mb-3 pb-3 border-bottom">
                                            <img src="{{ asset( $item->product->image) }}" alt="{{ $item->product->name }}"
                                                style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                            <div class="ms-3 flex-grow-1">
                                                <h6 class="mb-1 small">{{ Str::limit($item->product->name, 40) }}</h6>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted small">SL: {{ $item->quantity }}</span>
                                                    <strong class="small">{{ number_format($item->subtotal) }}đ</strong>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <hr>

                                <!-- Price Breakdown -->
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tạm tính:</span>
                                    <strong id="subtotal">{{ number_format($cart->total) }}đ</strong>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Phí vận chuyển:</span>
                                    <strong id="shipping">30,000đ</strong>
                                </div>

                                @if(session('coupon'))
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span>Giảm giá ({{ session('coupon.code') }}):</span>
                                        <strong id="discount">-{{ number_format(session('coupon.discount')) }}đ</strong>
                                    </div>
                                @endif

                                <hr>

                                <div class="d-flex justify-content-between mb-4">
                                    <h5>Tổng cộng:</h5>
                                    <h5 class="text-danger" id="total">
                                        {{ number_format($cart->total + 30000 - (session('coupon.discount') ?? 0)) }}đ
                                    </h5>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-lg w-100 text-white"
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="fas fa-check-circle"></i> Xác Nhận Đặt Hàng
                                </button>

                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-shield-alt text-success"></i> Thanh toán an toàn & bảo mật
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Voucher Modal -->
    <div class="modal fade" id="voucherModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-gift text-warning"></i> Voucher Có Sẵn
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if(isset($availableVouchers) && $availableVouchers->count() > 0)
                        @foreach($availableVouchers as $voucher)
                            <div class="voucher-item" onclick="applyVoucher('{{ $voucher->code }}')">
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center">
                                        <div class="coupon-badge">
                                            <i class="fas fa-ticket-alt fa-2x"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-1">{{ $voucher->code }}</h6>
                                        <p class="mb-1 small">
                                            Giảm
                                            {{ $voucher->type === 'percent' ? $voucher->value . '%' : number_format($voucher->value) . 'đ' }}
                                        </p>
                                        <p class="mb-0 small text-muted">
                                            Đơn tối thiểu: {{ number_format($voucher->min_order) }}đ
                                            @if($voucher->end_date)
                                                - Hết hạn: {{ $voucher->end_date->format('d/m/Y') }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="applyVoucher('{{ $voucher->code }}')">
                                            Áp Dụng
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-gift fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Hiện tại không có voucher khả dụng</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function selectPayment(element, method) {
            // Remove active class from all
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('active');
            });

            // Add active class to selected
            element.classList.add('active');

            // Check the radio button
            element.querySelector('input[type="radio"]').checked = true;
        }

        function applyCoupon() {
            const code = document.getElementById('couponCode').value.trim();
            if (!code) {
                alert('Vui lòng nhập mã giảm giá');
                return;
            }

            // AJAX call to apply coupon
            fetch('{{ route("client.checkout.apply-coupon") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ code: code })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Áp dụng thành công! Giảm ' + data.discount + 'đ');
                    location.reload(); // Reload to update summary
                } else {
                    alert('Lỗi: ' + data.message);
                }
            })
            .catch(err => {
                alert('Lỗi kết nối: ' + err);
            });
        }

        function applyVoucher(code) {
            // Set code to input and call applyCoupon
            document.getElementById('couponCode').value = code;
            applyCoupon();
        }

        // Form validation
        document.getElementById('checkoutForm').addEventListener('submit', function (e) {
            const agreeTerms = document.getElementById('agreeTerms');
            if (!agreeTerms.checked) {
                e.preventDefault();
                alert('Vui lòng đồng ý với điều khoản và điều kiện');
                return false;
            }
        });
    </script>
@endsection
