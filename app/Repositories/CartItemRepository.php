<?php

namespace App\Repositories;

use App\Models\CartItem;

class CartItemRepository extends BaseRepository
{
    public function __construct(CartItem $model)
    {
        parent::__construct($model);
    }

    public function addOrUpdateItem($cartId, $productId, $quantity, $price)
    {
        $cartItem = $this->model->where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
            return $cartItem;
        } else {
            return $this->model->create([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }
    }

    public function removeItem($cartId, $productId)
    {
        return $this->model->where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->delete();
    }
}
