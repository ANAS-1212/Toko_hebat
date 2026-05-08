<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserInterface;
use App\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Binding Interface ke Repository
        $this->app->bind(UserInterface::class, UserRepository::class);
    }

    public function boot(): void
    {
        //
    }
}