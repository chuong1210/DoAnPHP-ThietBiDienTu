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
                                                                <img src="{{ asset('images/products/' . $item->product->image) }}"
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

                                <hr>

                                <div class="d-flex justify-content-between mb-4">
                                    <h5>Tổng cộng:</h5>
                                    <h5 class="text-danger">{{ number_format($cart->total + 30000) }}đ</h5>
                                </div>

                                <div class="d-grid gap-2">
                                    {{-- <a href="{{ route('client.checkout.index') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-credit-card"></i> Thanh Toán
                                    </a> --}}
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
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Mã giảm giá</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Nhập mã giảm giá">
                                <button type="submit" class="btn btn-primary">Áp Dụng</button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-4">
                        <h6>Mã giảm giá có sẵn:</h6>
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong class="text-primary">WELCOME10</strong>
                                        <br>
                                        <small class="text-muted">Giảm 10% đơn hàng từ 500k</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">Sao chép</button>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong class="text-primary">FREESHIP</strong>
                                        <br>
                                        <small class="text-muted">Miễn phí vận chuyển từ 300k</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">Sao chép</button>
                                </div>
                            </div>
                        </div>
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
    </script>
@endsection