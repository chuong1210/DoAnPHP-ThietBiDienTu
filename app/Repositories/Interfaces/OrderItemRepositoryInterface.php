<?php

namespace App\Repositories\Interfaces;

/**
 * Interface AttributeCatalogueRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface OrderItemRepositoryInterface extends BaseRepositoryInterface
{
    public function createBatch($items);
}
