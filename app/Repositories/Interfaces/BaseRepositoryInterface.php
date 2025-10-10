<?php

namespace App\Repositories\Interfaces;

/**
 * Interface BaseRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface BaseRepositoryInterface
{
    public function all($relations = []);
    public function findById($id, $columns = ['*'], $relations = []);
    public function create($data = []);
    public function update($id, $data = []);
    public function delete($id);
    public function updateByWhere($conditions = [], $data = []);

    public function findByCondition($condition = [], $flag = false, $relation = [], $orderBy = ['id', 'DESC']);
    public function pagination($column = ['*'], $condition = [], $perpage = 20, $extend = [], $relations = [], $orderBy = ['id', 'DESC']);
}
