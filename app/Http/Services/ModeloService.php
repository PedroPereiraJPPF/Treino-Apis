<?php

namespace App\Http\Services;

class ModeloService
{
    public function selecionarCamposParaRetornarMarcaModelo($modelo, $request)
    {
        if($request['atributos']){
            $modelo = $modelo->selectRaw($request['atributos'].",marca_id");
        }
        if($request['marca_atributos']){
            $modelo = $modelo->with('marca:id,'.$request['marca_atributos']);
        }
        return $modelo;
    }
}