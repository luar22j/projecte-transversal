<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    protected $fillable = [
        'user_id',
        'estado_id',
        'total',
        'subtotal',
        'coste_envio',
        'direccion_envio',
        'codigo_postal',
        'ciudad',
        'telefono',
        'metodo_pago'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoPedido::class, 'estado_id');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(PedidoDetalle::class);
    }
}
