<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface ContactRepositoryInterface extends BaseRepositoryInterface
{


    public function getNewContacts();
    public function markAsReplied($id);

    public function markAsClosed($id);
}
