<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::define('admin', function ($user) {
        //     return $user->groups == 1;
        // });

        // Gate::define('gestora', function ($user) {
        //     return $user->groups == 2;
        // });


        Gate::define('admin', function(User $user)
        {
            return $user->groups == 1;
        });

        Gate::define('gestao', function(User $user)
        {
            return $user->groups == 2;
        });

    }
}
