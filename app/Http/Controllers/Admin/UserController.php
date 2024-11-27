<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'tipo' => 'required|in:admin,recepcionista,empleado,nutricionista,entrenador',
            'password' => 'required|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_capturada' => 'nullable|string', // Para la foto capturada desde la cámara
        ]);
    
        $fotoPath = null;
    
        // Procesar foto capturada
        if ($request->filled('foto_capturada')) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->foto_capturada));
            $fotoPath = 'fotos/' . uniqid() . '.png';
            Storage::disk('public')->put($fotoPath, $imageData);
        }
        // Procesar foto cargada
        elseif ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos', 'public');
        }
    
        Usuario::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'email' => $request->email,
            'tipo' => $request->tipo,
            'password' => bcrypt($request->password),
            'foto' => $fotoPath,
        ]);
    
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }
    public function edit(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $id,
            'tipo' => 'required|in:admin,recepcionista,empleado,nutricionista,entrenador',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $usuario = Usuario::findOrFail($id);
        if ($request->hasFile('foto')) {
            // Elimina la foto anterior si existe
            if ($usuario->foto && Storage::disk('public')->exists($usuario->foto)) {
                Storage::disk('public')->delete($usuario->foto);
            }
            $usuario->foto = $request->file('foto')->store('fotos', 'public');
        }

        $usuario->update([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'email' => $request->email,
            'tipo' => $request->tipo,
            'password' => $request->password ? bcrypt($request->password) : $usuario->password,
            'foto' => $usuario->foto,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        if ($usuario->foto && Storage::disk('public')->exists($usuario->foto)) {
            Storage::disk('public')->delete($usuario->foto);
        }
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
