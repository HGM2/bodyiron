<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    // Especifica la tabla en español
    protected $table = 'membresias';

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion', // en meses
    ];
}
