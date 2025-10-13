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

    /**
     * Lấy reviews đã duyệt cho sản phẩm (client)
     */
    public function getApprovedReviewsByProduct($productId, $limit = 10)
    {
        return $this->model->with('user')
            ->where('product_id', $productId)
            ->where('status', 'approved')
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * Lấy reviews đang chờ duyệt (admin)
     */
    public function getPendingReviews($perPage = 20)
    {
        return $this->pagination(
            ['*'],
            ['where' => [['status', '=', 'pending']]],
            $perPage,
            [],
            ['user', 'product'],
            ['created_at', 'DESC']
        );
    }

    /**
     * Lấy reviews của user
     */
    public function getReviewsByUser($userId)
    {
        return $this->model->with(['product', 'product.brand'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * Tính điểm đánh giá trung bình cho sản phẩm
     */
    public function getAverageRatingByProduct($productId)
    {
        return $this->model->where('product_id', $productId)
            ->where('status', 'approved')
            ->avg('rating') ?? 0;
    }

    /**
     * Tạo review mới (client, sau khi mua hàng)
     */
    public function createReview($data)
    {
        DB::beginTransaction();
        try {
            // Kiểm tra user đã mua sản phẩm chưa (qua order_items)
            $hasPurchased = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.user_id', Auth::id())
                ->where('order_items.product_id', $data['product_id'])
                ->whereIn('orders.status', ['delivered'])
                ->exists();

            if (!$hasPurchased) {
                throw new \Exception('Bạn chỉ có thể đánh giá sản phẩm đã mua.');
            }

            // Kiểm tra user chưa review sản phẩm này
            $existingReview = $this->model->where('user_id', Auth::id())
                ->where('product_id', $data['product_id'])
                ->whereIn('status', ['approved', 'pending'])
                ->first();

            if ($existingReview) {
                throw new \Exception('Bạn đã đánh giá sản phẩm này rồi.');
            }

            $data['status'] = 'pending'; // Chờ duyệt
            $review = $this->create($data);

            DB::commit();
            return $review;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Duyệt review (admin)
     */
    public function approveReview($id)
    {
        return $this->update($id, ['status' => 'approved']);
    }

    /**
     * Từ chối review (admin)
     */
    public function rejectReview($id, $reason = null)
    {
        $data = ['status' => 'rejected'];
        if ($reason) {
            $data['comment'] = $reason; // Có thể append reason vào comment
        }
        return $this->update($id, $data);
    }

    /**
     * Xóa review (admin)
     */
    public function deleteReview($id)
    {
        return $this->delete($id);
    }
}
