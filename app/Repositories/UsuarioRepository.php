<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\UsuarioRepositoryInterface;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    public function obtenerTodos()
    {
    }

    public function guardarUsuario(array $data)
    {
        DB::table('usuarios')->insert($data);
    }

    public function buscarUsuario($id)
    {
        return DB::table('usuarios')->where('id', $id)->first();
    }

    public function actualizarUsuario(array $data, $cedula)
    {
        DB::table('usuarios')
            ->where('cedula', $cedula)
            ->update($data);
    }

    public function eliminarUsuario($id)
    {
        
    }

}