<?php

namespace Raffles\Modules\Poga\Providers;

use Raffles\Modules\Poga\Models\{ 
    
    Renta
};
use Raffles\Modules\Poga\Policies\{ 
    
    RentaPolicy

 };
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Renta::class => RentaPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
