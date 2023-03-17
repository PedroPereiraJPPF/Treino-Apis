<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    protected $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->marca->all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarcaRequest $request)
    {
        $imagem = $request->file('imagem');
        $uriImagem = $imagem->store('imagens', 'public');
        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $uriImagem
        ]);
        return response()->json($marca, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);
        if(!$marca){
            return response()->json(['msg' => 'Marca não encontrada'], 404);
        }
        return response()->json($marca, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MarcaRequest $request, $id)
    {
        $marca =  $this->marca->find($id);

        if(!$marca){
            return response()->json(['msg' => 'Marca nao encontrada'], 404);
        }

        $nome = isset($request->nome) ? $request->nome : $marca->nome;
        
        $imagem = $request->file('imagem');
        $imagemUri = isset($imagem) ? $imagem->store('imagens', 'public') : $marca->imagem;

        $marca->update([
            'nome' => $nome,
            'imagem' => $imagemUri
           ]
        );

        return response()->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        if(!$marca){
            return response()->json(['msg' => 'marca não encontrada'], 404);
        }
        $marca->delete();
        return response()->json(['msg' => 'marca deletada com sucesso'], 200);
    }
}
