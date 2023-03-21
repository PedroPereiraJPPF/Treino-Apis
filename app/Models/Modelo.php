<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'nome', 
        'marca_id',
        'imagem', 
        'numero_de_portas',
        'lugares',
        'air_bag',
        'abs'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function Carro()
    {
        return $this->hasMany(Carro::class);
    }
}
