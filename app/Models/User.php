<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'password',
        'direccion',
        'direccion_envio',
        'direccion_facturacion',
        'fecha_nacimiento',
        'telefono',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'fecha_nacimiento' => 'date'
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Relación con los roles del usuario
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Verifica si el usuario tiene un rol específico
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles()->where('nombre', $role)->exists();
        }
        return !!$role->intersect($this->roles)->count();
    }

    /**
     * Verifica si el usuario tiene alguno de los roles especificados
     */
    public function hasAnyRole($roles)
    {
        if (is_string($roles)) {
            return $this->hasRole($roles);
        }
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verifica si el usuario tiene todos los roles especificados
     */
    public function hasAllRoles($roles)
    {
        if (is_string($roles)) {
            return $this->hasRole($roles);
        }
        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {
                return false;
            }
        }
        return true;
    }
}