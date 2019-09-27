<?php

namespace Raffles\Modules\Poga\Providers;

use Raffles\Modules\Poga\Models\{ DistribucionExpensa,Espacio,Pagare };
use Raffles\Modules\Poga\Policies\{ PagarePolicy };
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
        DistribucionExpensa::class => DistribucionExpensa::class,
        Espacio::class => Espacio::class,
        Inmueble::class => InmueblePolicy::class,
        Mantenimiento::class => MantenimientoPolicy::class,
        Solicitud::class => SolicitudPolicy::class,
        Unidad::class => UnidadPolicy::class,
        Evento::class => EventoPolicy::class,
        User::class => UserPolicy::class,
        Pagare::class => PagarePolicy::class
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
