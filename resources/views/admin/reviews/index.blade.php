@extends('admin.layouts.admin')

@section('title', 'Quản Lý Đánh Giá')

@section('content')
<div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
    <!-- Header -->
    <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">Quản Lý Đánh Giá</h1>
    </div>

    <!-- FLASH MESSAGE -->
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center mb-3" style="background-color: #E6F7E9; border: 1px solid #69DB7C; color: #1E293B; border-radius: 8px; padding: 12px 16px;" role="alert">
            <i class="fas fa-check-circle me-2" style="color: #69DB7C;"></i>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center mb-3" style="background-color: #FFE8ED; border: 1px solid #FF6B81; color: #1E293B; border-radius: 8px; padding: 12px 16px;" role="alert">
            <i class="fas fa-exclamation-triangle me-2" style="color: #FF6B81;"></i>
            <strong>{{ session('error') }}</strong>
        </div>
    @endif

    <!-- Lọc trạng thái -->
    <div class="d-flex justify-content-end align-items-center mb-3">
        <form method="GET" class="d-flex gap-2">
            <select name="status" class="form-select" style="width: auto; border-color: #F0D9DE; font-size: 0.9rem;" onchange="this.form.submit()">
                <option value="">Tất cả</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Từ chối</option>
            </select>
        </form>
    </div>

    <!-- Bảng danh sách -->
    <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white;">
                        <tr>
                            <th>ID</th>
                            <th>Người dùng</th>
                            <th>Sản phẩm</th>
                            <th>Nội dung</th>
                            <th>Điểm</th>
                            <th>Trạng thái</th>
                            <th>Thời gian</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr style="border-bottom: 1px solid #F0D9DE;">
                                <td style="color: #1E293B; font-weight: 500;">#{{ $review->id }}</td>

                                <!-- Người dùng: không bao giờ N/A -->
                                <td style="color: #1E293B;">
                                     {{ $review->user->full_name ?? 'Khách vãng lai' }}
                                </td>

                                <td style="color: #1E293B;">
                                    {{ $review->product->name ?? 'Sản phẩm đã xóa' }}
                                </td>

                                <td style="max-width: 220px; color: #1E293B; line-height: 1.5;">
                                    {{ Str::limit(strip_tags($review->comment), 60) }}
                                </td>

                                <td>
                                    <span style="color: #FF6B81; font-size: 1.1em;">
                                        @for($i = 0; $i < $review->rating; $i++) ⭐ @endfor
                                    </span>
                                    <small class="text-muted">({{ $review->rating }})</small>
                                </td>

                                <!-- Trạng thái -->
                                <td>
                                    @php
                                        $statusConfig = [
                                            'pending'   => ['label' => 'Chờ duyệt', 'bg' => '#FFD43B', 'text' => '#1E293B'],
                                            'approved'  => ['label' => 'Đã duyệt',  'bg' => '#69DB7C', 'text' => 'white'],
                                            'rejected'  => ['label' => 'Từ chối',   'bg' => '#FF6B81', 'text' => 'white'],
                                        ];
                                        $cfg = $statusConfig[$review->status] ?? ['label' => 'Không xác định', 'bg' => '#F0D9DE', 'text' => '#1E293B'];
                                    @endphp
                                    <span class="badge fw-medium px-2 py-1" style="background-color: {{ $cfg['bg'] }}; color: {{ $cfg['text'] }}; font-size: 0.8rem;">
                                        {{ $cfg['label'] }}
                                    </span>
                                </td>

                                <td style="color: #475569; font-size: 0.875rem;">
                                    {{ $review->created_at->format('d/m H:i') }}
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none; padding: 0.4rem 0.6rem;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Xóa vĩnh viễn đánh giá này?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background-color: #FF99AC; color: white; border: none; padding: 0.4rem 0.6rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5" style="color: #94A3B8;">
                                    <i class="fas fa-inbox fa-2x mb-3"></i><br>
                                    <span>Không có đánh giá nào.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div class="px-4 py-3 bg-white border-top" style="border-color: #F0D9DE !important;">
                {{ $reviews->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
