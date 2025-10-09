<?php
// ==========================================
// USER REPOSITORY
// ==========================================
namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
