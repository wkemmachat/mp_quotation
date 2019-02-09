<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('update-post', function ($user, $post) {
        //     return $user->id == $post->user_id;
        // });

        Gate::define('isAdmin', function($user){
            return $user->user_type == 'admin';
        });

        Gate::define('isUser', function($user){
            return $user->user_type == 'user';
        });

        Gate::define('isRoot', function($user){
            return $user->user_type == 'root';
        });

        Gate::define('user-has-role', function ($user, Role $role) {
            return $user->roles->contains($role->id)?true:false;
        });
    }
}
