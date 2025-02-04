<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\IUserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    private $userRepository;
    
    public function __contruct( IUserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function signUp(Request $request) {
        $data = $request->input();

        try {
            $this->userRepository->storeValidation($data)->validate();
            $this->userRepository->store($data);

        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }
}
