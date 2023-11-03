<?php

namespace App\Facades\Project;

use App\Models\User;

class UserService
{
    protected $users;

    public function __construct()
    {
        $this->users = User::query();
    }
    public function getAll(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->users->paginate(5);
    }
    public function getById($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return $this->users->find($id);
    }
}
