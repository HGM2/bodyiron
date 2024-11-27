<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Solo retornar la vista sin compactar el menú
        return view('admin.dashboard');
    }
}
