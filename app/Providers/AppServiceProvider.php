<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; 
use App\Repositories\PacienteRepository;
use App\Repositories\CiudadRepository;
use App\Repositories\GeneroRepository;
use App\Repositories\GrupoSanguineoRepository;
use App\Repositories\MedicamentoRepository;
use App\Repositories\MedicoRepository;
use App\Repositories\UsuarioRepository;
use App\Repositories\SedeRepository;
use App\Repositories\ReporteRepository;
use App\Repositories\Interfaces\PacienteRepositoryInterface;
use App\Repositories\Interfaces\CiudadRepositoryInterface;
use App\Repositories\Interfaces\GeneroRepositoryInterface;
use App\Repositories\Interfaces\GrupoSanguineoRepositoryInterface;
use App\Repositories\Interfaces\MedicamentoRepositoryInterface;
use App\Repositories\Interfaces\UsuarioRepositoryInterface;
use App\Repositories\Interfaces\MedicoRepositoryInterface;
use App\Repositories\Interfaces\SedeRepositoryInterface;
use App\Repositories\Interfaces\ReporteRepositoryInterface;

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
        $this->app->bind(MedicamentoRepositoryInterface::class, MedicamentoRepository::class);
        $this->app->bind(UsuarioRepositoryInterface::class, UsuarioRepository::class);
        $this->app->bind(MedicoRepositoryInterface::class, MedicoRepository::class);
        $this->app->bind(SedeRepositoryInterface::class, SedeRepository::class);
        $this->app->bind(ReporteRepositoryInterface::class, ReporteRepository::class);
    
    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
