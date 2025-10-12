<?php
// ==========================================
// CATEGORY REPOSITORY
// ==========================================
namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    public function getActiveCategories()
    {
        $condition = [['is_active', '=', true]];
        return $this->findByCondition($condition, true, [], ['name', 'ASC']);
    }

    public function getParentCategories()
    {
        return $this->model->whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get();
    }

    public function getCategoriesWithChildren()
    {
        return $this->model->with('children')->whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get();
    }

    public function getSidebarCategories()
    {
        return $this->model->with('children')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->get();
    }
}
