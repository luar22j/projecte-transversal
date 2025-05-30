<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estado extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }
} 