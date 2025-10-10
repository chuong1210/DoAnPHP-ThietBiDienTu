<?php


namespace App\Repositories\Interfaces;

/**
 * Interface AttributeCatalogueRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface CartItemRepositoryInterface extends BaseRepositoryInterface
{
    public function addOrUpdateItem($cartId, $productId, $quantity, $price);
    public function removeItem($cartId, $productId);
}
