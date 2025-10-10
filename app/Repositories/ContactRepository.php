<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Interfaces\ContactRepositoryInterface;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function __construct(Contact $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }


    public function getNewContacts()
    {
        return $this->model->where('status', 'new')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function markAsReplied($id)
    {
        return $this->update($id, ['status' => 'replied']);
    }

    public function markAsClosed($id)
    {
        return $this->update($id, ['status' => 'closed']);
    }
}
