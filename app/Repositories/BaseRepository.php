<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
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
        return $this->model->with($relations)->find($id, $columns);
    }

    public function create($data = [])
    {
        return $this->model->create($data);
    }

    public function update($id, $data = [])
    {
        $item = $this->findById($id);
        if ($item) {
            $item->update($data);
        }
        return $item;
    }

    public function delete($id)
    {
        $item = $this->findById($id);
        if ($item) {
            return $item->delete();
        }
        return false;
    }

    public function updateByWhere($conditions = [], $data = [])
    {
        return $this->model->where($conditions)->update($data);
    }

    public function findByCondition($condition = [], $flag = false, $relation = [], $orderBy = ['id', 'DESC'])
    {
        $query = $this->model->with($relation)->where($condition)->orderBy($orderBy[0], $orderBy[1]);
        return $flag ? $query->first() : $query->get();
    }

    public function pagination($column = ['*'], $condition = [], $perpage = 20, $extend = [], $relations = [], $orderBy = ['id', 'DESC'])
    {
        return $this->model->with($relations)
                    ->where($condition)
                    ->orderBy($orderBy[0], $orderBy[1])
                    ->paginate($perpage, $column)
                    ->appends($extend);
    }
}
