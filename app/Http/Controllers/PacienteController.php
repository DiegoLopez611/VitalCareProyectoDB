<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\PacienteRepositoryInterface;
use App\Repositories\Interfaces\CiudadRepositoryInterface;
use App\Repositories\Interfaces\GeneroRepositoryInterface;
use App\Repositories\Interfaces\GrupoSanguineoRepositoryInterface;

class PacienteController extends Controller
{

    protected $pacienteRepository;
    protected $ciudadRepository;
    protected $generoRepository;
    protected $grupoSanguineoRepository;

    public function __construct(PacienteRepositoryInterface $pacienteRepository, 
                            CiudadRepositoryInterface $ciudadRepository,
                            GeneroRepositoryInterface $generoRepository,
                            GrupoSanguineoRepositoryInterface $grupoSanguineoRepository,
                            )
    {
        $this->pacienteRepository = $pacienteRepository;
        $this->ciudadRepository = $ciudadRepository;
        $this->generoRepository = $generoRepository;
        $this->grupoSanguineoRepository = $grupoSanguineoRepository;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = $this->pacienteRepository->obtenerTodos();
        return view('paciente.index', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ciudades = $this->ciudadRepository->obtenerTodos();
        $generos = $this->generoRepository->obtenerTodos();
        $grupos_sanguineos = $this->grupoSanguineoRepository->obtenerTodos();
        return view('paciente.create', compact('ciudades', 'generos', 'grupos_sanguineos'));
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
            'fecha_nacimiento' => 'required',
            'ciudad_id' => 'required',
            'genero_id' => 'required',
            'grupo_sanguineo_id' => 'required'
        ]);

        $this->pacienteRepository->guardarPaciente([
            'cedula' => $request->input('cedula'),
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
            'email' => $request->input('email'),
            'primer_nombre' => $request->input('primer_nombre'),
            'segundo_nombre' => $request->input('segundo_nombre'),
            'primer_apellido' => $request->input('primer_apellido'),
            'segundo_apellido' => $request->input('segundo_apellido'),
            'direccion' => $request->input('direccion'),
            'id_ciudad' => $request->input('ciudad_id'),
            'id_genero' => $request->input('genero_id'),
            'id_grupo_sanguineo' => $request->input('grupo_sanguineo_id'),
            'estado' => 'ACTIVO',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('pacientes.index')->with('success', 'Paciente registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Paciente $paciente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $paciente = $this->pacienteRepository->buscarPaciente($id);
        $ciudades = $this->ciudadRepository->obtenerTodos();
        $generos = $this->generoRepository->obtenerTodos();
        $grupos_sanguineos = $this->grupoSanguineoRepository->obtenerTodos();
        return view('paciente.edit', compact('paciente','ciudades','generos','grupos_sanguineos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cedula'=>'required|string',
            'email'=>'required|email',
            'primer_nombre'=>'required|string',
            'segundo_nombre'=>'string',
            'primer_apellido'=>'required|string',
            'segundo_apellido'=>'string',
            'direccion'=>'required|string',
            'ciudad_id' => 'required',
            'genero_id' => 'required',
            'grupo_sanguineo_id' => 'required'
        ]);

        $this->pacienteRepository->actualizarPaciente([
            'email' => $request->input('email'),
            'primer_nombre' => $request->input('primer_nombre'),
            'segundo_nombre' => $request->input('segundo_nombre'),
            'primer_apellido' => $request->input('primer_apellido'),
            'segundo_apellido' => $request->input('segundo_apellido'),
            'direccion' => $request->input('direccion'),
            'id_ciudad' => $request->input('ciudad_id'),
            'id_genero' => $request->input('genero_id'),
            'id_grupo_sanguineo' => $request->input('grupo_sanguineo_id'),
            'created_at' => now(),
        ], $id);

        // Redirigir con mensaje de éxito
        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $this->pacienteRepository->eliminarPaciente($id);
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado correctamente.');
    }
}