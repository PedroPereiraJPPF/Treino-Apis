<?php 
namespace app\Http\Services;

use App\Http\Repositories\CarroRepository;
use Illuminate\Support\Facades\Storage;

class CarroService
{
     protected $carro;

     public function __construct(CarroRepository $carro)
     {
        $this->carro = $carro;
     } 

     public function mostrarTodosOsCarros($request)
     {
        return $this->carro->mostrarTodosOsCarros($request);
     }

     public function selecionarCarroPorID($carroId, $request = null)
     {
        $carroSelecionado = $this->carro->selecionarCarroPorID($carroId, $request);
        return $carroSelecionado;
     }

     public function adicionarCarro($dadosDoCarro)
     {
         return $this->carro->adicionarCarro(
            [
               'imagem' => retornarLinkSimbolicoDaImagem($dadosDoCarro->file('imagem'), 'imagens/carros'),
               'modelo_id' => $dadosDoCarro->modelo_id,
               'placa' => $dadosDoCarro->placa,
               'disponivel' => $dadosDoCarro->disponivel,
               'km' => $dadosDoCarro->km
            ]
         );
     }

     public function atualizarCarro($dadosDoCarro, $id)
     {
         $carro = $this->carro->selecionarCarroPorId($id);
         if(!$carro){
            return false;
         }

         $imagemUri = $carro->imagem;
         $modelo_id = isset($dadosDoCarro->modelo_id) ? $dadosDoCarro->modelo_id : $carro->modelo_id;
         $placa = isset($dadosDoCarro->placa) ? $dadosDoCarro->placa : $carro->placa;
         $disponivel = isset($dadosDoCarro->disponivel) ? $dadosDoCarro->disponivel : $carro->disponivel;
         $kmRodados = isset($dadosDoCarro->km) ? $dadosDoCarro->km : $carro->km;

         if($dadosDoCarro->file('imagem')){
            Storage::disk('public')->delete($carro->imagem);
            $imagemUri = retornarLinkSimbolicoDaImagem($dadosDoCarro->file('imagem'), 'imagens/carros');
         }

         return $this->carro->atualizarCarro([
            'imagem' => $imagemUri,
            'modelo_id' => $modelo_id,
            'placa' => $placa,
            'disponivel' => $disponivel,
            'km' => $kmRodados
         ], $carro);  
     }

     public function deletarCarro($carro)
     {
         Storage::disk('public')->delete($carro->imagem);
         $carro->delete();
     }



}