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
    public function index(Request $request)
    {
        $modelo = $this->modelo;
        if($request->atributos){
            $modelo = $modelo->selectRaw($request->atributos.",marca_id");
        }
        if($request->marca_atributos){
            $modelo = $modelo->with('marca:id,'.$request->marca_atributos);
        }
        return $modelo->get();
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
            return response()->json([$e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);
        if(!$modelo){
            return response()->json(["mensagem" => "modelo não encontrado"], 400);
        }

        return response()->json($modelo, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModeloRequest $request, $id)
    {
        try{
            $modelo = $this->modelo->find($id);
            if(!$modelo){
                return response()->json(["mensagem" => "modelo não encontrado"], 400); 
            }

            $modelo->fill($request->all());
            
            if($request->file('imagem')){
                Storage::disk('public')->delete($modelo->getOriginal()["imagem"]);
                $modelo->imagem = retornarLinkSimbolicoDaImagem($request->file('imagem'), 'imagens/modelos');
            }
            $modelo->save();

            return response()->json([$modelo], 200);
        }catch(Exception $e){
            return response()->json([$e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $modelo = $this->modelo->find($id);
            if(!$modelo){
                return response()->json(["modelo não encontrado"], 400);
            }
            Storage::disk('public')->delete($modelo->imagem);

            $modelo->delete();

            return response()->json(["modelo excluido com sucesso"], 200);
        }catch(Exception $e){
            return response()->json([$e], 500);
        }
    }
}
