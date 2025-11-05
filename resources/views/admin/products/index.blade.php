@extends('admin.layouts.admin')

@section('title', 'Quản Lý Sản Phẩm')
@section('page-title', 'Quản Lý Sản Phẩm')

@section('styles')
    <style>
        /* Nút Thêm Mới */
        .btn-add-product {
            background: var(--primary-gradient);
            color: rgb(21, 177, 204);

            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 59, 63, 0.3);
            transition: all 0.3s ease;
        }

        .btn-add-product:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 59, 63, 0.4);
        }

        /* Bảng Dữ Liệu */
        .table thead th {
            background-color: var(--bg-main);
            color: var(--text-dark);
            font-weight: 600;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: var(--bg-main);
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
            background-color: #f8f9fa;
            padding: 5px;
            border: 1px solid var(--border-color);
        }

        .badge-status {
            font-size: 0.8rem;
            padding: 0.4em 0.8em;
            border-radius: 20px;
            font-weight: 500;
        }

        .badge-status.active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-status.inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-quantity {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .badge-featured {
            background-color: #fef3c7;
            color: #92400e;
        }

        /* Nút Hành Động trong bảng */
        .action-buttons .btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s ease;
            border: none;
        }

        .action-buttons .btn-info {
            background-color: #cffafe;
            color: #0e7490;
        }

        .action-buttons .btn-info:hover {
            background-color: #a5f3fc;
        }

        .action-buttons .btn-warning {
            background-color: #ffedd5;
            color: #9a3412;
        }

        .action-buttons .btn-warning:hover {
            background-color: #fed7aa;
        }

        .action-buttons .btn-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .action-buttons .btn-danger:hover {
            background-color: #fecaca;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Danh Sách Sản Phẩm</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-add-product">
            <i class="fas fa-plus me-2"></i> Thêm Sản Phẩm Mới
        </a>
    </div>

    <!-- Bộ lọc và tìm kiếm -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.products.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm theo tên..."
                            value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="category_id" class="form-select">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="brand_id" class="form-select">
                            <option value="">Tất cả thương hiệu</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Tất cả trạng thái</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang bán</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Ngừng bán
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Lọc</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary w-100"><i
                                class="fas fa-sync-alt"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="width: 80px;">Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Danh Mục</th>
                            <th>Thương Hiệu</th>
                            <th>Giá</th>
                            <th>Kho</th>
                            <th class="text-center">Trạng Thái</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td><strong>{{ $product->id }}</strong></td>
                                <td>
                                    <img src="{{ asset($product->image ?? 'https://cdn.presslabs.com/wp-content/uploads/2018/10/upload-error.png') }}"
                                        alt="{{ $product->name }}" class="product-image">
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="fw-bold text-dark text-decoration-none">
                                        {{ Str::limit($product->name, 45) }}
                                    </a>
                                    @if($product->is_featured)
                                        <span class="badge badge-featured ms-1" title="Sản phẩm nổi bật">Nổi bật</span>
                                    @endif
                                </td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                <td>
                                    @if($product->sale_price)
                                        <span class="text-danger fw-bold">{{ number_format($product->sale_price) }}đ</span>
                                        <br>
                                        <small
                                            class="text-decoration-line-through text-muted">{{ number_format($product->price) }}đ</small>
                                    @else
                                        <span class="fw-bold">{{ number_format($product->price) }}đ</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-quantity">{{ $product->quantity }}</span>
                                </td>
                                <td class="text-center">
                                    @if($product->status == 'active')
                                        <span class="badge badge-status active">Đang bán</span>
                                    @else
                                        <span class="badge badge-status inactive">Ngừng bán</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons btn-group">
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info"
                                            title="Xem">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning"
                                            title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Mọi dữ liệu liên quan cũng sẽ bị ảnh hưởng.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <p class="mb-0">Không có sản phẩm nào.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
