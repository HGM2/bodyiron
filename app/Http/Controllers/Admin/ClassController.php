<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\Clase;
use App\Models\Cliente;
use App\Models\AsistenciaClase;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    // Cargar la relación 'empleado' para evitar errores en la vista
    $clases = Clase::with('empleado')->get()->map(function ($clase) {
        $clase->fecha_hora = Carbon::parse($clase->fecha_hora);
        return $clase;
    });

    return view('admin.classes.index', compact('clases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    // Obtiene los empleados que tienen el rol de "entrenador"
        $entrenadores = Empleado::where('puesto', 'entrenador')->get();
        
        return view('admin.classes.create', compact('entrenadores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_hora' => 'required|date',
            'empleado_id' => 'required|exists:empleados,id',
            'num_max_participantes' => 'required|integer|min:1',
            'lugar' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Clase::create($request->all());

        return redirect()->route('admin.classes.index')->with('success', 'Clase creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $clase = Clase::findOrFail($id);
        return view('admin.classes.show', compact('clase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $clase = Clase::findOrFail($id);
    
        // Obtener todos los empleados con el rol de "entrenador"
        $entrenadores = Empleado::where('puesto', 'entrenador')->get();
        
        return view('admin.classes.edit', compact('clase', 'entrenadores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_hora' => 'required|date',
            'empleado_id' => 'required|exists:empleados,id',
            'num_max_participantes' => 'required|integer|min:1',
            'lugar' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $clase = Clase::findOrFail($id);
        $clase->update($request->all());

        return redirect()->route('admin.classes.index')->with('success', 'Clase actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $clase = Clase::findOrFail($id);
        $clase->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Clase eliminada exitosamente.');
    }

    /**
     * Mostrar el checklist de asistencia.
     */
    public function attendanceChecklist($id)
    {
        $clase = Clase::findOrFail($id);

        // Verificar que el usuario tenga el rol de "entrenador"
        if (auth()->user()->tipo !== 'entrenador') {
            abort(403, 'Acceso denegado');
        }

        // Obtener clientes inscritos en la clase y la asistencia registrada
        $clientes = Cliente::whereHas('clases', function($query) use ($id) {
            $query->where('clase_id', $id);
        })->get();

        $asistencias = AsistenciaClase::where('clase_id', $id)->pluck('cliente_id')->toArray();

        return view('admin.classes.checklist', compact('clase', 'clientes', 'asistencias'));
    }

    /**
     * Actualizar la asistencia de la clase.
     */
    public function updateAttendance(Request $request, $id)
    {
        $clase = Clase::findOrFail($id);

        // Asegurarse de que solo los entrenadores puedan actualizar la asistencia
        if (auth()->user()->tipo !== 'entrenador') {
            abort(403, 'Acceso denegado');
        }

        // Procesar asistencia
        $asistencia = $request->input('asistencia', []);

        // Eliminar asistencias anteriores
        AsistenciaClase::where('clase_id', $id)->delete();

        // Registrar las nuevas asistencias
        foreach ($asistencia as $clienteId => $asistio) {
            AsistenciaClase::create([
                'cliente_id' => $clienteId,
                'clase_id' => $id,
                'asistio' => true,
                'fecha_asistencia' => now(),
            ]);
        }

        return redirect()->route('admin.classes.attendance', $id)->with('success', 'Asistencia actualizada correctamente.');
    }



    
    // Parte de la Api
    public function fetchClases()
    {
        try {
            // Obtener las clases junto con el nombre del empleado
            $clases = Clase::with('empleado')->get(); // Cargar la relación 'empleado'
            
            // Crear un array con los datos de las clases y el nombre del empleado
            $clasesArray = $clases->map(function ($clase) {
                return [
                    'id' => $clase->id,
                    'nombre' => $clase->nombre,
                    'fecha_hora' => $clase->fecha_hora,
                    'empleado_nombre' => $clase->empleado ? $clase->empleado->nombre : 'No asignado', // Aquí obtenemos el nombre del empleado, verificando que exista
                    'num_max_participantes' => $clase->num_max_participantes,
                    'lugar' => $clase->lugar,
                    'descripcion' => $clase->descripcion,
                ];
            });
    
            return response()->json($clasesArray);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
