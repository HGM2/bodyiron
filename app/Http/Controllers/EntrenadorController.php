<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;
use App\Models\Cliente;
use App\Models\AsistenciaClase;
use Barryvdh\DomPDF\Facade\Pdf;

class EntrenadorController extends Controller
{
    public function index()
    {
        // Obtiene todas las clases para mostrarlas en el dashboard del entrenador
        $clases = Clase::with('instructor')->get();

        return view('entrenador.dashboard', compact('clases'));
    }

    public function listClasses()
    {
        // Obtiene todas las clases y carga la relación con el instructor
        $clases = Clase::with('instructor')->get();

        return view('entrenador.clases.index', compact('clases'));
    }

    public function attendanceChecklist($classId)
    {
        // Obtiene la clase específica con los clientes asociados
        $clase = Clase::with(['clientes'])->findOrFail($classId);
    
        // Obtiene la lista de clientes relacionados con la clase
        $clientes = $clase->clientes; // Relación en el modelo Clase
    
        // Carga las asistencias existentes para la clase y fecha actual
        $asistencias = AsistenciaClase::where('clase_id', $classId)
            ->where('fecha_asistencia', now()->toDateString())
            ->pluck('asistio', 'cliente_id')
            ->toArray();
    
        return view('entrenador.clases.asistencias', compact('clase', 'clientes', 'asistencias'));
    }
    

    public function updateAttendance(Request $request, $classId)
    {
        // Valida que la clase existe
        $clase = Clase::findOrFail($classId);

        // Recibe los datos de asistencia
        $attendanceData = $request->input('attendance', []);

        foreach ($attendanceData as $clienteId => $asistio) {
            // Marca la asistencia en la tabla `asistencias_clases`
            AsistenciaClase::updateOrCreate(
                [
                    'clase_id' => $classId,
                    'cliente_id' => $clienteId,
                    'fecha_asistencia' => now()->toDateString(),
                ],
                [
                    'asistio' => $asistio,
                ]
            );
        }

        return redirect()->route('entrenador.clases.index')->with('success', 'Asistencia actualizada correctamente.');
    }

    public function viewClassSchedule()
    {
        // Obtiene todas las clases con la información del instructor
        $clases = Clase::with('instructor')->get();

        return view('entrenador.horario', compact('clases'));
    }

    public function addClassNotes(Request $request, $classId)
    {
        $request->validate([
            'notas' => 'required|string|max:1000',
        ]);

        // Encuentra la clase para agregar notas
        $clase = Clase::findOrFail($classId);
        $clase->notas = $request->input('notas');
        $clase->save();

        return redirect()->route('entrenador.clases.index')->with('success', 'Notas de clase actualizadas.');
    }

    public function generarReporte($classId)
    {
        // Obtén la clase con los clientes y asistencias
        $clase = Clase::with(['clientes' => function ($query) {
            $query->select('clientes.id', 'clientes.nombre', 'clientes.apellido_paterno');
        }])->findOrFail($classId);

        // Obtén todas las asistencias para esta clase
        $asistencias = AsistenciaClase::where('clase_id', $classId)
            ->where('fecha_asistencia', now()->toDateString())
            ->get();

        // Filtra asistentes y no asistentes
        $asistieron = $clase->clientes->filter(function ($cliente) use ($asistencias) {
            return $asistencias->where('cliente_id', $cliente->id)->where('asistio', true)->isNotEmpty();
        });

        $noAsistieron = $clase->clientes->filter(function ($cliente) use ($asistencias) {
            return $asistencias->where('cliente_id', $cliente->id)->where('asistio', false)->isNotEmpty();
        });

        // Generar el PDF
        $pdf = Pdf::loadView('entrenador.clases.reporte', compact('clase', 'asistieron', 'noAsistieron'));

        return $pdf->download('reporte_asistencia_clase_' . $clase->nombre . '.pdf');
    }


    
    // parte de la api
    public function inscribir(Request $request){
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'clase_id' => 'required|exists:clases,id',
        ]);
    
        // Verificar si el cliente ya está inscrito en la clase
        $inscripcionExistente = AsistenciaClase::where('cliente_id', $validatedData['cliente_id'])
            ->where('clase_id', $validatedData['clase_id'])
            ->exists();
    
        if ($inscripcionExistente) {
            return response()->json([
                'status' => 'error',
                'message' => 'El cliente ya está inscrito en esta clase.',
            ]);
        }
    
        // Crear una nueva inscripción en la tabla asistencias_clases
        $asistencia = AsistenciaClase::create([
            'cliente_id' => $validatedData['cliente_id'],
            'clase_id' => $validatedData['clase_id'],
            'fecha_asistencia' => now(), // Usar la fecha actual
            'asistio' => 0, // Por defecto no ha asistido
        ]);
    
        // Reducir el número máximo de participantes en la clase
        $clase = Clase::findOrFail($validatedData['clase_id']);
        if ($clase->num_max_participantes > 0) {
            $clase->num_max_participantes -= 1;
            $clase->save();
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No quedan lugares disponibles en esta clase.',
            ]);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Inscripción registrada correctamente.',
            'data' => $asistencia,
        ]);
    }


    public function clasesInscritas($cliente_id){
    // Validar si el cliente existe
    $cliente = Cliente::find($cliente_id);

    if (!$cliente) {
        return response()->json([
            'status' => 'error',
            'message' => 'Cliente no encontrado'
        ], 404);
    }

    // Obtener todas las clases inscritas por el cliente
    $clases = AsistenciaClase::where('cliente_id', $cliente_id)
        ->with('clase') // Cargar la relación con la clase
        ->get();

    // Validar si el cliente no tiene clases inscritas
    if ($clases->isEmpty()) {
        return response()->json([
            'status' => 'success',
            'message' => 'No estás inscrito en ninguna clase',
            'data' => []
        ]);
    }

    // Formatear los datos para enviar a la app
    $data = $clases->map(function ($asistencia) {
        return [
            'clase_id' => $asistencia->clase->id,
            'nombre' => $asistencia->clase->nombre,
            'fecha_hora' => $asistencia->clase->fecha_hora,
            'entrenador' => $asistencia->clase->empleado->nombre ?? 'Sin entrenador asignado',
            'lugar' => $asistencia->clase->lugar,
            'descripcion' => $asistencia->clase->descripcion,
        ];
    });

    return response()->json([
        'status' => 'success',
        'message' => 'Clases inscritas obtenidas correctamente',
        'data' => $data
    ]);
}


public function cancelarInscripcion(Request $request, $claseId)
{
    // Obtener el cliente logueado
    $clienteId = $request->input('cliente_id');

    // Validar que se envió el ID del cliente
    if (!$clienteId) {
        return response()->json([
            'status' => 'error',
            'message' => 'El ID del cliente es requerido.'
        ], 400);
    }

    // Buscar la inscripción en la tabla asistencias_clases
    $inscripcion = AsistenciaClase::where('clase_id', $claseId)
        ->where('cliente_id', $clienteId)
        ->first();

    // Validar si la inscripción existe
    if (!$inscripcion) {
        return response()->json([
            'status' => 'error',
            'message' => 'No se encontró una inscripción para esta clase y cliente.'
        ], 404);
    }

    // Eliminar la inscripción
    $inscripcion->delete();

    // (Opcional) Incrementar el número de participantes disponibles en la clase
    $clase = $inscripcion->clase;
    if ($clase) {
        $clase->num_max_participantes += 1;
        $clase->save();
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Inscripción cancelada exitosamente.'
    ]);
}
}
