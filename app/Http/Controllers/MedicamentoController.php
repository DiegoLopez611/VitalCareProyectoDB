<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicamentos = DB::table('medicamentos')->paginate(10);
        return view('medicamento.index', compact('medicamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('medicamento.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'concentracion' => 'required|numeric',
            'nombre_laboratorio' => 'required|string',
        ]);

         DB::table('medicamentos')->insert([
            'nombre' => $request->input('nombre'),
            'concentracion' => $request->input('concentracion'),
            'nombre_laboratorio' => $request->input('nombre_laboratorio'),
            'estado' => 'ACTIVO',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('medicamentos.index')->with('success', 'Medicamentos registrado correctamente.');
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
        $medicamento = DB::table('medicamentos')->where('id', $id)->first();
        return view('medicamento.edit', compact('medicamento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'concentracion' => 'required|numeric',
            'nombre_laboratorio' => 'required|string',
        ]);

        $datosActualizados = [
            'nombre' => $request->input('nombre'),
            'concentracion' => $request->input('concentracion'),
            'nombre_laboratorio' => $request->input('nombre_laboratorio'),
            'updated_at' => now(),
        ];

        // Ejecutar la actualización
        DB::table('medicamentos')->where('id', $id)->update($datosActualizados);

        // Redirigir con mensaje de éxito
        return redirect()->route('medicamentos.index')->with('success', 'Medicamento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('medicamentos')->where('id', $id)->update(['estado' => 'INACTIVO']);
        return redirect()->route('medicamentos.index')->with('success', 'Medicamento eliminado correctamente.');
    }
}