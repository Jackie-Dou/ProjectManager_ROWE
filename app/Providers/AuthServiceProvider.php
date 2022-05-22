<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Task' => 'App\Policies\TaskPolicy',
        'App\Models\TaskStatus' => 'App\Policies\TaskStatusPolicy',
        'App\Models\Label' => 'App\Policies\LabelPolicy',
        'App\Models\Project' => 'App\Policies\ProjectPolicy',
        'App\Models\Sample' => 'App\Policies\SamplePolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
