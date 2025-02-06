<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\IUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    private $userRepository;
    
    public function __construct( IUserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function signUp(Request $request) {
        $data = $request->input();

        try {
            $this->userRepository->storeValidation($data)->validate();
            $user = $this->userRepository->store($data);
            return $this->authenticate($user);

        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function signIn (Request $request)
    {
        $data = $request->input();

        try {
            $this->userRepository->loginValidation($data)->validate();
            $user = $this->userRepository->findByQuery(['email' => $data['email']]);
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return response()->error('The user credentials were incorrect.', 422);
            } 
            
            return $this->authenticate($user);

        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function authenticate($user)
    {
        $token = $this->userRepository->generateAuthenticationToken($user);
        return response()->success("User authenticated successfully", compact('user','token'));
    }


}
