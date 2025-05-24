<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\CiudadRepositoryInterface;

class CiudadRepository implements CiudadRepositoryInterface
{
    public function obtenerTodos()
    {
        return DB::table('ciudades')->get();
    }
}