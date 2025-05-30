<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'slug'
    ];

    public function subcategorias(): HasMany
    {
        return $this->hasMany(Subcategoria::class);
    }
}
