<?php

namespace App\Providers;

use App\Contracts\Repositories\IUserRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class InterfaceBindingServiceProvider extends ServiceProvider
{


    const BINDINGS = [
        IUserRepository::class => UserRepository::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach(self::BINDINGS as $key => $value) {
            $this->app->bind($key,$value);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
