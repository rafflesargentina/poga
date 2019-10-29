<?php

namespace Raffles\Modules\Poga\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('poga', 'Resources/Lang', 'app'), 'poga');
        $this->loadViewsFrom(module_path('poga', 'Resources/Views', 'app'), 'poga');
        $this->loadMigrationsFrom(module_path('poga', 'Database/Migrations', 'app'), 'poga');
        $this->loadConfigsFrom(module_path('poga', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('poga', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }
}
