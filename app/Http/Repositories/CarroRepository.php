<?php
namespace App\Http\Repositories;
use App\Models\Carro;

class CarroRepository
{
    protected $carro;

    public function __construct(Carro $carro)
    {
        $this->carro = $carro;
    }

    public function mostrarTodosOsCarros($request)
    {
        $carros = $this->carro->with('clientes');
        $carros = $this->selecionarCamposParaRetornarCarroCliente($carros, $request);
        return $carros->paginate(isset($request->porPagina) ? $request->porPagina : 15);
    }

    public function selecionarCarroPorID($carroId, $request = null)
    {
        $carro = $this->carro->where('id', $carroId);
        $carro = $request ? $this->selecionarCamposParaRetornarCarroCliente($carro, $request) : $carro;
        return $carro->first();
    }

    public function adicionarCarro(array $dadosDoCarro)
    {
        return $this->carro->create(
            $dadosDoCarro
        );
    }

    public function atualizarCarro(array $dadosNovosDoCarro, $carro)
    {
        $carro->update(
            $dadosNovosDoCarro
        );
        return $carro;
    }

    public function deletarCarro($id)
    {
        $this->selecionarCarroPorID($id)->delete();
    }

    public function selecionarCamposParaRetornarCarroCliente($carro, $request)
    {
        if(isset($request->atributos) && $request->atributos){
            $carro = $carro->selectRaw("id,".$request['atributos']);
        }
        if(isset($request->clientes_atributos) && $request->clientes_atributos){
            $carro = $carro->with('clientes:'.$request['clientes_atributos'].",carro_id");
        }
        return $carro;
    }
}


