<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntrenadorController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\NutricionistaController;
use App\Http\Controllers\Recepcion\ClienteController;

Route::post('login', [ClienteController::class, 'login']);
Route::get('clases', [ClassController::class, 'fetchClases']);
Route::post('inscribir', [EntrenadorController::class, 'inscribir']);
Route::get('clases-inscritas/{cliente_id}', [EntrenadorController::class, 'clasesInscritas']);
Route::post('cancelar-inscripcion/{claseId}', [EntrenadorController::class, 'cancelarInscripcion']);
Route::post('/update-cliente/{id}', [ClienteController::class, 'updateFromApp']);
Route::get('citas-disponibles', [NutricionistaController::class, 'getCitasDisponibles']);
Route::get('/dias-disponibles', [NutricionistaController::class, 'getDiasDisponibles']);
Route::post('/confirmar-cita/{id}', [NutricionistaController::class, 'confirmarCita']);







