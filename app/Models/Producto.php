<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'ventas',
        'categoria_id',
        'subcategoria_id',
        'imagen'
    ];

    protected $appends = ['imagen_url', 'categoria_nombre'];

    public function getImagenUrlAttribute()
    {
        if ($this->imagen) {
            if (str_starts_with($this->imagen, 'http')) {
                return $this->imagen;
            }
            return asset('images/' . $this->imagen);
        }
        return null;
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function getCategoriaNombreAttribute()
    {
        return $this->categoria ? $this->categoria->nombre : 'Sin categoría';
    }

    public function subcategoria(): BelongsTo
    {
        return $this->belongsTo(Subcategoria::class);
    }

    public function carritos(): HasMany
    {
        return $this->hasMany(Carrito::class);
    }

    public function pedidos(): BelongsToMany
    {
        return $this->belongsToMany(Pedido::class, 'detalles_pedido')
            ->withPivot('cantidad', 'precio_unitario')
            ->withTimestamps();
    }

    public function descuentos()
    {
        return $this->belongsToMany(Descuento::class, 'descuento_producto')
            ->withTimestamps();
    }

    public function getDescuentoActivoAttribute()
    {
        return $this->descuentos()
            ->where('activo', true)
            ->where('fecha_inicio', '<=', now())
            ->where('fecha_fin', '>=', now())
            ->orderBy('porcentaje', 'desc')
            ->first();
    }

    public function getPrecioConDescuentoAttribute()
    {
        $descuento = $this->descuento_activo;
        if ($descuento) {
            return $this->precio * (1 - $descuento->porcentaje / 100);
        }
        return $this->precio;
    }
}
