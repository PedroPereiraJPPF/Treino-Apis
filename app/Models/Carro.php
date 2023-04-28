<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;

    protected $fillable = [
        'imagem', 'modelo_id', 'placa', 'disponivel', 'km'
    ];

    public function marca()
    {
        $this->belongsTo(Modelo::class);
    }

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'locacoes', 'carro_id', 'cliente_id');
    }
}
