<?php 

namespace app\Http\Services;
use App\Http\Repositories\MarcaRepository;
use Illuminate\Support\Facades\Storage;

class MarcaService
{
     protected $marca;

     public function __construct(MarcaRepository $marca)
     {
        $this->marca = $marca;
     } 

     public function mostrarTodasAsMarcas($request)
     {
        return $this->marca->mostrarTodasAsMarcas($request);
     }

     public function selecionarMarcaPorID($MarcaId, $request = null)
     {
        $marcaSelecionada = $this->marca->selecionarMarcaPorID($MarcaId, $request);
        return $marcaSelecionada;
     }

     public function adicionarMarca($dadosDaMarca)
     {
         return $this->marca->adicionarMarca(
            [
               'nome' => $dadosDaMarca->nome,
               'imagem' => retornarLinkSimbolicoDaImagem($dadosDaMarca->file('imagem'))
            ]
         );
     }

     public function atualizarMarca($dadosDaMarca, $id)
     {
         $marca = $this->marca->selecionarMarcaPorID($id);
         if(!$marca){
            return false;
         }

         $nome = isset($dadosDaMarca->nome) ? $dadosDaMarca->nome : $marca->nome;
         $imagemUri = $marca->imagem;

         if($dadosDaMarca->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);
            $imagemUri = retornarLinkSimbolicoDaImagem($dadosDaMarca->file('imagem'));
         }

         return $this->marca->atualizarMarca([
            'nome' => $nome,
            'imagem' => $imagemUri
         ], $marca);  
     }

     public function deletarMarca($marca)
     {
         Storage::disk('public')->delete($marca->imagem);
         $marca->delete();
     }



}