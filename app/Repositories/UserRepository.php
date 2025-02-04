<?php

namespace App\Repositories;

use App\Contracts\Repositories\IUserRepository;
use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $user) {
        parent::__construct($user);
    }
}