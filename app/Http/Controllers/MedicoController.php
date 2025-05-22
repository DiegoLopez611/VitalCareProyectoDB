<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicos = DB::table('medicos as m')
            ->join('usuarios as u','m.cedula','=','u.cedula')
            ->select([
                'm.id',
                'm.cedula',
                'u.nombre',
                'u.apellido',
                'u.fecha_nacimiento',
                'u.email',
                'm.numero_licencia_medica as licencia_medica',
                'm.estado'
            ])
            ->paginate(10);
        return view('medico.index', compact('medicos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medico.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'cedula'=>'required|string',
            'email'=>'required|email',
            'primer_nombre'=>'required|string',
            'segundo_nombre'=>'string',
            'primer_apellido'=>'required|string',
            'segundo_apellido'=>'string',
            'direccion'=>'required|string',
            'licencia_medica' => 'required|string',
            'fecha_nacimiento' => 'required',
            'fecha_inicio' =>'required'
        ]);

        DB::table('usuarios')->insert([
            'cedula' => $request->input('cedula'),
            'email' => $request->input('email'),
            'nombre' => $request->input('primer_nombre').' '.$request->input('segundo_nombre'),
            'apellido' => $request->input('primer_apellido').' '.$request->input('segundo_apellido'),
            'direccion' => $request->input('direccion'),
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
            'password' => $request->input('cedula'),
            'id_estado_usuario' => 1
        ]);

        DB::table('medicos')->insert([
            'cedula' => $request->input('cedula'),
            'fecha_inicio_laboral' => $request->input('fecha_inicio'),
            'numero_licencia_medica' => $request->input('licencia_medica'),
            'id_especialidad'=> 1,
            'estado' => 'ACTIVO',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('medicos.index')->with('success', 'Medico registrado correctamente.');
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
        $medico = DB::table('medicos')->where('id', $id)->first();
        $usuario = DB::table('usuarios')->where('id', $id)->first();
        return view('medico.edit', compact('medico','usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $request->validate([
            'cedula'=>'required|string',
            'email'=>'required|email',
            'primer_nombre'=>'required|string',
            'segundo_nombre'=>'string',
            'primer_apellido'=>'required|string',
            'segundo_apellido'=>'string',
            'direccion'=>'required|string',
            'licencia_medica' => 'required|string',
            'fecha_nacimiento' => 'required',
        ]);

        DB::table('usuarios')
            ->where('cedula', $request->input('cedula'))
            ->update([
                'email' => $request->input('email'),
                'nombre' => $request->input('primer_nombre'),
                'apellido' => $request->input('primer_apellido'),
                'direccion' => $request->input('direccion'),
                'fecha_nacimiento' => $request->input('fecha_nacimiento'),
                'updated_at' => now(),
            ]);

        DB::table('medicos')
            ->where('cedula', $request->input('cedula'))
            ->update([
                'cedula' => $request->input('cedula'),
                'numero_licencia_medica' => $request->input('licencia_medica'),
                'updated_at' => now(),
            ]);

        

        // Redirigir con mensaje de éxito
        return redirect()->route('medicos.index')->with('success', 'Medico actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('medicos')->where('id', $id)->update(['estado' => 'INACTIVO']);
        return redirect()->route('medicos.index')->with('success', 'Medico eliminado correctamente.');
    
    }
}