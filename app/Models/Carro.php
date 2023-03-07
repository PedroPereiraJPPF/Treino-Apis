<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;

    public function marca()
    {
        $this->belongsTo(Modelo::class);
    }

    public function cliente()
    {
        $this->belongsToMany(Cliente::class);
    }
}
