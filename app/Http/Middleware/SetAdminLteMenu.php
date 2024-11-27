<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SetAdminLteMenu
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                config(['adminlte.menu' => [
                    ['header' => 'ADMINISTRACIÓN'],
                    [
                        'text' => 'Gestión de Usuarios',
                        'url'  => 'admin/usuarios',
                        'icon' => 'fas fa-fw fa-users',
                    ],
                    [
                        'text' => 'Gestión de Membresías',
                        'url'  => 'admin/memberships',
                        'icon' => 'fas fa-fw fa-id-card',
                    ],
                    [
                        'text' => 'Gestión de Clases',
                        'url'  => 'admin/classes',
                        'icon' => 'fas fa-fw fa-calendar',
                    ],
                    [
                        'text' => 'Gestión de Empleados',
                        'url'  => 'admin/empleados',
                        'icon' => 'fas fa-fw fa-user-tie',
                    ],
                ]]);
            } elseif ($user->role === 'recepcionista') {
                config(['adminlte.menu' => [
                    ['header' => 'GESTIÓN DE RECEPCIÓN'],
                    [
                        'text' => 'Gestión de Clientes',
                        'url'  => 'recepcion/clientes',
                        'icon' => 'fas fa-fw fa-users',
                    ],
                    [
                        'text' => 'Gestión de Membresías',
                        'url'  => 'recepcion/membresias',
                        'icon' => 'fas fa-fw fa-id-card',
                    ],
                ]]);
            }
        }

        return $next($request);
    }
}
