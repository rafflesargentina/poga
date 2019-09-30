<?php

namespace Raffles\Modules\Poga\Providers;

use Raffles\Modules\Poga\Models\{ 
    
    DistribucionExpensa,
    Espacio,
    Inmueble,
    Mantenimiento,
    Solicitud,
    Unidad,
    Evento,
    User,
    Pagare,
    Renta
};
use Raffles\Modules\Poga\Policies\{ 
    
    DistribucionExpensaPolicy,
    EspacioPolicy,
    InmueblePolicy,
    MantenimientoPolicy,
    SolicitudPolicy,
    UnidadPolicy,
    EventoPolicy,
    UserPolicy,
    PagarePolicy,
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
        DistribucionExpensa::class => DistribucionExpensaPolicy::class,
        Espacio::class => EspacioPolicy::class,
        Inmueble::class => InmueblePolicy::class,
        Mantenimiento::class => MantenimientoPolicy::class,
        Solicitud::class => SolicitudPolicy::class,
        Unidad::class => UnidadPolicy::class,
        Evento::class => EventoPolicy::class,
        User::class => UserPolicy::class,
        Pagare::class => PagarePolicy::class,
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
