<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ReviewRepository;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Hiển thị danh sách review chờ duyệt
     * GET /admin/reviews
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending'); // Mặc định pending
        $conditions = [
            'where' => [['status', '=', $status]]
        ];

        $reviews = $this->reviewRepository->pagination(
            ['*'],
            $conditions,
            20,
            [],
            ['user', 'product'],
            ['created_at', 'DESC']
        );

        return view('admin.reviews.index', compact('reviews', 'status'));
    }

    /**
     * Duyệt review
     * POST /admin/reviews/{id}/approve
     */
    public function approve($id)
    {
        try {
            $this->reviewRepository->approveReview($id);
            return redirect()->route('admin.reviews.index')
                ->with('success', 'Đã duyệt đánh giá thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Từ chối review
     * POST /admin/reviews/{id}/reject
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:255'
        ]);

        try {
            $this->reviewRepository->rejectReview($id);

            // Nếu có lý do, có thể lưu vào log hoặc update thêm field nếu có
            if ($request->reason) {
                // Giả sử có field 'reject_reason' trong model
                $this->reviewRepository->update($id, ['reject_reason' => $request->reason]);
            }

            return redirect()->route('admin.reviews.index')
                ->with('success', 'Đã từ chối đánh giá thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Xóa review
     * DELETE /admin/reviews/{id}
     */
    public function destroy($id)
    {
        try {
            $this->reviewRepository->delete($id);
            return redirect()->route('admin.reviews.index')
                ->with('success', 'Đã xóa đánh giá thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
