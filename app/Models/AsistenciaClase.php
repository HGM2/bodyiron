<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Clase;

class AsistenciaClase extends Model
{
    use HasFactory;

    protected $table = 'asistencias_clases'; // Nombre de la tabla intermedia correcto

    protected $fillable = [
        'cliente_id',
        'clase_id',
        'asistio',
        'fecha_asistencia',
    ];

    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación con la clase
    public function clase()
    {
        return $this->belongsTo(Clase::class, 'clase_id');
    }

    
}
