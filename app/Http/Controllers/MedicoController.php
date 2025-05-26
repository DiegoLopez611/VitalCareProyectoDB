<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\MedicoRepositoryInterface;
use App\Repositories\Interfaces\UsuarioRepositoryInterface;

class MedicoController extends Controller
{

    protected $medicoRepository;
    protected $usuarioRepository;

    public function __construct(MedicoRepositoryInterface $medicoRepository, UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->medicoRepository = $medicoRepository;
        $this->usuarioRepository = $usuarioRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicos = $this->medicoRepository->obtenerInformacionCompletaTodos();
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
            'primer_apellido'=>'required|string',
            'segundo_apellido'=>'string',
            'direccion'=>'required|string',
            'licencia_medica' => 'required|string',
            'fecha_nacimiento' => 'required',
            'fecha_inicio' =>'required'
        ]);

        $this->usuarioRepository->guardarUsuario([
            'cedula' => $request->input('cedula'),
            'email' => $request->input('email'),
            'nombre' => $request->input('primer_nombre').' '.$request->input('segundo_nombre'),
            'apellido' => $request->input('primer_apellido').' '.$request->input('segundo_apellido'),
            'direccion' => $request->input('direccion'),
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
            'password' => $request->input('cedula'),
            'id_estado_usuario' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->medicoRepository->guardarMedico([
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
        $medico = $this->medicoRepository->buscarMedico($id);
        $usuario = $this->usuarioRepository->buscarUsuario($id);
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

        $this->usuarioRepository->actualizarUsuario(
            [
                'email' => $request->input('email'),
                'nombre' => $request->input('primer_nombre'),
                'apellido' => $request->input('primer_apellido'),
                'direccion' => $request->input('direccion'),
                'fecha_nacimiento' => $request->input('fecha_nacimiento'),
                'updated_at' => now(),
            ], $request->input('cedula')
        );

        $this->medicoRepository->actualizarMedico(
            [
                'numero_licencia_medica' => $request->input('licencia_medica'),
                'updated_at' => now(),
            ], $request->input('cedula')
        );

        // Redirigir con mensaje de éxito
        return redirect()->route('medicos.index')->with('success', 'Medico actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->medicoRepository->eliminarMedico($id);
        return redirect()->route('medicos.index')->with('success', 'Medico eliminado correctamente.');
    
    }

    public function buscar(Request $request)
    {
        $buscar = $request->get('buscar', '');
        
        $medicos = $this->medicoRepository->buscarPacienteArgumento($buscar);

        return view('medico.index', compact('medicos'));
    }
}