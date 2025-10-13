@extends('admin.layouts.admin')

@section('title', 'Chi Tiết Sản Phẩm')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0">Chi Tiết Sản Phẩm</h1>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Sửa
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Hình ảnh và thông tin cơ bản -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                @if($product->image)
                                    <img src="{{ asset('' . $product->image) }}" alt="{{ $product->name }}"
                                        class="img-fluid rounded">
                                @else
                                    <div class="bg-light text-center py-5 rounded">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                        <p class="text-muted mt-2">Không có hình ảnh</p>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <h2 class="mb-3">{{ $product->name }}</h2>

                                <div class="mb-3">
                                    @if($product->is_featured)
                                        <span class="badge bg-warning text-dark">Nổi bật</span>
                                    @endif
                                    @if($product->status === 'active')
                                        <span class="badge bg-success">Đang hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Không hoạt động</span>
                                    @endif
                                </div>

                                <table class="table">
                                    <tr>
                                        <th width="150">Danh mục:</th>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Thương hiệu:</th>
                                        <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Giá gốc:</th>
                                        <td>
                                            <strong class="text-primary">{{ number_format($product->price) }}đ</strong>
                                        </td>
                                    </tr>
                                    @if($product->sale_price)
                                        <tr>
                                            <th>Giá khuyến mãi:</th>
                                            <td>
                                                <strong class="text-danger">{{ number_format($product->sale_price) }}đ</strong>
                                                <span class="badge bg-danger">
                                                    -{{ $product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0 }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>Số lượng:</th>
                                        <td>
                                            @if($product->quantity > 0)
                                                <span class="badge bg-success">{{ $product->quantity }}</span>
                                            @else
                                                <span class="badge bg-danger">Hết hàng</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Lượt xem:</th>
                                        <td>{{ number_format($product->view_count) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Đã bán:</th>
                                        <td>{{ number_format($product->sold_count) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mô tả -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Mô Tả Chi Tiết</h5>
                    </div>
                    <div class="card-body">
                        @if($product->description)
                            <p>{{ $product->description }}</p>
                        @else
                            <p class="text-muted">Chưa có mô tả</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Thông tin bổ sung -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thông Tin Khác</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>SKU:</strong> PRO-{{ $product->id }}</p>
                        <p><strong>Slug:</strong> {{ $product->slug }}</p>
                        <p><strong>Ngày tạo:</strong> {{ optional($product->created_at)->format('d/m/Y H:i') ?? 'Chưa có' }}
                        </p>
                        <p><strong>Cập nhật:</strong> {{ optional($product->updated_at)->format('d/m/Y H:i') ?? 'Chưa có' }}
                        </p>
                    </div>
                </div>

                <!-- Đánh giá -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Đánh Giá</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>Điểm trung bình:</strong>
                            @php
                                $averageRating = $product->reviews->avg('rating');
                            @endphp
                            @if($averageRating > 0)
                                <span class="text-warning">
                                    {{ number_format($averageRating, 1) }}/5
                                    <i class="fas fa-star"></i>
                                </span>
                            @else
                                <span class="text-muted">Chưa có đánh giá</span>
                            @endif
                        </p>
                        <p><strong>Số đánh giá:</strong> {{ $product->reviews->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection