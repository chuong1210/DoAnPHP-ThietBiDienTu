<?php

namespace App\Services\Interfaces;

/**
 * Interface AttributeCatalogueServiceInterface
 * @package App\Services\Interfaces
 */
interface CartServiceInterface
{
    public function addToCart($userId, $productId, $quantity);
    public function getTotalQuantity($carts);

    public function updateCart($userId, $productId, $quantity);
    public function removeFromCart($userId, $productId);
    public function getCart($userId);
    public function clearCart($userId);
}
