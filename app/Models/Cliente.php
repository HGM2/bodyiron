<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'password', // Contraseña almacenada en texto plano
        'username',
        'direccion',
        'telefono',
        'fecha_registro',
        'fecha_vencimiento',
        'tipo_membresia',
        'foto',
        'qr_codigo',
    ];

    

    protected $dates = [
        'fecha_registro',
        'fecha_vencimiento',
        'created_at',
        'updated_at',
    ];

    // Relación con la tabla intermedia asistencias_clases
    public function clases()
    {
        return $this->belongsToMany(Clase::class, 'asistencias_clases', 'cliente_id', 'clase_id')
                    ->withPivot('asistio', 'fecha_asistencia')
                    ->withTimestamps();
    }

    // Relación con Membresia
    public function membresia()
    {
        return $this->belongsTo(Membership::class, 'tipo_membresia', 'id');
    }

    // Accesor para obtener la URL de la foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return asset('storage/' . $this->foto);
        }

        return asset('images/sin-foto.png');
    }

    // Accesor para obtener la URL del QR
    public function getQrUrlAttribute()
    {
        if ($this->qr_codigo && Storage::disk('public')->exists($this->qr_codigo)) {
            return asset('storage/' . $this->qr_codigo);
        }

        return null;
    }

    // Accesor para obtener la vigencia
    public function getVigenciaAttribute()
    {
        if (!$this->fecha_vencimiento) {
            return 'Sin fecha de vencimiento';
        }

        return $this->fecha_vencimiento->isFuture() ? 'Vigente' : 'Vencido';
    }

        ///api
        public function asistencias(){
        
            return $this->hasMany(AsistenciaClase::class, 'cliente_id');
        }
}
