<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        
        Gate::define('isSuperadmin', function(User $user){

            return $user->rol=="superadmin";
        });


        Gate::define('isAdmin', function(User $user){

            return $user->rol=="admin";
        });

        Gate::define('isUser', function(User $user){

            return $user->rol=="user";
        });

        Gate::define('isSaller', function(User $user){

            return $user->rol=="saller";
        });

    }
}
