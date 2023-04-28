<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    public function carros()
    {
        return $this->belongsToMany(Carro::class, 'locacoes', 'cliente_id', 'carro_id');
    }
}
