<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\IUserRepository;
use App\Http\Controllers\Traits\Crudable;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Crudable;

    private $userRepository;
    
    public function __construct(IUserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getAuthenticatedUser(Request $request)
    {
        try {

            $user = $request->user();
            return response()->success("User reterieved successfully", compact('user'));
        } catch(\Exception $e) {
            return $this->handleException($e);
        }
    }
}
