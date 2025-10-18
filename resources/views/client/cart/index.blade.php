@extends('client.layouts.client')

@section('title', 'Giỏ Hàng')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-shopping-cart"></i> Giỏ Hàng Của Bạn
            </h3>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($cart && $cart->items->count() > 0)
                <div class="row">
                    <!-- Cart Items -->
                    <div class="col-md-8">
                        <div class="card">
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
                                            @foreach($cart->items as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($item->product->image)
                                                                <img src="{{ asset($item->product->image) }}"
                                                                    alt="{{ $item->product->name }}"
                                                                    style="width: 80px; height: 80px; object-fit: cover;"
                                                                    class="rounded me-3">
                                                            @endif
                                                            <div>
                                                                <h6 class="mb-1">
                                                                    <a href="{{ route('client.product.show', $item->product->slug) }}"
                                                                        class="text-decoration-none text-dark">
                                                                        {{ $item->product->name }}
                                                                    </a>
                                                                </h6>
                                                                <small class="text-muted">{{ $item->product->brand->name }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <strong>{{ number_format($item->price) }}đ</strong>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('client.cart.update', $item->id) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="input-group input-group-sm">
                                                                <button type="button" class="btn btn-outline-secondary"
                                                                    onclick="updateQty({{ $item->id }}, -1, {{ $item->product->quantity }})">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                                <input type="number" name="quantity" id="qty{{ $item->id }}"
                                                                    class="form-control text-center" value="{{ $item->quantity }}"
                                                                    min="1" max="{{ $item->product->quantity }}"
                                                                    onchange="this.form.submit()">
                                                                <button type="button" class="btn btn-outline-secondary"
                                                                    onclick="updateQty({{ $item->id }}, 1, {{ $item->product->quantity }})">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <strong class="text-danger">
                                                            {{ number_format($item->subtotal) }}đ
                                                        </strong>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('client.cart.remove', $item->id) }}" method="POST"
                                                            onsubmit="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('client.product.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left"></i> Tiếp Tục Mua Sắm
                            </a>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Thông Tin Đơn Hàng</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Tạm tính:</span>
                                    <strong>{{ number_format($cart->total) }}đ</strong>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span>Phí vận chuyển:</span>
                                    <strong>30,000đ</strong>
                                </div>

                                @if(session('coupon'))
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Mã giảm giá ({{ session('coupon.code') }}):</span>
                                        <strong class="text-success">-{{ number_format(session('coupon.discount')) }}đ</strong>
                                    </div>
                                @endif

                                <hr>

                                <div class="d-flex justify-content-between mb-4">
                                    <h5>Tổng cộng:</h5>
                                    <h5 class="text-danger">
                                        {{ number_format($cart->total + 30000 - (session('coupon.discount') ?? 0)) }}đ
                                    </h5>
                                </div>

                                <div class="d-grid gap-2">
                                    <a href="{{ route('client.checkout.index') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-credit-card"></i> Thanh Toán
                                    </a>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#couponModal">
                                        <i class="fas fa-tag"></i> Nhập Mã Giảm Giá
                                    </button>
                                </div>

                                <!-- Payment Methods -->
                                <div class="mt-4 pt-3 border-top">
                                    <h6 class="mb-3">Phương thức thanh toán</h6>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <img src="https://via.placeholder.com/50x30?text=COD" alt="COD">
                                        <img src="https://via.placeholder.com/50x30?text=MOMO" alt="Momo">
                                        <img src="https://via.placeholder.com/50x30?text=VISA" alt="Visa">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security -->
                        <div class="card mt-3">
                            <div class="card-body text-center">
                                <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
                                <h6>Mua Hàng An Toàn</h6>
                                <p class="small text-muted mb-0">
                                    Thanh toán được mã hóa SSL<br>
                                    Bảo vệ thông tin khách hàng
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty Cart -->
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                        <h4>Giỏ Hàng Trống</h4>
                        <p class="text-muted mb-4">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                        <a href="{{ route('client.product.index') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag"></i> Mua Sắm Ngay
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Coupon Modal -->
    <div class="modal fade" id="couponModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nhập Mã Giảm Giá</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="couponForm" action="{{ route('client.checkout.apply-coupon') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Mã giảm giá</label>
                            <div class="input-group">
                                <input type="text" name="code" id="couponCode" class="form-control"
                                    placeholder="Nhập mã giảm giá" required>
                                <button type="submit" class="btn btn-primary">Áp Dụng</button>
                            </div>
                            @error('code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>

                    <hr>

                    <div class="mt-4">
                        <h6>Mã giảm giá có sẵn:</h6>
                        @if($coupons->count() > 0)
                            <div class="list-group">
                                @foreach($coupons as $coupon)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong class="text-primary">{{ $coupon->code }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    @if($coupon->type === 'percent')
                                                        Giảm {{ $coupon->value }}% (từ {{ number_format($coupon->min_order) }}đ)
                                                    @else
                                                        Giảm {{ number_format($coupon->value) }}đ (từ
                                                        {{ number_format($coupon->min_order) }}đ)
                                                    @endif
                                                    @if($coupon->end_date)
                                                        - Hết hạn: {{ $coupon->end_date->format('d/m/Y') }}
                                                    @endif
                                                </small>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="copyCoupon('{{ $coupon->code }}', this)">
                                                Sao chép
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Chưa có mã giảm giá nào.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
        // document.getElementById('couponForm').addEventListener('submit', function (e) {
        //     const code = document.getElementById('couponCode').value.trim();
        //     if (!code) {
        //         e.preventDefault();
        //         alert('Vui lòng nhập mã giảm giá');
        //         return;
        //     }
        // });



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
@endsection