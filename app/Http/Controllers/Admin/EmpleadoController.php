<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('admin.empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('admin.empleados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:empleados',
            'puesto' => 'required|string',
            'salario_hora' => 'required|numeric|min:0',
            'experiencia' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'fecha_contratacion' => 'required|date',
        ]);
    
        $empleadoData = $request->all();
    
        if ($request->hasFile('foto')) {
            $empleadoData['foto'] = $request->file('foto')->store('fotos_empleados', 'public');
        }
    
        Empleado::create($empleadoData);
    
        return redirect()->route('admin.empleados.index')->with('success', 'Empleado creado exitosamente.');
    }

    public function edit(Empleado $empleado)
    {
        return view('admin.empleados.edit', compact('empleado'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:empleados,email,' . $empleado->id,
            'puesto' => 'required|string',
            'salario_hora' => 'required|numeric|min:0',
            'experiencia' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $empleadoData = $request->all();

        if ($request->hasFile('foto')) {
            if ($empleado->foto) {
                Storage::disk('public')->delete($empleado->foto);
            }
            $empleadoData['foto'] = $request->file('foto')->store('fotos_empleados', 'public');
        }

        $empleado->update($empleadoData);

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy(Empleado $empleado)
    {
        if ($empleado->foto) {
            Storage::disk('public')->delete($empleado->foto);
        }

        $empleado->delete();

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }
}
