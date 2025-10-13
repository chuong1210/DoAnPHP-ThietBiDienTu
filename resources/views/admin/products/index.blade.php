@extends('admin.layouts.admin')

@section('title', 'Quản Lý Sản Phẩm')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0">Quản Lý Sản Phẩm</h1>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm Sản Phẩm
                </a>
            </div>
        </div>

        <!-- Thông báo -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Bộ lọc và tìm kiếm -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.products.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm theo tên hoặc mô tả..."
                                value="{{ request('keyword') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="category_id" class="form-select">
                                <option value="">-- Tất cả danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="brand_id" class="form-select">
                                <option value="">-- Tất cả thương hiệu --</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">-- Tất cả trạng thái --</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Lọc
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Thương hiệu</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Nổi bật</th>
                                <th>Lượt xem</th>
                                <th>Đã bán</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ Str::limit($product->name, 40) }}</strong>
                                        @if($product->sale_price)
                                            <br><small class="text-danger">Giá KM: {{ number_format($product->sale_price) }}đ</small>
                                        @endif
                                    </td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                    <td>
                                        {{ number_format($product->price) }}đ
                                        @if($product->sale_price)
                                            <br><small class="text-decoration-line-through text-muted">{{ number_format($product->sale_price) }}đ</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $product->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->is_featured ? 'bg-warning' : 'bg-secondary' }}">
                                            {{ $product->is_featured ? 'Có' : 'Không' }}
                                        </span>
                                    </td>
                                    <td>{{ $product->view_count }}</td>
                                    <td>{{ $product->sold_count }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Không có sản phẩm nào.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="pagination-info">
        {{ $products->appends(request()->query())->onEachSide(1)->render() }} <!-- Custom render nếu cần -->
    </div>

                @endif
            </div>
        </div>
    </div>
@endsection
