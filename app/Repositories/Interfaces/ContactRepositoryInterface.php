<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface ContactRepositoryInterface extends BaseRepositoryInterface
{
    public function getNewContacts();
    public function markAsReplied($id);
    public function markAsClosed($id);
    public function filterContacts(array $filters);
    public function countByStatus(string $status);
    public function search(string $keyword);
    public function find($id); // để controller gọi trực tiếp
}
