<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Modelo;
use Illuminate\Http\Request;
use App\Http\Requests\ModeloRequest;
use App\Http\Services\ModeloService;
use Exception;
use Illuminate\Database\QueryException;

class ModeloController extends Controller
{
    protected $modelo;
    protected $modeloService;

    public function __construct(Modelo $modelo, ModeloService $modeloService)
    {
        $this->modelo = $modelo;
        $this->modeloService = $modeloService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $modelo = $this->modelo->with('marca');
            $modelo = $this->modeloService->selecionarCamposParaRetornarMarcaModelo($modelo, $request);
            return response()->json([$modelo->paginate($request->porPagina)], 200);
        }catch(QueryException $e){
            return response()->json(['msg' => $e->getMessage()], 400);
        }
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
    public function show(Request $request, $id) 
    {
        $modelo = $this->modelo->with('marca')->where('id', $id);
        if(!$modelo){
            return response()->json(["mensagem" => "modelo não encontrado"], 400);
        }

        $modelo = $this->modeloService->selecionarCamposParaRetornarMarcaModelo($modelo, $request);

        return response()->json($modelo->get(), 200);
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
