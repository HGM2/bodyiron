<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    /**
     * Muestra una lista de los tipos de membresías.
     */
    public function index()
    {
        $memberships = Membership::all(); // Carga todas las membresías
        return view('admin.memberships.index', compact('memberships'));
    }

    /**
     * Muestra el formulario para crear un nuevo tipo de membresía.
     */
    public function create()
    {
        return view('admin.memberships.create');
    }

    /**
     * Almacena un nuevo tipo de membresía en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'duracion' => 'required|integer|min:1', // Duración en meses
        ]);

        Membership::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'duracion' => $request->duracion,
        ]);

        return redirect()->route('admin.memberships.index')->with('success', 'Tipo de membresía creada exitosamente.');
    }

    /**
     * Muestra el formulario para editar un tipo de membresía existente.
     */
    public function edit($id)
    {
        $membresia = Membership::findOrFail($id);
        return view('admin.memberships.edit', compact('membresia'));
    }

    /**
     * Actualiza un tipo de membresía existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'duracion' => 'required|integer|min:1',
        ]);

        $membresia = Membership::findOrFail($id);
        $membresia->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'duracion' => $request->duracion,
        ]);

        return redirect()->route('admin.memberships.index')->with('success', 'Tipo de membresía actualizada exitosamente.');
    }

    /**
     * Elimina un tipo de membresía de la base de datos.
     */
    public function destroy($id)
    {
        $membresia = Membership::findOrFail($id);
        $membresia->delete();

        return redirect()->route('admin.memberships.index')->with('success', 'Tipo de membresía eliminada exitosamente.');
    }
}
