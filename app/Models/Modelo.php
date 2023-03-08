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
        'imagem', 
    ];

    public function modelo()
    {
        $this->belongsTo(Marca::class);
    }

    public function carro()
    {
        $this->hasMany(Carro::class);
    }
}
