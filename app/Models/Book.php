<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'categoria',
        'tipo',
        'precio',
        'imagen',
        'editorial',
        'autor',
        'isbn',
        'paginas',
        'idioma',
        'fecha_publicacion',
        'formato',
        'dimensiones',
        'peso',
        'stock',
        'rating',
        'reviews',
        'generos',
        'tags',
        'archivo_epub'
    ];

    protected $casts = [
        'generos' => 'array',
        'tags' => 'array',
        'rating' => 'float',
        'precio' => 'float',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}