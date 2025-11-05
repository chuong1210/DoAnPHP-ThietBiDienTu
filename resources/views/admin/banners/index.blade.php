@extends('admin.layouts.admin')

@section('title', 'Quản Lý Banner')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Quản Lý Banner</h1>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.banners.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm banner..." value="{{ request('keyword') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
        </form>

        <!-- Add Button -->
        <a href="{{ route('admin.banners.create') }}" class="btn btn-success mb-4">
            <i class="fas fa-plus"></i> Thêm Banner
        </a>

        <!-- Banner Table -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Hình ảnh</th>
                                <th>Liên kết</th>
                                <th>Thứ tự</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($banners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>{{ $banner->title }}</td>
                                    <td>
                                        @if ($banner->image && file_exists(public_path('images/' . $banner->image)))
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $banner->id }}">
                                                <img src="{{ asset('images/' . $banner->image) }}" alt="{{ $banner->title }}" style="max-width: 100px;">
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="imageModal{{ $banner->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $banner->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="imageModalLabel{{ $banner->id }}">{{ $banner->title }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('images/' . $banner->image) }}" alt="{{ $banner->title }}" style="max-width: 100%; height: auto;">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-danger">Ảnh không tồn tại</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($banner->link)
                                            <a href="{{ $banner->link }}" target="_blank">{{ \Illuminate\Support\Str::limit($banner->link, 30) }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $banner->sort_order }}</td>
                                    <td>
                                        <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $banner->is_active ? 'Hiển thị' : 'Ẩn' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Không có banner nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $banners->links() }}
            </div>
        </div>
    </div>
@endsection