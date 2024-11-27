<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\NutricionistaController;
use App\Http\Controllers\EntrenadorController;
use App\Http\Controllers\RecepcionistaController;
use App\Http\Controllers\Admin\EmpleadoController;
use App\Http\Controllers\Recepcion\ClienteController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Página de inicio
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/', [HomeController::class, 'index'])->name('welcome');

// Redirección dinámica para cada rol al hacer clic en "Dashboard"
Route::get('/dashboard', function () {
    if (Auth::check()) {
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'nutricionista':
                return redirect()->route('nutricionista.dashboard');
            case 'entrenador':
                return redirect()->route('entrenador.dashboard');
            case 'recepcionista':
                return redirect()->route('recepcionista.dashboard');
            default:
                return view('dashboard');
        }
    }
    return redirect()->route('home');
})->name('dashboard');

// Rutas de perfil protegidas para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas específicas por rol
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Rutas para la gestión de usuarios
    Route::resource('/admin/usuarios', UserController::class)->names('admin.usuarios');

    // Rutas para la gestión de membresías
    Route::resource('/admin/memberships', MembershipController::class)->names([
        'index' => 'admin.memberships.index',
        'create' => 'admin.memberships.create',
        'store' => 'admin.memberships.store',
        'show' => 'admin.memberships.show',
        'edit' => 'admin.memberships.edit',
        'update' => 'admin.memberships.update',
        'destroy' => 'admin.memberships.destroy',
    ]);

    // Rutas para la gestión de clases
    Route::resource('/admin/classes', ClassController::class)->names([
        'index' => 'admin.classes.index',
        'create' => 'admin.classes.create',
        'store' => 'admin.classes.store',
        'show' => 'admin.classes.show',
        'edit' => 'admin.classes.edit',
        'update' => 'admin.classes.update',
        'destroy' => 'admin.classes.destroy',
    ]);
    Route::get('admin/classes/{class}/attendance', [ClassController::class, 'attendanceChecklist'])->name('admin.classes.attendance');
    Route::put('admin/classes/{class}/attendance', [ClassController::class, 'updateAttendance'])->name('admin.classes.attendance.update');

    // Rutas para la gestión de empleados
    Route::resource('/admin/empleados', EmpleadoController::class)->names('admin.empleados');
});

// Rutas para el nutricionista
Route::prefix('nutricionista')->name('nutricionista.')->middleware(['auth', 'role:nutricionista'])->group(function () {
    Route::get('/', [NutricionistaController::class, 'index'])->name('dashboard');
    Route::get('/citas', [NutricionistaController::class, 'viewAppointments'])->name('citas.index');
    Route::get('/disponibilidad', [NutricionistaController::class, 'showAvailabilityForm'])->name('disponibilidad.form');
    Route::post('/disponibilidad', [NutricionistaController::class, 'updateAvailability'])->name('disponibilidad.update');
    Route::post('/citas/{appointmentId}/notas', [NutricionistaController::class, 'addNotes'])->name('citas.addNotes');
    Route::post('/citas/{appointmentId}/asistencia', [NutricionistaController::class, 'registerAttendance'])->name('citas.registerAttendance');
    Route::post('/citas/bulk-register', [NutricionistaController::class, 'registerBulkAttendance'])->name('citas.bulkRegisterAttendance');
    Route::get('/reporte', [NutricionistaController::class, 'generateReport'])->name('generateReport');
    Route::get('/reporte/grafico', [NutricionistaController::class, 'exportCitasGrafico'])->name('generateExcel');
    Route::get('/nutricionista/grafico', [NutricionistaController::class, 'showGrafico'])->name('grafico');

});




// Rutas para el rol de entrenador
Route::middleware(['auth', 'role:entrenador'])->group(function () {
    Route::get('/entrenador', [EntrenadorController::class, 'index'])->name('entrenador.dashboard');

    Route::get('/entrenador/clases/{class}/reporte', [EntrenadorController::class, 'generarReporte'])->name('entrenador.clases.asistencias.reporte');
  
    // Rutas para la gestión de asistencias de clases (para el entrenador)
    Route::get('/entrenador/clases', [EntrenadorController::class, 'listClasses'])->name('entrenador.clases.index');
    Route::get('/entrenador/clases/{class}/asistencias', [EntrenadorController::class, 'attendanceChecklist'])->name('entrenador.clases.asistencias');
    Route::put('/entrenador/clases/{class}/asistencias', [EntrenadorController::class, 'updateAttendance'])->name('entrenador.clases.asistencias.update');
});

// Rutas para el rol de recepcionista
Route::middleware(['auth', 'role:recepcionista'])->group(function () {
    Route::get('/recepcionista', [RecepcionistaController::class, 'index'])->name('recepcionista.dashboard');

    // Ruta personalizada para pagar membresía
    Route::get('recepcionista/clientes/{cliente}/pagar', [ClienteController::class, 'pagar'])->name('recepcion.clientes.pagar');
    Route::put('recepcionista/clientes/{cliente}/pagar', [ClienteController::class, 'actualizarPago'])->name('recepcion.clientes.actualizarPago');

    Route::get('recepcionista/clientes/{cliente}/ticket', [ClienteController::class, 'generarTicket'])->name('recepcion.clientes.ticket');
    Route::get('recepcionista/clientes/reporte', [ClienteController::class, 'reporte'])->name('recepcion.clientes.reporte');
    Route::get('/exportar-clientes', [ClienteController::class, 'exportClientes'])->name('exportar.clientes');

    // Rutas para la gestión de clientes
    Route::resource('recepcionista/clientes', ClienteController::class)->names([
        'index' => 'recepcion.clientes.index',
        'create' => 'recepcion.clientes.create',
        'store' => 'recepcion.clientes.store',
        'edit' => 'recepcion.clientes.edit',
        'update' => 'recepcion.clientes.update',
        'destroy' => 'recepcion.clientes.destroy',
    ]);

    // Rutas para la gestión de membresías específicas de recepcionista
    Route::resource('recepcionista/memberships', MembershipController::class)->names([
        'index' => 'recepcion.membresias.index',
        'create' => 'recepcion.membresias.create',
        'store' => 'recepcion.membresias.store',
        'edit' => 'recepcion.membresias.edit',
        'update' => 'recepcion.membresias.update',
        'destroy' => 'recepcion.membresias.destroy',
    ]);
});

// Archivo de rutas de autenticación generadas por Laravel
require __DIR__.'/auth.php';
