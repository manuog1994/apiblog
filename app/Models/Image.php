<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ApiTrait;


class Image extends Model
{
    use HasFactory, ApiTrait;

    // Para relación polimórfica hay que usar el mismo nombre de la columna que hemos creado

    public function imageable()
    {
        return $this->morphTo();
    }
}
