<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ApiTrait;

class Post extends Model
{
    use HasFactory, ApiTrait;
    
    const BORRADOR = 1;
    const PUBLICADO = 2;

    protected $fillable = [ 'name', 'slug', 'extract', 'body', 'status', 'user_id', 'category_id' ];
    // Propiedad para mostrar post relacianados a la categoria
    protected $allowIncluded = ['category', 'category.post'];
    // Propiedad para filtrar por los campos de la tabla
    protected $allowFilter = ['id', 'name', 'slug'];
    // Propiedad para ordenar por los campos de la tabla
    protected $allowSort = ['id', 'name', 'slug'];
    
    // Relación uno a muchos inversa
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación muchos a muchos
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Relación polimórfica uno a muchos
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
