<?php
// ==========================================
// REVIEW REPOSITORY
// ==========================================
namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    public function __construct(Review $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }


    public function getApprovedReviewsByProduct($productId)
    {
        return $this->model->with('user')
            ->where('product_id', $productId)
            ->where('status', 'approved')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getPendingReviews()
    {
        return $this->model->with(['user', 'product'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function approveReview($id)
    {
        return $this->update($id, ['status' => 'approved']);
    }

    public function rejectReview($id)
    {
        return $this->update($id, ['status' => 'rejected']);
    }
}
