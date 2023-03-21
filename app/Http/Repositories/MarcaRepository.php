<?php

namespace app\Http\Repositories;
use App\Models\Marca;

class MarcaRepository
{
    private $marca;
    
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    public function mostrarTodasAsMarcas()
    {
        return $this->marca->all();
    }

    public function selecionarMarcaPorID($marcaId)
    {
        return $this->marca->find($marcaId);
    }

    public function adicionarMarca(array $dadosDaMarca)
    {
        return $this->marca->create(
            $dadosDaMarca
        );
    }

    public function atualizarMarca(array $dadosNovosDaMarca, $marca)
    {
        $marca->update(
            $dadosNovosDaMarca
        );
        return $marca;
    }

    public function deletarMarca($id)
    {
        $this->selecionarMarcaPorID($id)->delete();
    }
}