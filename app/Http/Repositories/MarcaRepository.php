<?php

namespace app\Http\Repositories;
use App\Models\Marca;

class MarcaRepository
{
    protected $marca;
    
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    public function mostrarTodasAsMarcas($request)
    {
        $marcas = $this->marca->with('modelos');
        $marcas = $this->selecionarCamposParaRetornarMarcaModelo($marcas, $request);
        return $marcas->paginate($request->porPagina);
    }

    public function selecionarMarcaPorID($marcaId, $request = null)
    {
        $marca = $this->marca->with('modelos')->where('id', $marcaId);
        $marca = $request ? $this->selecionarCamposParaRetornarMarcaModelo($marca, $request) : $marca;
        return $marca->get();
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

    public function selecionarCamposParaRetornarMarcaModelo($marca, $request)
    {
        if($request['atributos']){
            $marca = $marca->selectRaw("id,".$request['atributos']);
        }
        if($request['modelos_atributos']){
            $marca = $marca->with('modelos:'.$request['modelos_atributos'].",marca_id");
        }
        return $marca;
    }

}