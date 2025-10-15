<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\Survey;
use App\Policies\SurveyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Survey::class => SurveyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('admin', fn($user) => $user->role === 'ADMIN');
    }
}
