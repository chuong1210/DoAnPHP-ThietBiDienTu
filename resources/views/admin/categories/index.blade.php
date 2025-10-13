@extends('admin.layouts.admin')

@section('title', 'Quản Lý danh mục')
@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0">Quản Lý Danh Mục</h1>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Thêm Danh Mục</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên Danh Mục</th>
                            <th>Slug</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Không hoạt động</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.index', $category->id) }}"
                                        class="btn btn-sm btn-info">Xem</a>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="btn btn-sm btn-warning">Sửa</a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                        style="display:inline" onsubmit="return confirm('Xác nhận xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="mt-3">
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="pagination-info">
                            {{ $categories->appends(request()->query())->onEachSide(1)->render() }}
                            <!-- Custom render nếu cần -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection