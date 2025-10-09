<?php

namespace App\Services\Interfaces;

interface ProductServiceInterface
{
    public function getAll($perPage);
    public function search($keyword, $filters);
    public function getById($id);
}
