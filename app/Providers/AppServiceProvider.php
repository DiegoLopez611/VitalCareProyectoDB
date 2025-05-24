<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; 
use App\Repositories\PacienteRepository;
use App\Repositories\CiudadRepository;
use App\Repositories\GeneroRepository;
use App\Repositories\GrupoSanguineoRepository;
use App\Repositories\Interfaces\PacienteRepositoryInterface;
use App\Repositories\Interfaces\CiudadRepositoryInterface;
use App\Repositories\Interfaces\GeneroRepositoryInterface;
use App\Repositories\Interfaces\GrupoSanguineoRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PacienteRepositoryInterface::class, PacienteRepository::class);
        $this->app->bind(CiudadRepositoryInterface::class, CiudadRepository::class);
        $this->app->bind(GeneroRepositoryInterface::class, GeneroRepository::class);
        $this->app->bind(GrupoSanguineoRepositoryInterface::class, GrupoSanguineoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
