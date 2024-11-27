<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CitaNutricionista extends Model
{
    use HasFactory;

    protected $table = 'citas_nutricionista';

    protected $fillable = [
        'cliente_id',
        'nutricionista_id',
        'fecha_hora',
        'descripcion',
        'asistio', // Se incluye para registrar la asistencia del cliente
    ];

    protected $dates = [
        'fecha_hora', // Para garantizar que fecha_hora se maneje como instancia de Carbon
    ];

    /**
     * Relación con el cliente (usuario que reservó la cita)
     */
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    /**
     * Relación con el nutricionista
     */
    public function nutricionista()
    {
        return $this->belongsTo(User::class, 'nutricionista_id');
    }
}
