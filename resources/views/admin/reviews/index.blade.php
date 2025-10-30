@extends('admin.layouts.admin')

@section('title', 'Quản Lý Đánh Giá')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Quản Lý Đánh Giá</h1>

    <form method="GET" action="{{ route('admin.reviews.index') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm đánh giá..." value="{{ request('keyword') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Lọc
                </button>
            </div>
        </div>
    </form>

    <a href="{{ route('admin.reviews.create') }}" class="btn btn-success mb-4">
        <i class="fas fa-plus"></i> Thêm Đánh Giá
    </a>

    <div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nội dung</th>
                        <th>Người dùng</th>
                        <th>Sản phẩm</th>
                        <th>Trạng thái</th>
                        <th>Đánh giá</th> <!-- cột mới -->
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($review->comment, 50) }}</td>
                            <td>{{ $review->user_name }}</td>
                            <td>{{ $review->product->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $review->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $review->is_active ? 'Hiển thị' : 'Ẩn' }}
                                </span>
                            </td>

                            <!-- Cột Đánh giá -->
                            <td>
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </td>

                            <td>
                                <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?');">
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
                            <td colspan="7" class="text-center">Không có đánh giá nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $reviews->links() }}
    </div>
</div>
</div>
@endsection
