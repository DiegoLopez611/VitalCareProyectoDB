<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\GeneroRepositoryInterface;

class GeneroRepository implements GeneroRepositoryInterface
{
    public function obtenerTodos()
    {
        return DB::table('generos')->get();
    }
}