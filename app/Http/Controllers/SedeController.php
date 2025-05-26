<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\SedeRepositoryInterface;
use App\Repositories\Interfaces\CiudadRepositoryInterface;

class SedeController extends Controller
{
    protected $sedeRepository;
    protected $ciudadRepository;

    public function __construct(SedeRepositoryInterface $sedeRepository, CiudadRepositoryInterface $ciudadRepository)
    {
        $this->sedeRepository = $sedeRepository;
        $this->ciudadRepository = $ciudadRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sedes = $this->sedeRepository->obtenerTodos();
        return view('sede.index', compact('sedes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ciudades = $this->ciudadRepository->obtenerTodos();
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

        $this->sedeRepository->guardarSede([
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
        $sede = $this->sedeRepository->buscarSede($id);
        $ciudades = $this->ciudadRepository->obtenerTodos();
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

        $this->sedeRepository->actualizarSede($datosActualizados, $id);

        // Redirigir con mensaje de éxito
        return redirect()->route('sedes.index')->with('success', 'Sede actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->sedeRepository->eliminarSede($id);
        return redirect()->route('sedes.index')->with('success', 'Sede eliminada correctamente.');
    }

    public function buscar(Request $request)
    {
        $buscar = $request->get('buscar', '');
        
        $sedes = $this->sedeRepository->buscarPacienteArgumento($buscar);

        return view('sede.index', compact('sedes'));
    }
}
