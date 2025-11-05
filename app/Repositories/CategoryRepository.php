<?php

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
        return $this->findByCondition($condition, true, relation: [], orderBy: ['name', 'ASC']);
        // return $this->findByCondition($condition, false, [], ['name', 'ASC']);
    }

    public function getCategoriesTree()
    {
        return $this->model->with('children')->whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
    }

    public function getParentCategories($excludeId = null)
    {
        $query = $this->model->where('is_active', true);

        if ($excludeId) {
            // Loại bỏ chính nó
            $query->where('id', '!=', $excludeId);

            // (Tùy chọn) Lấy danh sách các danh mục con của nó để loại bỏ
            $childIds = $this->model->where('parent_id', $excludeId)->pluck('id')->toArray();
            if (!empty($childIds)) {
                $query->whereNotIn('id', $childIds);
            }
        }

        // Thường thì chỉ danh mục cấp 1 mới làm cha, tùy vào logic của bạn
        // $query->whereNull('parent_id');

        return $query->orderBy('name', 'asc')->get();
    }
    public function getActiveCategories_2()
    {
        return $this->model
            ->where('is_active', true)
            ->orderBy('name', 'ASC')
            ->get();
    }
    // public function getParentCategories()
    // {
    //     return $this->model->whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get();
    // }
    public function getParentCategoriesById($excludeId = null)
    {
        $query = $this->model
            ->whereNull('parent_id')
            ->where('is_active', true);

        // Nếu có ID cần loại trừ, thêm điều kiện vào query
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->orderBy('name', 'ASC')->get();
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
