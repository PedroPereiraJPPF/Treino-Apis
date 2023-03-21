<?php 

if(!function_exists('retornarLinkSimbolicoDaImagem')){
    function retornarLinkSimbolicoDaImagem($imagemFile, $diretorio = "imagens")
    {
        if($imagemFile){
            return $imagemFile->store($diretorio, 'public');
        }
        return false;
    }
}