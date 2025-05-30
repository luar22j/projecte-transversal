<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'porcentaje',
        'fecha_inicio',
        'fecha_fin',
        'activo'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
        'porcentaje' => 'decimal:2'
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'descuento_producto')
            ->withTimestamps();
    }

    public function estaActivo()
    {
        $now = now();
        return $this->activo && 
               $now->between($this->fecha_inicio, $this->fecha_fin);
    }
} 