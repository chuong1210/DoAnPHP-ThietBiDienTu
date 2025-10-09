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
    public function findByCondition($conditions = [], $relations = [], $orderBy = ['id', 'DESC']);
    public function pagination($columns = ['*'], $conditions = [], $perPage = 20, $relations = [], $orderBy = ['id', 'DESC']);
    public function create($data = []);
    public function update($id, $data = []);
    public function delete($id);
    public function updateByWhere($conditions = [], $data = []);
}
