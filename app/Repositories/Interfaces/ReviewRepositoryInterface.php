<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface ReviewRepositoryInterface extends BaseRepositoryInterface
{
    public function getApprovedReviewsByProduct($productId, $perPage = 10);
    public function getAverageRating($productId);
    public function createReview($data);
    public function getPendingReviews($perPage = 20);
    public function approveReview($id);
    public function rejectReview($id);
    public function getReviewsByUser($userId, $perPage = 10);
}
