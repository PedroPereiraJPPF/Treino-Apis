<?php

namespace app\Http\Repositories;
use app\Models\Marca;
use Exception;

class MarcaRepository
{
    private $marca;
    
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    public function mostrarMarcas()
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

    public function atualizarMarca(array $dadosDaMarca, $id)
    {
        $marca = $this->selecionarMarcaPorID($id);

        return $marca->update(
            $dadosDaMarca
        );
    }

    public function deletarMarca($id)
    {
        $this->selecionarMarcaPorID($id)->delete();
    }
}