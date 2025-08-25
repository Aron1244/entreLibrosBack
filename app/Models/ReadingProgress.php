<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'pagina_actual',
        'porcentaje',
        'configuracion',
    ];

    protected $casts = [
        'configuracion' => 'array',
        'porcentaje' => 'float',
    ];
}
