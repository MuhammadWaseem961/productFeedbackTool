<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\{UserRepository};
use App\Interfaces\{EloquentRepositoryInterface};

class RepositoryServerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
