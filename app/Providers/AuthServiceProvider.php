<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        Gate::define('is-patient', function ($user) {
            return $user->hasAnyRole('patient');
        });

        Gate::define('is-doctor', function ($user) {
            return $user->hasAnyRole('doctor');
        });

        Gate::define('is-admin', function ($user) {
            return $user->hasAnyRole('admin');
        });
    }
}
