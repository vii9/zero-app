<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\ProductApiRepository;
use App\Repositories\ProductApiRepositoryInterface;
use App\Repositories\UserApiRepository;
use App\Repositories\UserApiRepositoryInterface;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(ProductApiRepositoryInterface::class, ProductApiRepository::class);
        $this->app->bind(UserApiRepositoryInterface::class, UserApiRepository::class);
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
