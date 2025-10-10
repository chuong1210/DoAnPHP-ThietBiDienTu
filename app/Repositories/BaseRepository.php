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

    public function findByCondition($condition = [], $flag = false, $relation = [], $orderBy = ['id', 'DESC'])
    {
        $query = $this->model->newQuery();

        foreach ($condition as $key => $val) {
            $query->where($val[0], $val[1], $val[2]);
        }

        $query->with($relation);

        if (isset($orderBy)) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }

        return $flag == false ? $query->first() : $query->get();
    }
    public function pagination($column = ['*'], $condition = [], $perpage = 20, $extend = [], $relations = [], $orderBy = ['id', 'DESC'])
    {
        $query = $this->model->select($column);

        // Apply conditions
        if (isset($condition['keyword']) && !empty($condition['keyword'])) {
            $keyword = $condition['keyword'];
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        if (isset($condition['where'])) {
            foreach ($condition['where'] as $where) {
                $query->where($where[0], $where[1], $where[2]);
            }
        }

        // Apply relations
        if (!empty($relations)) {
            $query->with($relations);
        }

        // Apply order
        if (isset($orderBy)) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }

        return $query->paginate($perpage)->withQueryString();
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
