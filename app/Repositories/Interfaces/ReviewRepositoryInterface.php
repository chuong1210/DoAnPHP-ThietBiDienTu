<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface ReviewRepositoryInterface extends BaseRepositoryInterface
{
    public function getApprovedReviewsByProduct($productId);
    public function getPendingReviews();
    public function approveReview($id);
    public function rejectReview($id);
}
