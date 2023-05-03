<?php
namespace App\Http\Repositories;
use App\Models\Cliente;

class clienteRepository
{
    protected $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    public function mostrarTodos($request)
    {
        $cliente = $this->cliente->with('carros');
        $cliente = $this->selecionarCamposParaRetornarClienteCarro($cliente, $request);
        return $cliente->paginate(isset($request->porPagina) ? $request->porPagina : 15);
    }

    public function selecionarPorID($clienteId, $request = null)
    {
        $cliente = $this->cliente->where('id', $clienteId);
        $cliente = $request ? $this->selecionarCamposParaRetornarClienteCarro($cliente, $request) : $cliente;
        return $cliente->first();
    }

    public function adicionar(array $dadosDoCliente)
    {
        return $this->cliente->create(
            $dadosDoCliente
        );
    }

    public function atualizar(array $dadosNovosDocliente, $cliente)
    {
        $cliente->update(
            $dadosNovosDocliente
        );
        return $cliente;
    }

    public function deletar($id)
    {
        $this->selecionarPorID($id)->delete();
    }

    public function selecionarCamposParaRetornarClienteCarro($cliente, $request)
    {
        if(isset($request->atributos) && $request->atributos){
            $cliente = $cliente->selectRaw("id,".$request['atributos']);
        }
        if(isset($request->clientes_atributos) && $request->clientes_atributos){
            $cliente = $cliente->with('carros:'.$request['carros_atributos'].",cliente_id");
        }
        return $cliente;
    }
}


