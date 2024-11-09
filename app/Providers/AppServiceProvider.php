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

        // define gate for teacher with no role, allow the teacher view their specific function
        Gate::define('not-have-role', function($user) {
            return !$user->can('classteacher') && !$user->can('coordinator') && !$user->can('management');
        });

        Gate::define('classteachers-and-teachers', function($user) {
            return $user->can('classteacher') || $user->can('not-have-role');
        });
    }
}
