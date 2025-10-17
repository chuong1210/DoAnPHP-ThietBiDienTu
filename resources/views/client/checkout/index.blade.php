@extends('client.layouts.client')

@section('title', 'Thanh Toán')

@section('styles')
    <style>
        .checkout-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }

        .checkout-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e0e0e0;
            z-index: 0;
        }

        .step {
            position: relative;
            text-align: center;
            flex: 1;
            z-index: 1;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 2px solid #e0e0e0;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #999;
        }

        .step.active .step-circle {
            background: #007bff;
            border-color: #007bff;
            color: white;
        }

        .step.completed .step-circle {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }

        .payment-method {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-method:hover {
            border-color: #007bff;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
        }

        .payment-method.active {
            border-color: #007bff;
            background: #f8f9ff;
        }

        .voucher-item {
            border: 2px dashed #28a745;
            border-radius: 8px;
            padding: 15px;
            background: #f0fff4;
            cursor: pointer;
            transition: all 0.3s;
        }

        .voucher-item:hover {
            border-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
        }

        .voucher-item.selected {
            border-color: #1e7e34;
            background: #d4edda;
            border-style: solid;
        }

        .discount-tag {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <!-- Checkout Steps -->
        <div class="checkout-steps">
            <div class="step completed">
                <div class="step-circle">
                    <i class="fas fa-check"></i>
                </div>
                <div class="step-label">Giỏ Hàng</div>
            </div>
            <div class="step active">
                <div class="step-circle">2</div>
                <div class="step-label">Thông Tin</div>
            </div>
            <div class="step">
                <div class="step-circle">3</div>
                <div class="step-label">Thanh Toán</div>
            </div>
            <div class="step">
                <div class="step-circle">4</div>
                <div class="step-label">Hoàn Thành</div>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('client.checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            <input type="hidden" name="applied_voucher_code" id="appliedVoucherCode" value="">

            <div class="row">
                <!-- Left Column - Form -->
                <div class="col-lg-7">
                    <!-- Thông Tin Nhận Hàng -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user"></i> Thông Tin Nhận Hàng
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Họ và Tên <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="customer_name"
                                        class="form-control @error('customer_name') is-invalid @enderror"
                                        value="{{ old('customer_name', Auth::user()->full_name) }}"
                                        placeholder="Nguyễn Văn A" required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Số Điện Thoại <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" name="customer_phone"
                                        class="form-control @error('customer_phone') is-invalid @enderror"
                                        value="{{ old('customer_phone', Auth::user()->phone) }}" placeholder="0912345678"
                                        required>
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        Email
                                    </label>
                                    <input type="email" name="customer_email"
                                        class="form-control @error('customer_email') is-invalid @enderror"
                                        value="{{ old('customer_email', Auth::user()->email) }}"
                                        placeholder="example@email.com">
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        Địa Chỉ Nhận Hàng <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="shipping_address"
                                        class="form-control @error('shipping_address') is-invalid @enderror" rows="3"
                                        placeholder="Số nhà, tên đường..." required>{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Phường/Xã <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="shipping_ward"
                                        class="form-control @error('shipping_ward') is-invalid @enderror"
                                        value="{{ old('shipping_ward') }}" placeholder="Phường 1" required>
                                    @error('shipping_ward')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Quận/Huyện <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="shipping_district"
                                        class="form-control @error('shipping_district') is-invalid @enderror"
                                        value="{{ old('shipping_district') }}" placeholder="Quận 1" required>
                                    @error('shipping_district')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Tỉnh/Thành Phố <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="shipping_city"
                                        class="form-control @error('shipping_city') is-invalid @enderror"
                                        value="{{ old('shipping_city') }}" placeholder="TP. Hồ Chí Minh" required>
                                    @error('shipping_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Ghi Chú</label>
                                    <textarea name="note" class="form-control" rows="2"
                                        placeholder="Ghi chú thêm về đơn hàng (nếu có)">{{ old('note') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Phương Thức Thanh Toán -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-credit-card"></i> Phương Thức Thanh Toán
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="payment-method active" onclick="selectPayment('cod', this)">
                                        <input type="radio" name="payment_method" value="cod" checked hidden>
                                        <div class="text-center">
                                            <i class="fas fa-money-bill-wave fa-3x text-success mb-2"></i>
                                            <h6>COD</h6>
                                            <small class="text-muted">Thanh toán khi nhận hàng</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="payment-method" onclick="selectPayment('bank_transfer', this)">
                                        <input type="radio" name="payment_method" value="bank_transfer" hidden>
                                        <div class="text-center">
                                            <i class="fas fa-university fa-3x text-primary mb-2"></i>
                                            <h6>Chuyển Khoản</h6>
                                            <small class="text-muted">Chuyển khoản ngân hàng</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="payment-method" onclick="selectPayment('momo', this)">
                                        <input type="radio" name="payment_method" value="momo" hidden>
                                        <div class="text-center">
                                            <i class="fas fa-wallet fa-3x text-danger mb-2"></i>
                                            <h6>MoMo</h6>
                                            <small class="text-muted">Ví điện tử MoMo</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info mt-3 mb-0">
                                <i class="fas fa-info-circle"></i>
                                <strong>Lưu ý:</strong> Đơn hàng sẽ được xử lý sau khi xác nhận thanh toán thành công.
                            </div>
                        </div>
                    </div>

                    <!-- Mã Giảm Giá / Voucher -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-tags"></i> Mã Giảm Giá / Voucher
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Input Voucher Code -->
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-lg" id="voucherCode"
                                    placeholder="Nhập mã giảm giá" style="border: 2px solid #28a745;">
                                <button class="btn btn-success btn-lg" type="button" onclick="applyVoucher()">
                                    <i class="fas fa-check"></i> Áp Dụng
                                </button>
                            </div>

                            <!-- Applied Voucher Display -->
                            <div id="appliedVoucherDisplay" class="d-none">
                                <div class="alert alert-success d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-check-circle"></i>
                                        <strong>Mã "<span id="displayVoucherCode"></span>" đã được áp dụng!</strong>
                                        <br>
                                        <small>Giảm: <span id="displayVoucherDiscount"
                                                class="text-danger fw-bold"></span></small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVoucher()">
                                        <i class="fas fa-times"></i> Hủy
                                    </button>
                                </div>
                            </div>

                            <!-- Available Vouchers -->
                            <div class="mt-3">
                                <h6 class="mb-3">
                                    <i class="fas fa-gift"></i> Voucher Có Sẵn
                                </h6>
                                <div class="row g-3" id="voucherList">
                                    @foreach($availableVouchers as $voucher)
                                        <div class="col-md-6">
                                            <div class="voucher-item" onclick="selectVoucher('{{ $voucher->code }}', this)">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <span class="discount-tag">{{ $voucher->code }}</span>
                                                        <p class="mb-1 mt-2">
                                                            @if($voucher->type === 'percent')
                                                                <strong class="text-danger">Giảm {{ $voucher->value }}%</strong>
                                                                @if($voucher->max_discount)
                                                                    <br><small class="text-muted">(Tối đa
                                                                        {{ number_format($voucher->max_discount) }}đ)</small>
                                                                @endif
                                                            @else
                                                                <strong class="text-danger">Giảm
                                                                    {{ number_format($voucher->value) }}đ</strong>
                                                            @endif
                                                        </p>
                                                        <p class="mb-0 small text-muted">
                                                            <i class="fas fa-shopping-cart"></i>
                                                            Đơn tối thiểu: {{ number_format($voucher->min_order) }}đ
                                                        </p>
                                                        <p class="mb-0 small text-muted">
                                                            <i class="fas fa-clock"></i>
                                                            HSD:
                                                            {{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                        onclick="event.stopPropagation(); applyVoucherDirect('{{ $voucher->code }}')">
                                                        Áp dụng
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="col-lg-5">
                    <div class="card shadow-lg sticky-top" style="top: 20px;">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-clipboard-list"></i> Thông Tin Đơn Hàng
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Products List -->
                            <div class="mb-3" style="max-height: 300px; overflow-y: auto;">
                                @foreach($cart->items as $item)
                                    <div class="d-flex mb-3 pb-3 border-bottom">
                                        <img src="{{ asset('images/products/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            style="width: 60px; height: 60px; object-fit: cover;" class="rounded me-3">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ Str::limit($item->product->name, 40) }}</h6>
                                            <small class="text-muted">{{ $item->product->brand->name }}</small>
                                            <div class="d-flex justify-content-between mt-1">
                                                <span class="text-muted">x{{ $item->quantity }}</span>
                                                <strong class="text-primary">{{ number_format($item->subtotal) }}đ</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr>

                            <!-- Price Breakdown -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tạm tính:</span>
                                    <strong id="subtotalDisplay">{{ number_format($cart->total) }}đ</strong>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Phí vận chuyển:</span>
                                    <strong id="shippingFeeDisplay">30,000đ</strong>
                                </div>

                                <div class="d-flex justify-content-between mb-2" id="discountRow"
                                    style="display: none!important;">
                                    <span class="text-success">
                                        <i class="fas fa-tag"></i> Giảm giá:
                                    </span>
                                    <strong class="text-success" id="discountDisplay">-0đ</strong>
                                </div>
                            </div>

                            <hr>

                            <!-- Total -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Tổng cộng:</h4>
                                <h3 class="mb-0 text-danger" id="totalDisplay">
                                    {{ number_format($cart->total + 30000) }}đ
                                </h3>
                            </div>

                            <!-- Hidden inputs for calculation -->
                            <input type="hidden" id="originalTotal" value="{{ $cart->total + 30000 }}">
                            <input type="hidden" id="subtotal" value="{{ $cart->total }}">
                            <input type="hidden" id="shippingFee" value="30000">
                            <input type="hidden" name="total" id="finalTotal" value="{{ $cart->total + 30000 }}">

                            <!-- Checkout Button -->
                            <button type="submit" class="btn btn-danger btn-lg w-100 mb-3">
                                <i class="fas fa-check-circle"></i> Đặt Hàng
                            </button>

                            <a href="{{ route('client.cart.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left"></i> Quay Lại Giỏ Hàng
                            </a>

                            <!-- Security -->
                            <div class="text-center mt-4 pt-3 border-top">
                                <i class="fas fa-lock text-success fa-2x mb-2"></i>
                                <p class="small text-muted mb-0">
                                    <strong>Thanh toán an toàn & bảo mật</strong><br>
                                    Thông tin của bạn được mã hóa
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        // Payment method selection
        function selectPayment(method, element) {
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('active');
            });
            element.classList.add('active');
            element.querySelector('input').checked = true;
        }

        // Voucher selection
        function selectVoucher(code, element) {
            document.querySelectorAll('.voucher-item').forEach(el => {
                el.classList.remove('selected');
            });
            element.classList.add('selected');
            document.getElementById('voucherCode').value = code;
        }

        // Apply voucher directly
        function applyVoucherDirect(code) {
            document.getElementById('voucherCode').value = code;
            applyVoucher();
        }

        // Apply voucher
        function applyVoucher() {
            const code = document.getElementById('voucherCode').value.trim();

            if (!code) {
                alert('Vui lòng nhập mã giảm giá');
                return;
            }

            // AJAX call to validate voucher
            fetch('{{ route("client.checkout.apply-voucher") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: code })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Display applied voucher
                        document.getElementById('appliedVoucherCode').value = code;
                        document.getElementById('displayVoucherCode').textContent = code;
                        document.getElementById('displayVoucherDiscount').textContent = formatNumber(data.discount) + 'đ';
                        document.getElementById('appliedVoucherDisplay').classList.remove('d-none');

                        // Update totals
                        updateTotals(data.discount);

                        // Show success message
                        showToast('success', 'Áp dụng voucher thành công!');
                    } else {
                        showToast('error', data.message || 'Mã giảm giá không hợp lệ');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'Có lỗi xảy ra, vui lòng thử lại');
                });
        }

        // Remove voucher
        function removeVoucher() {
            document.getElementById('voucherCode').value = '';
            document.getElementById('appliedVoucherCode').value = '';
            document.getElementById('appliedVoucherDisplay').classList.add('d-none');

            // Reset voucher selection
            document.querySelectorAll('.voucher-item').forEach(el => {
                el.classList.remove('selected');
            });

            // Reset totals
            updateTotals(0);

            showToast('info', 'Đã hủy mã giảm giá');
        }

        // Update totals
        function updateTotals(discount) {
            const subtotal = parseInt(document.getElementById('subtotal').value);
            const shippingFee = parseInt(document.getElementById('shippingFee').value);
            const total = subtotal + shippingFee - discount;

            document.getElementById('totalDisplay').textContent = formatNumber(total) + 'đ';
            document.getElementById('finalTotal').value = total;

            if (discount > 0) {
                document.getElementById('discountDisplay').textContent = '-' + formatNumber(discount) + 'đ';
                document.getElementById('discountRow').style.display = 'flex';
            } else {
                document.getElementById('discountRow').style.display = 'none';
            }
        }

        // Format number
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Show toast notification
        function showToast(type, message) {
            const bgColor = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
            const toast = `
                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                        <div class="toast show ${bgColor} text-white" role="alert">
                            <div class="toast-body">
                                ${message}
                            </div>
                        </div>
                    </div>
                `;
            document.body.insertAdjacentHTML('beforeend', toast);
            setTimeout(() => {
                document.querySelector('.toast').remove();
            }, 3000);
        }
    </script>
@endsection