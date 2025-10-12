

@extends('layouts.admin')

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
                                <img src="{{ asset('images/products/' . $product->image) }}"
                                     alt="{{ $product->name }}"
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
                                    <td>{{ $product->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Thương hiệu:</th>
                                    <td>{{ $product->brand->name }}</td>
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
                                            -{{ $product->discount_percent }}%
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
                    <p><strong>Ngày tạo:</strong> {{ $product->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Cập nhật:</strong> {{ $product->updated_at->format('d/m/Y H:i') }}</p>
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
                        @if($product->average_rating > 0)
                            <span class="text-warning">
                                {{ number_format($product->average_rating, 1) }}/5
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
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="brand_id" class="form-control">
                            <option value="">-- Tất cả thương hiệu --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bảng danh sách -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Danh Mục</th>
                            <th>Thương Hiệu</th>
                            <th>Giá</th>
                            <th>Số Lượng</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('images/products/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <span class="text-muted">Không có ảnh</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->is_featured)
                                    <span class="badge bg-warning">Nổi bật</span>
                                @endif
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->brand->name }}</td>
                            <td>
                                @if($product->sale_price)
                                    <span class="text-danger">
                                        <strong>{{ number_format($product->sale_price) }}đ</strong>
                                    </span>
                                    <br>
                                    <span class="text-muted text-decoration-line-through">
                                        {{ number_format($product->price) }}đ
                                    </span>
                                @else
                                    <strong>{{ number_format($product->price) }}đ</strong>
                                @endif
                            </td>
                            <td>
                                @if($product->quantity > 0)
                                    <span class="badge bg-success">{{ $product->quantity }}</span>
                                @else
                                    <span class="badge bg-danger">Hết hàng</span>
                                @endif
                            </td>
                            <td>
                                @if($product->status === 'active')
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Không hoạt động</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                       class="btn btn-sm btn-info" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                       class="btn btn-sm btn-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <p class="text-muted mb-0">Không tìm thấy sản phẩm nào</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
