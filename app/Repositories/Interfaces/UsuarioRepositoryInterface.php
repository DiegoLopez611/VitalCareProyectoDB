<?php

namespace App\Repositories\Interfaces;

interface UsuarioRepositoryInterface
{
    public function obtenerTodos();
    public function guardarUsuario(array $data);
    public function buscarUsuario($id);
    public function actualizarUsuario(array $data, $cedula);
    public function eliminarUsuario($id);
}