<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Http\Services\MarcaService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    protected $marca;

    public function __construct(MarcaService $marca)
    {
        $this->marca = $marca;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $marca = $this->marca->mostrarTodasAsMarcas($request);
            if(!$marca){
                return response()->json(['marca nao encontrada'], 400);
            }
            return response()->json($this->marca->mostrarTodasAsMarcas($request), 200);
        }catch(QueryException $e){
            return response()->json(['msg' => $e], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarcaRequest $request)
    {
        return response()->json($this->marca->adicionarMarca($request), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try{
            $marca = $this->marca->selecionarMarcaPorID($id, $request);
            if(!$marca){
                return response()->json(['msg' => 'Marca não encontrada'], 404);
            }
            return response()->json($marca, 200);
        }catch(QueryException $e){
            return response()->json(['msg' => $e], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MarcaRequest $request, $id)
    {
        $marcaAtualizada = $this->marca->atualizarMarca($request, $id);

        if(!$marcaAtualizada){
            return response()->json(['mensagem' => 'marca não encontrada'], 404);
        }

        return response()->json($marcaAtualizada, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $marca = $this->marca->selecionarMarcaPorID($id);
        if(!$marca){
            return response()->json(['msg' => 'marca não encontrada'], 404);
        }

        $this->marca->deletarMarca($marca);
        return response()->json(['msg' => 'marca deletada com sucesso'], 200);
    }
}
