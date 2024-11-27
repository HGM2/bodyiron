<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;

class HomeController extends Controller
{
    public function index()
    {
        $membresias = Membership::all();
        return view('welcome', compact('membresias'));
    }
}

