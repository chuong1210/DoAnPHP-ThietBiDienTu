@extends('admin.layouts.admin')

@section('title', 'Quản Lý Danh Mục')
@section('page-title', 'Quản Lý Danh Mục')

@section('styles')
    <style>
        /* Nút Thêm Mới */
        .btn-add-category {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 59, 63, 0.3);
            transition: all 0.3s ease;
        }

        .btn-add-category:hover {
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
            vertical-align: middle;
            /* Căn giữa chiều dọc cho header */
        }

        .table tbody tr:hover {
            background-color: var(--bg-main);
        }

        /* Thêm style cho ảnh danh mục */
        .category-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            /* Dùng 'cover' để ảnh lấp đầy khung */
            border-radius: 12px;
            background-color: #f8f9fa;
            padding: 5px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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

        /* Nút Hành Động trong bảng */
        .action-buttons .btn {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.2s ease;
            border: none;
        }

        .action-buttons .btn-edit {
            background-color: #ffedd5;
            color: #9a3412;
        }

        .action-buttons .btn-edit:hover {
            background-color: #fed7aa;
            transform: scale(1.1);
        }

        .action-buttons .btn-delete {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .action-buttons .btn-delete:hover {
            background-color: #fecaca;
            transform: scale(1.1);
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Danh Sách Danh Mục</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-add-category">
                <i class="fas fa-plus me-2"></i> Thêm Mới
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th> {{-- THÊM CỘT ẢNH --}}
                            <th>Tên Danh Mục</th>
                            <th>Slug</th>
                            <th>Trạng Thái</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td><strong>{{ $category->id }}</strong></td>
                                <td>
                                    {{-- THÊM HIỂN THỊ ẢNH --}}
                                    <img src="{{ asset($category->image ?? 'https://static.vecteezy.com/system/resources/previews/016/916/479/original/placeholder-icon-design-free-vector.jpg') }}"
                                        alt="{{ $category->name }}" class="category-image">
                                </td>
                                <td>
                                    <span class="fw-bold">{{ $category->name }}</span>
                                </td>
                                <td><code class="text-muted">{{ $category->slug }}</code></td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge badge-status active">Hoạt động</span>
                                    @else
                                        <span class="badge badge-status inactive">Tạm ẩn</span>
                                    @endif
                                </td>
                                <td class="text-center action-buttons">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-edit"
                                        title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Tất cả sản phẩm thuộc danh mục này cũng có thể bị ảnh hưởng.')">
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
                                <td colspan="6" class="text-center py-5"> {{-- Tăng colspan lên 6 --}}
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                    <p class="mb-0">Chưa có danh mục nào.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($categories->hasPages())
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection