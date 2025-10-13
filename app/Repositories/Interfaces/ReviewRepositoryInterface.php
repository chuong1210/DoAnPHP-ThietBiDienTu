<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface ReviewRepositoryInterface extends BaseRepositoryInterface
{
    public function getApprovedReviewsByProduct($productId, $limit = 10);
    public function getPendingReviews($perPage = 20);
    public function getReviewsByUser($userId);
    public function getAverageRatingByProduct($productId);
    public function createReview($data);
    public function approveReview($id);
    public function rejectReview($id, $reason = null);
    public function deleteReview($id);
}
