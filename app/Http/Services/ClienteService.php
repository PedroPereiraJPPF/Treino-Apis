<?php 
namespace app\Http\Services;
use App\Http\Repositories\ClienteRepository;
use Illuminate\Support\Facades\Storage;

class ClienteService
{
     protected $cliente;

     public function __construct(ClienteRepository $cliente)
     {
        $this->cliente = $cliente;
     } 

     public function mostrarTodos($request)
     {
        return $this->cliente->mostrarTodos($request);
     }

     public function selecionarCliente($clienteId, $request = null)
     {
        $clienteSelecionado = $this->cliente->selecionarPorID($clienteId, $request);
        return $clienteSelecionado;
     }

     public function adicionar($dadosDocliente)
     {
         return $this->cliente->adicionar(
            [
               'nome' => $dadosDocliente->nome
            ]
         );
     }

     public function atualizarCliente($dadosDoCliente, $id)
     {
         $cliente = $this->cliente->selecionarPorId($id);
         if(!$cliente){
            return false;
         }
         $nome = isset($dadosDoCliente->nome) ? $dadosDoCliente->nome : $cliente->nome;
         return $this->cliente->atualizar([
            'nome' => $nome
         ], $cliente);  
     }

     public function deletarCliente($cliente)
     {
         $cliente->delete();
     }



}