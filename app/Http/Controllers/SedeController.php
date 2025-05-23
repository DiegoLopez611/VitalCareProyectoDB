<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sedes = DB::table('sedes')->paginate(10);
        return view('sede.index', compact('sedes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ciudades = DB::table('ciudades')->get();
        return view('sede.create', compact('ciudades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
            'ciudad_id' =>'required'
        ]);

         DB::table('sedes')->insert([
            'nombre' => $request->input('nombre'),
            'direccion' => $request->input('direccion'),
            'telefono' => $request->input('telefono'),
            'id_ciudad' => $request->input('ciudad_id'),
            'estado' => 'ACTIVO',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('sedes.index')->with('success', 'Sede registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sede = DB::table('sedes')->where('id', $id)->first();
        $ciudades = DB::table('ciudades')->get();
        return view('sede.edit', compact('sede','ciudades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
            'ciudad_id' => 'required',
        ]);

        $datosActualizados = [
            'nombre' => $request->input('nombre'),
            'direccion' => $request->input('direccion'),
            'telefono' => $request->input('telefono'),
            'id_ciudad' => $request->input('ciudad_id'),
            'updated_at' => now(),
        ];

        // Ejecutar la actualización
        DB::table('sedes')->where('id', $id)->update($datosActualizados);

        // Redirigir con mensaje de éxito
        return redirect()->route('sedes.index')->with('success', 'Sede actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('sedes')->where('id', $id)->update(['estado' => 'INACTIVO']);
        return redirect()->route('sedes.index')->with('success', 'Sede eliminada correctamente.');
    }
}
