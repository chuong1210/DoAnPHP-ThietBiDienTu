<?php

// ==========================================
// BRAND REPOSITORY
// ==========================================
namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Interfaces\BrandRepositoryInterface;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function __construct(Brand $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
    public function getActiveBrands()
    {
        $condition = [
            ['is_active', '=', true]
        ];

        $brands = $this->findByCondition($condition, true, [], ['name', 'ASC']);

        // Nếu $brands là false hoặc null → trả về collection rỗng
        if (!$brands || is_bool($brands)) {
            return collect();
        }
        return $brands;
    }

    // app/Repositories/BrandRepository.php

    public function getActiveBrands_2()
    {
        // Viết truy vấn trực tiếp, rõ ràng và không phụ thuộc vào hàm chung chung
        return $this->model
            ->where('is_active', true)
            ->orderBy('name', 'ASC')
            ->get();
    }
    public function searchAndPaginate(string $searchByColumn, ?string $keyword, int $perPage = 10, array $relations = [])
    {
        $query = $this->model->with($relations);

        if (!empty($keyword)) {
            $query->where($searchByColumn, 'LIKE', "%{$keyword}%");
        }

        return $query->orderBy('id', 'desc')->paginate($perPage)->withQueryString();
    }
    // Hoặc dùng pagination nếu cần phân trang
    public function getActiveBrandsPaginated($perPage = 20)
    {
        $condition = [
            'where' => [
                ['is_active', '=', true]
            ]
        ];
        return $this->pagination(['*'], $condition, $perPage);
    }
}
