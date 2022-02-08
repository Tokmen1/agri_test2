<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\FieldPolicy;
use App\Models\Fields;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Fields::class => FieldPolicy::class,
        'App\Models\FieldActions'=>'App\Policies\FieldActionsPolicy',
        'App\Models\Sowing'=>'App\Policies\SowingPolicy',
        'App\Models\Harvest'=>'App\Policies\HarvestPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // Gate::define("update", function ($user, $fields){
        //     return true;//$user->id === $field->user->id;
        // });
        //
    }
}
