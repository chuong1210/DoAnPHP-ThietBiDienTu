<?php


namespace App\Repositories\Interfaces;

/**
 * Interface AttributeCatalogueRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface CartRepositoryInterface extends BaseRepositoryInterface
{
    public function getCartByUser($userId);
    public function clearCart($userId);
}
