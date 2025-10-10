<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class AttributeCatalogueRepository
 * @package App\Repositories
 */
class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    protected $model;

    public function __construct(Cart $cart)
    {
        $this->model = $cart;
        parent::__construct($this->model);
    }

    public function getCartByUser($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function createOrGetCart($userId)
    {
        $cart = $this->model->where('user_id', $userId)->first();

        if (!$cart) {
            $cart = $this->model->create(['user_id' => $userId]);
        }

        return $cart;
    }
    public function clearCart($userId)
    {
        $cart = $this->model->where('user_id', $userId)->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return true;
    }
}
