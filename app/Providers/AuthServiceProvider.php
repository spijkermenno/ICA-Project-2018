<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use App\Repositories\DatabaseUserRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        Auth::provider('mssql', function ($app, array $config) {
            return app()->make(DatabaseUserRepository::class);
        });
    }
}
