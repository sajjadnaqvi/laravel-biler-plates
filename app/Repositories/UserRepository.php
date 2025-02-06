<?php

namespace App\Repositories;

use App\Contracts\Repositories\IUserRepository;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $user) {
        parent::__construct($user);
    }

    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->model->create($data);
    }

    public function storeValidation(array $data) {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
    }

    public function loginValidation(array $data) {
        return Validator::make($data, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);
    }


    public function generateAuthenticationToken($user)
    {
        return $user->createToken('authToken')->plainTextToken;
    }

}