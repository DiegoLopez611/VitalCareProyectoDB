<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\GrupoSanguineoRepositoryInterface;

class GrupoSanguineoRepository implements GrupoSanguineoRepositoryInterface
{
    public function obtenerTodos()
    {
        return DB::table('grupos_sanguineos')->get();
    }
}