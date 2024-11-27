<?php

namespace App\Http\Controllers\Recepcion;

use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\Membership;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('membresia')->get();
        return view('recepcionista.clientes.index', compact('clientes'));
    }

    public function create()
    {
        $membresias = Membership::all();
        return view('recepcionista.clientes.create', compact('membresias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes',
            'password' => 'required|string|min:8|confirmed',
            'username' => 'required|string|max:255|unique:clientes',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string',
            'tipo_membresia' => 'required|exists:membresias,id',
            'foto_subida' => 'nullable|image|max:2048',
            'foto_capturada' => 'nullable|string',
        ]);
    
        $clienteData = $request->except(['password', 'password_confirmation']);
        $clienteData['password'] = Hash::make($request->password); // Encriptar la contraseña
    
        // Manejo de la foto capturada o subida
        if ($request->filled('foto_capturada')) {
            $fotoBase64 = $request->input('foto_capturada');
            $foto = str_replace('data:image/png;base64,', '', $fotoBase64);
            $foto = str_replace(' ', '+', $foto);
            $fotoNombre = 'foto_cliente_' . time() . '.png';
    
            Storage::disk('public')->put('fotos_clientes/' . $fotoNombre, base64_decode($foto));
            $clienteData['foto'] = 'fotos_clientes/' . $fotoNombre;
        } elseif ($request->hasFile('foto_subida')) {
            $clienteData['foto'] = $request->file('foto_subida')->store('fotos_clientes', 'public');
        }
    
        // Duración de membresía y fechas
        $membresia = Membership::findOrFail($request->tipo_membresia);
        $clienteData['fecha_registro'] = Carbon::now();
        $clienteData['fecha_vencimiento'] = Carbon::now()->addMonths($membresia->duracion);
    
        $cliente = Cliente::create($clienteData);
    
        // Generar QR Code
        $qrCodeData = "Cliente: " . $cliente->username . " - Válido hasta: " . $clienteData['fecha_vencimiento']->toDateString();
        $qrCodePath = 'qrcodes/' . uniqid() . '.svg';
        QrCode::format('svg')->size(300)->generate($qrCodeData, public_path('storage/' . $qrCodePath));
        $cliente->qr_codigo = $qrCodePath;
        $cliente->save();
    
        return redirect()->route('recepcion.clientes.index')->with('success', 'Cliente registrado exitosamente.');
    }
    

    public function edit(Cliente $cliente)
    {
        $membresias = Membership::all();
        return view('recepcionista.clientes.edit', compact('cliente', 'membresias'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes,email,' . $cliente->id,
            'username' => 'required|string|max:255|unique:clientes,username,' . $cliente->id,
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string',
            'tipo_membresia' => 'required|exists:membresias,id',
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|max:2048',
        ]);
    
        $clienteData = $request->except(['password', 'password_confirmation']);
    
        // Actualizar la contraseña si se proporciona
        if ($request->filled('password')) {
            $clienteData['password'] = Hash::make($request->password); // Encriptar la nueva contraseña
        }
    
        // Actualizar foto
        if ($request->filled('foto_capturada')) {
            $fotoBase64 = $request->input('foto_capturada');
            $foto = str_replace('data:image/png;base64,', '', $fotoBase64);
            $foto = str_replace(' ', '+', $foto);
            $fotoNombre = 'foto_cliente_' . time() . '.png';
    
            Storage::disk('public')->put('fotos_clientes/' . $fotoNombre, base64_decode($foto));
            $clienteData['foto'] = 'fotos_clientes/' . $fotoNombre;
        } elseif ($request->hasFile('foto')) {
            if ($cliente->foto) {
                Storage::disk('public')->delete($cliente->foto);
            }
            $clienteData['foto'] = $request->file('foto')->store('fotos_clientes', 'public');
        }
    
        // Actualizar fechas
        $membresia = Membership::findOrFail($clienteData['tipo_membresia']);
        $clienteData['fecha_vencimiento'] = Carbon::parse($cliente->fecha_registro)->addMonths($membresia->duracion);
    
        $cliente->update($clienteData);
    
        return redirect()->route('recepcion.clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Cliente $cliente)
    {
        if ($cliente->foto) {
            Storage::disk('public')->delete($cliente->foto);
        }
        if ($cliente->qr_codigo) {
            Storage::disk('public')->delete($cliente->qr_codigo);
        }

        $cliente->delete();

        return redirect()->route('recepcion.clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }

    public function pagar(Cliente $cliente)
    {
        $membresias = Membership::all();
        // dd($cliente, $membresias); // Eliminar esta línea
        return view('recepcionista.clientes.pagar', compact('cliente', 'membresias'));
    }
    
    

    public function actualizarPago(Request $request, Cliente $cliente)
    {
        $request->validate([
            'fecha_registro' => 'required|date',
            'tipo_membresia' => 'required|exists:membresias,id',
        ]);

        $cliente->fecha_registro = $request->fecha_registro;
        $cliente->tipo_membresia = $request->tipo_membresia;

        $membresia = Membership::findOrFail($request->tipo_membresia);
        $cliente->fecha_vencimiento = Carbon::parse($request->fecha_registro)->addMonths($membresia->duracion);

        // Regenerar QR Code
        $qrCodeData = "Cliente: " . $cliente->username . " - Válido hasta: " . $cliente->fecha_vencimiento->toDateString();
        $qrCodePath = 'qrcodes/' . uniqid() . '.svg';

        if ($cliente->qr_codigo) {
            Storage::disk('public')->delete($cliente->qr_codigo);
        }

        QrCode::format('svg')->size(300)->generate($qrCodeData, public_path('storage/' . $qrCodePath));
        $cliente->qr_codigo = $qrCodePath;
        $cliente->save();

        return redirect()->route('recepcion.clientes.index')->with('success', 'Pago actualizado exitosamente.');
    }


    public function reporte()
    {
        $hoy = Carbon::now();
        $vigentes = Cliente::where('fecha_vencimiento', '>=', $hoy)->get();
        $a_vencer = Cliente::whereBetween('fecha_vencimiento', [$hoy, $hoy->copy()->addDays(5)])->get();
        $vencidos = Cliente::where('fecha_vencimiento', '<', $hoy)->get();

        $gymData = [
            'nombre' => 'Body Iron Fitness',
                'direccion' => 'Av Enrique Díaz de León Nte 155
                                Zona Centro, 44100
                                Guadalajara, Jal.',
            'telefono' => '(123) 456-7890',
            'email' => 'contacto@bodyironfitness.com',
        ];

        $pdf = Pdf::loadView('recepcionista.clientes.reporte', compact('vigentes', 'a_vencer', 'vencidos', 'gymData', 'hoy'));
        return $pdf->stream('reporte_mensual_clientes.pdf');
    }

    public function generarTicket(Cliente $cliente)
{
    $gymData = [
        'nombre' => 'Body Iron Fitness',
        'direccion' => 'Av Enrique Díaz de León Nte 155, Zona Centro, 44100 Guadalajara, Jal.',
        'telefono' => '(123) 456-7890',
        'email' => 'contacto@bodyironfitness.com',
    ];

    $pdf = Pdf::loadView('recepcionista.clientes.ticket', compact('cliente', 'gymData'));
    return $pdf->stream('ticket_cliente_' . $cliente->id . '.pdf');
}

public function exportClientes()
{
    $vigentes = 50;
    $aVencer = 30;
    $vencidos = 20;

    // Crear una nueva hoja de cálculo
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Worksheet');

    // Agregar datos
    $sheet->setCellValue('A1', 'Estado');
    $sheet->setCellValue('B1', 'Cantidad');
    $sheet->setCellValue('A2', 'Vigentes');
    $sheet->setCellValue('B2', $vigentes);
    $sheet->setCellValue('A3', 'A Punto de Vencer');
    $sheet->setCellValue('B3', $aVencer);
    $sheet->setCellValue('A4', 'Vencidos');
    $sheet->setCellValue('B4', $vencidos);

    // Crear la serie de datos para el gráfico
    $dataSeriesLabels = [new DataSeriesValues('String', 'Worksheet!$B$1', null, 1)];
    $xAxisTickValues = [new DataSeriesValues('String', 'Worksheet!$A$2:$A$4', null, 3)];
    $dataSeriesValues = [new DataSeriesValues('Number', 'Worksheet!$B$2:$B$4', null, 3)];

    $series = new DataSeries(
        DataSeries::TYPE_BARCHART,
        null,
        range(0, count($dataSeriesValues) - 1),
        $dataSeriesLabels,
        $xAxisTickValues,
        $dataSeriesValues
    );

    $plotArea = new PlotArea(null, [$series]);
    $title = new Title('Reporte de Clientes');
    $chart = new Chart('Gráfico de Clientes', $title, null, $plotArea);

    $chart->setTopLeftPosition('D1');
    $chart->setBottomRightPosition('L15');
    $sheet->addChart($chart);

    // Descargar el archivo con el gráfico
    $writer = new Xlsx($spreadsheet);
    $writer->setIncludeCharts(true);

    $fileName = 'reporte_clientes_grafica.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    $writer->save('php://output');
    exit;
}


// parte de la API
public function login(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'password' => 'required|string|min:8',
    ]);

    $cliente = Cliente::where('username', $request->username)->first();

    if ($cliente && Hash::check($request->password, $cliente->password)) {
        $cliente->foto = asset('storage/' . $cliente->foto);
        $cliente->qr_codigo = asset('storage/' . $cliente->qr_codigo);

        return response()->json([
            'status' => 'success',
            'message' => 'Login exitoso',
            'data' => $cliente
        ]);
    }

    return response()->json([
        'status' => 'error',
        'message' => 'Credenciales incorrectas'
    ]);
}

public function updateFromApp(Request $request, $id)
{
    // Buscar el cliente por ID
    $cliente = Cliente::findOrFail($id);

    // Validar los datos de entrada
    $validatedData = $request->validate([
        'direccion' => 'nullable|string',
        'telefono' => 'nullable|string',
        'password' => 'nullable|string|min:8|confirmed',
        'foto' => 'nullable|image|max:2048', // Validar que sea imagen y no más de 2MB
    ]);

    $clienteData = $request->only(['direccion', 'telefono']);

    // Si se proporciona la contraseña, actualizarla
    if ($request->filled('password')) {
        $clienteData['password'] = Hash::make($request->password);
    }

    // Si se proporciona una nueva foto, actualizarla
    if ($request->hasFile('foto')) {
        // Eliminar la foto anterior si existe
        if ($cliente->foto) {
            Storage::disk('public')->delete($cliente->foto);
        }

        // Subir la nueva foto
        $clienteData['foto'] = $request->file('foto')->store('fotos_clientes', 'public');
    }

    // Actualizar la información del cliente
    $cliente->update($clienteData);

    return response()->json([
        'status' => 'success',
        'message' => 'Información actualizada exitosamente',
        'cliente' => [
            'id' => $cliente->id,
            'direccion' => $cliente->direccion,
            'telefono' => $cliente->telefono,
            'foto' => $cliente->foto ? asset('storage/' . $cliente->foto) : null,
        ],
    ]);
}



}
