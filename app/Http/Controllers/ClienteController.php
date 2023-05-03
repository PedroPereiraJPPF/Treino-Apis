<?php

namespace App\Http\Controllers;

use App\Http\Services\ClienteService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected $clienteService;

    public function __construct(ClienteService $cliente)
    {
        $this->clienteService = $cliente;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $cliente = $this->clienteService->mostrarTodos($request);
            if(empty($cliente->items())){
                return response()->json(['não tem clientes registrados'], 400);
            }
            return response()->json($this->clienteService->mostrarTodos($request), 200);
        }catch(QueryException $e){
            return response()->json(['msg' => $e], 400);
        }
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            return response()->json($this->clienteService->adicionar($request), 200);
        }catch(QueryException $e){
            return response()->json($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try{
            $cliente = $this->clienteService->selecionarCliente($id, $request);
            if(empty($cliente)){
                return response()->json(['msg' => 'cliente não encontrado'], 404);
            }
            return response()->json($cliente, 200);
        }catch(QueryException $e){
            return response()->json(['msg' => $e], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $clienteAtualizado = $this->clienteService->atualizarCliente($request, $id);

        if(empty($clienteAtualizado->id)){
            return response()->json(['mensagem' => 'cliente não encontrado'], 404);
        }

        return response()->json($clienteAtualizado, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cliente = $this->clienteService->selecionarCliente($id);
        if(empty($cliente)){
            return response()->json(['msg' => 'cliente não encontrado'], 404);
        }
        $this->clienteService->deletarCliente($cliente);
        return response()->json(['msg' => 'cliente excluido com sucesso'], 200);
    }
}
