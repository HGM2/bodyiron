<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; // Define la tabla a utilizar

    protected $fillable = [
        'nombre', 'apellido_paterno', 'apellido_materno', 'email', 'password', 'tipo', 'foto'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function isAdmin()
{
    return $this->tipo === 'admin';
}

public function isRecepcionista()
{
    return $this->tipo === 'recepcionista';
}

public function isEmpleado()
{
    return $this->tipo === 'empleado';
}

public function isNutricionista()
{
    return $this->tipo === 'nutricionista';
}

public function isEntrenador()
{
    return $this->tipo === 'entrenador';
}

}
