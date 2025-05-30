<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($carrito) {
            $carrito->subtotal = $carrito->cantidad * $carrito->precio_unitario;
        });

        static::updating(function ($carrito) {
            $carrito->subtotal = $carrito->cantidad * $carrito->precio_unitario;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
