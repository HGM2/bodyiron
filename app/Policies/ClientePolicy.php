<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class ClientePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $usuario): bool
    {
        // Solo admin y recepcionista pueden ver la lista de clientes
        return in_array($usuario->role, ['admin', 'recepcionista']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $usuario, Cliente $cliente): bool
    {
        // Admin y recepcionista pueden ver los detalles de cualquier cliente
        return in_array($usuario->role, ['admin', 'recepcionista']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $usuario): bool
    {
        // Solo admin y recepcionista pueden crear clientes
        return in_array($usuario->role, ['admin', 'recepcionista']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $usuario, Cliente $cliente): bool
    {
        // Solo admin y recepcionista pueden actualizar clientes
        return in_array($usuario->role, ['admin', 'recepcionista']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $usuario, Cliente $cliente): bool
    {
        // Solo admin puede eliminar clientes
        return $usuario->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Usuario $usuario, Cliente $cliente): bool
    {
        // Solo admin puede restaurar clientes eliminados
        return $usuario->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Usuario $usuario, Cliente $cliente): bool
    {
        // Solo admin puede eliminar clientes permanentemente
        return $usuario->role === 'admin';
    }
}
