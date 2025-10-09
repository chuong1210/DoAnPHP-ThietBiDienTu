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
}
