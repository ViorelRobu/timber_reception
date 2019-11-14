<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('company_was_selected', function() {
            if (request()->session()->get('company_was_selected')) {
                return true;
            }
                return false;
        });

        Gate::define('view_and_edit', function($user, $company) {
            $session_company = intval(request()->session()->get('company_was_selected'), 10);
            return $session_company === $company;
        });

        Gate::define('superadmin', function($user) {
            $role = $user->role->class_id;
            return $role == 1 ? true : false;
        });

        Gate::define('admin', function($user) {
            $role = $user->role->class_id;
            return ($role == 2 || $role == 1) ? true : false;
        });

        Gate::define('user', function($user) {
            $role = $user->role->class_id;
            return ($role == 3 || $role == 1 || $role == 2) ? true : false;
        });

        Gate::define('viewer', function($user) {
            $role = $user->role->class_id;
            return ($role == 4 || $role == 1 || $role == 2 || $role == 3) ? true : false;
        });
    }
}
