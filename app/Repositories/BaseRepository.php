<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepositiry
{
    public $model;
    
    public function __construct(Model $mode)
    {
        $this->model = $mode;
    }


}