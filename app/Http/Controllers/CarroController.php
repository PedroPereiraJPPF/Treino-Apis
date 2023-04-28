<?php

namespace App\Http\Controllers;

use App\Http\Services\CarroService;
use App\Http\Requests\Carro\{StoreCarroRequest, UpdateCarroRequest};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Request;

class CarroController extends Controller
{
    protected $carroService;

    public function __construct(CarroService $carroService)
    {
        $this->carroService = $carroService;    
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $carro = $this->carroService->mostrarTodosOsCarros($request);
            if(empty($carro->items())){
                return response()->json(['não tem carros registrados'], 400);
            }
            return response()->json($this->carroService->mostrarTodosOsCarros($request), 200);
        }catch(QueryException $e){
            return response()->json(['msg' => $e], 400);
        }
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarroRequest $request)
    {
        try{
            return response()->json($this->carroService->adicionarCarro($request), 200);
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
            $carro = $this->carroService->selecionarCarroPorID($id, $request);
            if(empty($carro)){
                return response()->json(['msg' => 'Carro não encontrado'], 404);
            }
            return response()->json($carro, 200);
        }catch(QueryException $e){
            return response()->json(['msg' => $e], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarroRequest $request, $id)
    {
        $carroAtualizado = $this->carroService->atualizarCarro($request, $id);

        if(empty($carroAtualizado->id)){
            return response()->json(['mensagem' => 'Carro não encontrado'], 404);
        }

        return response()->json($carroAtualizado, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $carro = $this->carroService->selecionarCarroPorID($id);
        if(empty($carro)){
            return response()->json(['msg' => 'carro não encontrado'], 404);
        }
        $this->carroService->deletarCarro($carro);
        return response()->json(['msg' => 'carro excluido com sucesso'], 200);
    }
}
