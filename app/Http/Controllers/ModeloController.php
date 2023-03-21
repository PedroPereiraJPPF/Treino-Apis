<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Modelo;
use Illuminate\Http\Request;
use App\Http\Requests\ModeloRequest;
use Exception;

class ModeloController extends Controller
{
    protected $modelo;

    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->modelo->with('marca')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModeloRequest $request)
    {
        try{
            $modelo = $this->modelo;
            $modelo->fill($request->all());
            $modelo->imagem = retornarLinkSimbolicoDaImagem($request->file('imagem'), "imagens/modelos");

            $modelo->save();

            return response()->json([$modelo], 201);
        }catch(Exception $e){
            return response()->json([$e], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca = $this->modelo->with('marca')->find($id);
        if(!$marca){
            return response()->json(["mensagem" => "modelo não encontrado"], 404);
        }

        return response()->json($marca, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modelo $modelo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modelo $modelo)
    {
        //
    }
}
