<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'description'];

    /**
     * Relación con los usuarios que tienen este rol
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
