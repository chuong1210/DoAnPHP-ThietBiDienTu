<?php

namespace App\Services\Interfaces;

interface OrderServiceInterface
{
    public function createOrder($userId, $data);
    public function getOrdersByUser($userId);
    public function updateOrderStatus($orderId, $status);
    public function cancelOrder($orderId);
}
