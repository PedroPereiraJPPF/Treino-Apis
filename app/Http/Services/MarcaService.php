<?php 

namespace app\Http\Services;
use App\Http\Repositories\MarcaRepository;
use App\Http\Requests\MarcaRequest;
use Illuminate\Support\Facades\Storage;

class MarcaService
{
     private $marca;

     public function __construct(MarcaRepository $marca)
     {
        $this->marca = $marca;
     } 

     public function mostrarTodasAsMarcas()
     {
        return $this->marca->mostrarTodasAsMarcas();
     }

     public function selecionarMarcaPorID($id)
     {
        $marcaSelecionada = $this->marca->selecionarMarcaPorID($id);
        return $marcaSelecionada;
     }

     public function adicionarMarca($dadosDaMarca)
     {
         return $this->marca->adicionarMarca(
            [
               'nome' => $dadosDaMarca->nome,
               'imagem' => $this->retornarLinkSimbolicoDaImagem($dadosDaMarca->file('imagem'))
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
            $imagemUri = $this->retornarLinkSimbolicoDaImagem($dadosDaMarca->file('imagem'));
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

     public function retornarLinkSimbolicoDaImagem($imagemFile)
     {
        return $imagemFile->store('imagens', 'public');
     }


}