<?php
// ==========================================
// REVIEW REPOSITORY
// ==========================================
namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    public function __construct(Review $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    public function hasUserReviewedProduct(int $productId, int $userId): bool
    {
        // exists() là phương thức cực kỳ tối ưu, nó chỉ kiểm tra sự tồn tại
        // và trả về true/false, nhanh hơn nhiều so với get() hoặc first().
        return $this->model
            ->where('product_id', $productId)
            ->where('user_id', $userId)
            ->exists();
    }
    /**
     * Lấy đánh giá đã duyệt của sản phẩm (paginated)
     */
    public function getApprovedReviewsByProduct($productId, $perPage = 10)
    {
        return $this->model->with(['user'])
            ->where('product_id', $productId)
            ->where('status', 'approved')
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Tính điểm đánh giá trung bình của sản phẩm
     */
    public function getAverageRating($productId)
    {
        return $this->model->where('product_id', $productId)
            ->where('status', 'approved')
            ->avg('rating') ?? 0;
    }

    /**
     * Tạo đánh giá mới (kiểm tra điều kiện)
     */
    public function createReview($data)
    {
        DB::beginTransaction();
        try {
            // Kiểm tra user đã mua sản phẩm chưa
            $hasOrdered = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.user_id', Auth::id())
                ->where('order_items.product_id', $data['product_id'])
                ->where('orders.status', 'delivered')
                ->exists();

            if (!$hasOrdered) {
                throw new \Exception('Bạn chưa mua sản phẩm này để có thể đánh giá.');
            }

            // Kiểm tra user chưa review sản phẩm này
            $existingReview = $this->model->where('product_id', $data['product_id'])
                ->where('user_id', Auth::id())
                ->first();

            if ($existingReview) {
                throw new \Exception('Bạn đã đánh giá sản phẩm này rồi.');
            }

            // ✅ Nếu có 'comment' thì ánh xạ sang 'content' để khớp với cột DB
            if (isset($data['comment']) && !isset($data['content'])) {
                $data['content'] = $data['comment'];
            }

            $review = $this->create($data);

            DB::commit();
            return $review;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    /**
     * Lấy danh sách review đang chờ duyệt (cho admin, paginated)
     */
    public function getPendingReviews($perPage = 20)
    {
        return $this->model->with(['user', 'product'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Duyệt review
     */
    public function approveReview($id)
    {
        return $this->update($id, [
            'status' => 'approved',
            'is_active' => true,
            'reject_reason' => null // reset lý do cũ nếu có
        ]);
    }


    /**
     * Từ chối review
     */
    public function rejectReview($id, $reason = null)
    {
        return $this->update($id, ['status' => 'rejected']);
    }

    /**
     * Lấy đánh giá của user (cho client profile)
     */
    public function getReviewsByUser($userId, $perPage = 10)
    {
        return $this->model->with(['product'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }
}
