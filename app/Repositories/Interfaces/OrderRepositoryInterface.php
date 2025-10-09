<?php

namespace App\Repositories\Interfaces;

/**
 * Interface AttributeCatalogueRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function getOrdersByUser($userId, $perPage = 20);
}
