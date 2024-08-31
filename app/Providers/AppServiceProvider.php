<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        //define gate for class teacher, allow class teacher view their specific function
        Gate::define('classteacher', function($user) {
            return $user->hasRole('Class Teacher');
        });

        //define gate for management, allow management view their specific function
        Gate::define('management', function($user) {
            return $user->hasRole('Management');
        });
        
        //define gate for coordinator, allow coordinator view their specific function
        Gate::define('coordinator', function($user) {
            return $user->hasRole('Coordinator');
        });

        Gate::define('coordinator-or-management', function($user) {
            return !$user->can('coordinator') || !$user->can('management');
        });
    }
}
