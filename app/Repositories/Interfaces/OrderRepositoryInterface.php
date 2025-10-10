<?php

namespace App\Repositories\Interfaces;

/**
 * Interface AttributeCatalogueRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function getOrdersByUser($userId, $perPage = 20);
    public function getOrderByNumber($orderNumber);
    public function updateStatus($id, $status);
    public function updatePaymentStatus($id, $status);
    public function getRevenueByDateRange($startDate, $endDate);
    public function getOrderCountByStatus($status);
}
