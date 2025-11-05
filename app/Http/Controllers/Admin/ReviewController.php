<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Danh sách đánh giá - LỌC THEO TRẠNG THÁI
     */
    public function index(Request $request)
    {
        $status = $request->query('status'); // pending, approved, rejected

        $reviews = Review::with(['user', 'product'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews', 'status'));
    }

    /**
     * XEM CHI TIẾT ĐÁNH GIÁ
     */
    public function show($id)
    {
        $review = Review::with(['user', 'product'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * CẬP NHẬT TRẠNG THÁI (duyệt / từ chối)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $review = Review::findOrFail($id);
        $review->status = $request->status;
        $review->save();

        $message = match ($request->status) {
            'approved' => 'Đánh giá đã được duyệt và hiển thị!',
            'rejected' => 'Đánh giá đã bị từ chối.',
            default    => 'Trạng thái đã được cập nhật.'
        };

        return back()->with('success', $message);
    }

    /**
     * XÓA ĐÁNH GIÁ + ẢNH (nếu có)
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Xóa ảnh nếu tồn tại
        if ($review->image && file_exists(public_path('uploads/reviews/' . $review->image))) {
            unlink(public_path('uploads/reviews/' . $review->image));
        }

        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Xóa đánh giá thành công!');
    }
}
