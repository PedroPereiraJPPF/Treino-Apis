<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    public function Modelos()
    {
        $this->hasMany(Modelo::class);
    }

    protected $fillable = ['nome', 'imagem'];
}
