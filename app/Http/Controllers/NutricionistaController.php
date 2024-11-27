<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CitaNutricionista;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Carbon\Carbon;

class NutricionistaController extends Controller
{
    public function index()
    {
        $citas = CitaNutricionista::where('nutricionista_id', Auth::id())
            ->orderBy('fecha_hora', 'asc')
            ->get();

        return view('nutricionista.dashboard', compact('citas'));
    }

    public function viewAppointments()
    {
        $citas = CitaNutricionista::where('nutricionista_id', Auth::id())
            ->orderBy('fecha_hora', 'asc')
            ->get();

        return view('nutricionista.citas.index', compact('citas'));
    }

    public function showAvailabilityForm()
    {
        return view('nutricionista.citas.update_availability');
    }

    public function updateAvailability(Request $request)
    {
        $request->validate([
            'fecha_disponible' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);
    
        $nutricionistaId = Auth::id();
        $horaInicio = Carbon::parse($request->fecha_disponible . ' ' . $request->hora_inicio);
        $horaFin = Carbon::parse($request->fecha_disponible . ' ' . $request->hora_fin);
    
        while ($horaInicio < $horaFin) {
            $existeCita = CitaNutricionista::where('nutricionista_id', $nutricionistaId)
                ->where('fecha_hora', $horaInicio->format('Y-m-d H:i:s'))
                ->exists();

            if (!$existeCita) {
                CitaNutricionista::create([
                    'nutricionista_id' => $nutricionistaId,
                    'fecha_hora' => $horaInicio->format('Y-m-d H:i:s'),
                    'cliente_id' => null,
                ]);
            }

            $horaInicio->addHour();
        }
    
        return redirect()->route('nutricionista.citas.index')->with('success', 'Disponibilidad registrada correctamente.');
    }

    public function viewAvailableAppointments()
    {
        $citasDisponibles = CitaNutricionista::whereNull('cliente_id')
            ->where('fecha_hora', '>=', Carbon::now())
            ->orderBy('fecha_hora', 'asc')
            ->get();

        return view('clientes.citas.disponibles', compact('citasDisponibles'));
    }

    public function addNotes(Request $request, $appointmentId)
    {
        $request->validate([
            'notas' => 'required|string|max:1000',
        ]);

        $cita = CitaNutricionista::find($appointmentId);

        if (!$cita) {
            return redirect()->route('nutricionista.citas.index')->with('error', 'La cita no existe.');
        }

        $cita->descripcion = $request->input('notas');
        $cita->save();

        return redirect()->route('nutricionista.citas.index')->with('success', 'Notas agregadas a la cita.');
    }

    public function registerAttendance(Request $request)
    {
        $request->validate([
            'asistencias' => 'array',
            'asistencias.*' => 'exists:citas_nutricionista,id',
        ]);

        $nutricionistaId = Auth::id();

        // Registrar asistencia
        $citas = CitaNutricionista::where('nutricionista_id', $nutricionistaId)->get();

        foreach ($citas as $cita) {
            $cita->asistio = in_array($cita->id, $request->input('asistencias', []));
            $cita->save();
        }

        return redirect()->route('nutricionista.citas.index')->with('success', 'Asistencias actualizadas correctamente.');
    }


    public function registerBulkAttendance(Request $request)
{
    // Validar que se reciban asistencias
    $request->validate([
        'asistencias' => 'nullable|array',
        'asistencias.*' => 'exists:citas_nutricionista,id',
    ]);

    $nutricionistaId = Auth::id();

    // Recuperar todas las citas del nutricionista
    $citas = CitaNutricionista::where('nutricionista_id', $nutricionistaId)->get();

    foreach ($citas as $cita) {
        // Si la cita está en el arreglo de asistencias, marcamos como asistida
        if (in_array($cita->id, $request->asistencias ?? [])) {
            $cita->asistio = true;
        } else {
            // De lo contrario, marcamos como no asistida
            $cita->asistio = false;
        }
        $cita->save();
    }

    return redirect()->route('nutricionista.citas.index')->with('success', 'Asistencias registradas correctamente.');
}

public function generateReport()
{
    $nutricionistaId = Auth::id();

    // Obtiene las citas del nutricionista actual
    $citas = CitaNutricionista::where('nutricionista_id', $nutricionistaId)
        ->with('cliente')
        ->orderBy('fecha_hora', 'asc')
        ->get();

    $reporte = [
        'total' => $citas->count(),
        'asistieron' => $citas->where('asistio', true)->count(),
        'no_asistieron' => $citas->where('asistio', false)->count(),
    ];

    // Si es necesario generar un archivo PDF
    $pdf = app('dompdf.wrapper');
    $pdf->loadView('nutricionista.report', compact('citas', 'reporte'));

    return $pdf->stream('reporte_citas_nutricionista.pdf');
}


public function showGrafico()
{
    $nutricionistaId = Auth::id();

    // Obtener los datos de las citas
    $citas = CitaNutricionista::where('nutricionista_id', $nutricionistaId)->get();
    $asistieron = $citas->where('asistio', true)->count();
    $noAsistieron = $citas->where('asistio', false)->count();

    return view('nutricionista.grafico', compact('asistieron', 'noAsistieron'));
}

public function exportCitasGrafico()
{
    // Datos reales para el reporte
    $nutricionistaId = Auth::id();
    $citas = CitaNutricionista::where('nutricionista_id', $nutricionistaId)->get();

    $reporte = [
        'asistieron' => $citas->where('asistio', true)->count(),
        'no_asistieron' => $citas->where('asistio', false)->count(),
    ];

    // Configurar los datos del gráfico
    $chartConfig = [
        'type' => 'bar',
        'data' => [
            'labels' => ['Asistieron', 'No Asistieron'],
            'datasets' => [[
                'label' => 'Citas',
                'data' => [$reporte['asistieron'], $reporte['no_asistieron']],
                'backgroundColor' => ['#4CAF50', '#F44336'], // Colores para las barras
            ]],
        ],
        'options' => [
            'plugins' => [
                'legend' => ['display' => true],
            ],
        ],
    ];

    // URL de la API de QuickChart con los datos
    $chartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig));

