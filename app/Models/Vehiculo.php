<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';

    protected $fillable = [
        'placa',
        'marca',
        'modelo',
        'anio_fabricacion',
        'nombre_cliente',
        'apellidos_cliente',
        'nro_documento',
        'correo_cliente',
        'telefono_cliente',
    ];

    protected $casts = [
        'anio_fabricacion' => 'integer',
    ];

    //PARA JALAR EL NOMBRE COMPLETO OSEA LO CONCATENO
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre_cliente} {$this->apellidos_cliente}";
    }

    //PARA BUSCAR LOS CARROS
    public function scopeBuscar($query, string $termino)
    {
        return $query->where('placa',             'like', "%{$termino}%")
                     ->orWhere('marca',            'like', "%{$termino}%")
                     ->orWhere('modelo',           'like', "%{$termino}%")
                     ->orWhere('nombre_cliente',   'like', "%{$termino}%")
                     ->orWhere('apellidos_cliente','like', "%{$termino}%")
                     ->orWhere('nro_documento',    'like', "%{$termino}%")
                     ->orWhere('correo_cliente',   'like', "%{$termino}%");
    }
}
