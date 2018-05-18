<?php

namespace WT2projekt\Providers;

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
        'WT2projekt\Model' => 'WT2projekt\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        Gate::define('check-admin', function ($user) {
            if ($user->isAdmin == 1) {
                return true;
            } else {
                return false;
            }
        });
    }
}