    // Descargar la imagen del gráfico
    $chartImagePath = storage_path('app/public/chart.png'); // Ruta para guardar temporalmente la imagen
    file_put_contents($chartImagePath, file_get_contents($chartUrl));

    // Crear una nueva hoja de cálculo
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Reporte de Citas');

    // Agregar datos
    $sheet->setCellValue('A1', 'Estado');
    $sheet->setCellValue('B1', 'Cantidad');
    $sheet->setCellValue('A2', 'Asistieron');
    $sheet->setCellValue('B2', $reporte['asistieron']);
    $sheet->setCellValue('A3', 'No Asistieron');
    $sheet->setCellValue('B3', $reporte['no_asistieron']);

    // Insertar la imagen del gráfico en la hoja de cálculo
    $drawing = new Drawing();
    $drawing->setName('Gráfico de Citas');
    $drawing->setDescription('Gráfico de Citas');
    $drawing->setPath($chartImagePath); // Ruta de la imagen descargada
    $drawing->setHeight(400); // Altura de la imagen
    $drawing->setCoordinates('D1'); // Posición en la hoja
    $drawing->setWorksheet($sheet);

    // Descargar el archivo Excel con el gráfico
    $writer = new Xlsx($spreadsheet);
    $fileName = 'reporte_citas_con_imagen.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    $writer->save('php://output');
    exit;
}


 ///parete de la API
    
    // Obtener citas disponibles para una fecha específica
    public function getCitasDisponibles(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'fecha' => 'required|date', // Espera un parámetro `fecha` en formato YYYY-MM-DD
        ]);
    
        $fechaSeleccionada = $request->input('fecha');
    
        // Consultar las citas disponibles en la base de datos para esa fecha
        $citas = CitaNutricionista::whereDate('fecha_hora', $fechaSeleccionada)
            ->where('asistio', 0) // Solo citas no asistidas
            ->whereNull('cliente_id') // Filtrar las citas que no estén ocupadas
            ->get(['id', 'fecha_hora']); // Seleccionar solo los campos necesarios
    
        if ($citas->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No hay citas disponibles para esta fecha.',
                'data' => []
            ]);
        }
    
        return response()->json([
            'status' => 'success',
            'data' => $citas
        ]);
    }
    
    
    // Obtener días disponibles

    public function getDiasDisponibles()
    {
        // Obtener las fechas únicas donde hay citas disponibles
        $diasDisponibles = CitaNutricionista::where('asistio', 0) // Solo citas no ocupadas
            ->selectRaw('DATE(fecha_hora) as fecha') // Extraer solo la fecha (sin hora)
            ->distinct() // Asegurarse de que no se repiten
            ->pluck('fecha'); // Obtener solo los valores de la columna `fecha`
    
        return response()->json([
            'status' => 'success',
            'data' => $diasDisponibles
        ]);
    }


   // Confirmar cita
   public function confirmarCita(Request $request, $id)
   {
       $request->validate([
           'cliente_id' => 'required|exists:clientes,id', // Validar que cliente_id exista
       ]);

       $cita = CitaNutricionista::findOrFail($id);

       // Verificar si la cita ya está reservada
       if (!is_null($cita->cliente_id)) {
           return response()->json([
               'status' => 'error',
               'message' => 'Esta cita ya está reservada por otro cliente.',
           ], 400);
       }

       // Asignar cliente_id y guardar
       $cita->cliente_id = $request->input('cliente_id');
       $cita->save();

       return response()->json([
           'status' => 'success',
           'message' => 'Cita confirmada exitosamente.',
       ]);
   }


}
