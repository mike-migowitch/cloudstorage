<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Directory;
use App\Models\File;
use App\Policies\OwnerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Directory::class => OwnerPolicy::class,
        File::class => OwnerPolicy::class
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
