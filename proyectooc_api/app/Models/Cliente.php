<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Cliente extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'telefono',
        'google_id',
        'contraseña',
        'direccion',
        'imagen',
        'estado',
    ];

    protected $hidden = [
        'contraseña',
    ];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'contraseña' => 'hashed',
        ];
    }

    public function getAuthPassword(): string
    {
        return $this->contraseña;
    }
}
