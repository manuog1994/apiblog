<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\ApiTrait;

class Category extends Model
{
    use HasFactory, ApiTrait;

    // Habilitar asignación masiva
    protected $fillable = ['name', 'slug'];
    // Propiedad para mostrar post relacianados a la categoria
    protected $allowIncluded = ['posts', 'posts.user'];
    // Propiedad para filtrar por los campos de la tabla
    protected $allowFilter = ['id', 'name', 'slug'];
    // Propiedad para ordenar por los campos de la tabla
    protected $allowSort = ['id', 'name', 'slug'];

    // Relación uno a muchos
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

   
}

