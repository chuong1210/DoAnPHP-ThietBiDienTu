<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($relations = [])
    {
        return $this->model->with($relations)->get();
    }

    public function findById($id, $columns = ['*'], $relations = [])
    {
        return $this->model->select($columns)->with($relations)->findOrFail($id);
    }

    public function findByCondition($conditions = [], $relations = [], $orderBy = ['id', 'DESC'])
    {
        $query = $this->model->newQuery();

        foreach ($conditions as $condition) {
            $query->where($condition[0], $condition[1], $condition[2]);
        }

        if (!empty($relations)) {
            $query->with($relations);
        }

        if (!empty($orderBy)) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }

        return $query->first();
    }

    public function pagination($columns = ['*'], $conditions = [], $perPage = 20, $relations = [], $orderBy = ['id', 'DESC'])
    {
        $query = $this->model->select($columns);

        foreach ($conditions as $condition) {
            if (isset($condition[0], $condition[1], $condition[2])) {
                $query->where($condition[0], $condition[1], $condition[2]);
            }
        }

        if (!empty($relations)) {
            $query->with($relations);
        }

        if (!empty($orderBy)) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }

        return $query->paginate($perPage);
    }

    public function create($data = [])
    {
        return $this->model->create($data);
    }

    public function update($id, $data = [])
    {
        $model = $this->findById($id);
        $model->fill($data);
        $model->save();
        return $model;
    }

    public function delete($id)
    {
        return $this->findById($id)->delete();
    }

    public function updateByWhere($conditions = [], $data = [])
    {
        $query = $this->model->newQuery();

        foreach ($conditions as $condition) {
            $query->where($condition[0], $condition[1], $condition[2]);
        }

        return $query->update($data);
    }

    public function deleteByCondition($conditions = [])
    {
        $query = $this->model->newQuery();

        foreach ($conditions as $condition) {
            $query->where($condition[0], $condition[1], $condition[2]);
        }

        return $query->delete();
    }
}
