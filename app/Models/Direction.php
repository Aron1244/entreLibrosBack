<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'direccion',
        'ciudad',
        'region',
        'codigo_postal',
        'pais',
        'telefono',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
