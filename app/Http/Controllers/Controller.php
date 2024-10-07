<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, DispatchesJobs;

    public function handleException($e)
    {
        $class_name = get_class($e);

        if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            //above we can also check $e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface
            return response()->error($e->getMessage(), $e->getStatusCode());
        }
        else if($class_name == "Illuminate\Validation\ValidationException") {
            return response()->error($e->getMessage(), 422, ["errors"=> $e->errors()]);
        } 
        // else if($class_name == "Illuminate\Database\QueryException") {
        //     Log::info("Exception thrown"."--".$e->getMessage());
        //     return response()->error("Internal Server Error", Response::HTTP_INTERNAL_SERVER_ERROR);
            
        // } 
        else if($class_name == "Illuminate\Database\Eloquent\ModelNotFoundException") {
            
            return response()->error("Record Not Found", Response::HTTP_NOT_FOUND);
        } else {
            return response()->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
