@extends('admin.layouts.admin')

@section('title', 'Quản Lý Thương Hiệu')
@section('page-title', 'Quản Lý Thương Hiệu')

@section('styles')
    <style>
        /* Nút Thêm Mới */
        .btn-add-brand {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 59, 63, 0.3);
            transition: all 0.3s ease;
        }

        .btn-add-brand:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 59, 63, 0.4);
        }

        /* Form Tìm Kiếm */
        .search-form .form-control {
            border-radius: 10px;
            border: 2px solid var(--border-color);
            background-color: var(--bg-white);
        }

        .search-form .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(255, 59, 63, 0.1);
        }

        .btn-filter {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-reset {
            background-color: transparent;
            border: 2px solid var(--border-color);
            color: var(--text-dark);
        }

        /* Bảng Dữ Liệu */
        .table thead th {
            background-color: var(--bg-main);
            color: var(--text-dark);
            font-weight: 600;
            border-bottom: 2px solid var(--border-color);
        }

        .table tbody tr:hover {
            background-color: var(--bg-main);
        }

        .brand-logo {
            width: 50px;
            height: 50px;
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
        }

        .badge-status.active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-status.inactive {
            background-color: #fee2e2;
            color: #991b1b;
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
        }

        .action-buttons .btn-edit {
            background-color: #ffedd5;
            color: #9a3412;
        }

        .action-buttons .btn-edit:hover {
            background-color: #fed7aa;
        }

        .action-buttons .btn-delete {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .action-buttons .btn-delete:hover {
            background-color: #fecaca;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Danh Sách Thương Hiệu</h5>
            <a href="{{ route('admin.brands.create') }}" class="btn btn-add-brand">
                <i class="fas fa-plus me-2"></i> Thêm Mới
            </a>
        </div>

        <div class="card-body">
            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.brands.index') }}" class="mb-4 search-form">
                <div class="row g-3 align-items-center">
                    <div class="col-md-9">
                        <input type="text" name="keyword" class="form-control"
                            placeholder="Tìm kiếm theo tên thương hiệu..." value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-filter w-100"><i class="fas fa-search"></i> Tìm</button>
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-reset w-100"><i
                                class="fas fa-sync-alt"></i></a>
                    </div>
                </div>
            </form>

            <!-- Brands Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Logo</th>
                            <th>Tên Thương Hiệu</th>
                            <th>Slug</th>
                            <th>Trạng Thái</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $brand)
                            <tr>
                                <td><strong>{{ $brand->id }}</strong></td>
                                <td>
                                    <img src="{{ asset($brand->logo ?? 'https://static.vecteezy.com/system/resources/previews/016/916/479/original/placeholder-icon-design-free-vector.jpg') }}"
                                        alt="{{ $brand->name }}" class="brand-logo">
                                </td>
                                <td>{{ $brand->name }}</td>
                                <td><code class="text-muted">{{ $brand->slug }}</code></td>
                                <td>
                                    @if($brand->is_active)
                                        <span class="badge badge-status active">Hoạt động</span>
                                    @else
                                        <span class="badge badge-status inactive">Tạm ẩn</span>
                                    @endif
                                </td>
                                <td class="text-center action-buttons">
                                    <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-edit"
                                        title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="mb-0">Không tìm thấy thương hiệu nào.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($brands->hasPages())
                <div class="mt-4">
                    {{ $brands->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection