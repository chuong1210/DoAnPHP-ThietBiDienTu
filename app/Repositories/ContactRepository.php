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

    public function filterContacts(array $filters)
    {
        $query = $this->model->query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query->orderBy('created_at', 'DESC')->get();
    }

    public function countByStatus(string $status)
    {
        return $this->model->where('status', $status)->count();
    }

    public function find($id)
    {
        return $this->findById($id);
    }

    public function search(string $keyword)
    {
        return $this->model->where('name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%")
                        ->orWhere('subject', 'like', "%{$keyword}%")
                        ->orderBy('created_at', 'DESC')
                        ->get();
    }
}
