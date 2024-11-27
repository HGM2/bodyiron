<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecepcionistaController extends Controller
{
    public function index()
    {
        // Solo retornar la vista sin compactar el menú
        return view('recepcionista.dashboard');
    }
}
