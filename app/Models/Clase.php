<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Empleado;

class Clase extends Model
{
    use HasFactory;

    protected $table = 'clases';

    protected $fillable = [
        'nombre',
        'fecha_hora',
        'empleado_id',
        'num_max_participantes',
        'lugar',
        'descripcion',
    ];

    // Relación con el modelo Empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    // Alias para la relación empleado (usado específicamente para el rol de entrenador)
    public function instructor()
    {
        return $this->empleado();
    }

    // Relación con los clientes a través de la tabla intermedia asistencias_clases
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'asistencias_clases', 'clase_id', 'cliente_id')
                    ->withPivot('asistio', 'fecha_asistencia')
                    ->withTimestamps();
    }
}
