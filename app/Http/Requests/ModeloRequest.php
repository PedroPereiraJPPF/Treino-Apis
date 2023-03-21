<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModeloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        if($this->method() == 'PATCH'){
            return [
                'nome' => 'unique:modelos',
                'numero_de_portas' => 'digits_between:1,4',
                'lugares' => 'digits_between:1,5',
                'air_bag' => 'boolean',
                'abs' => 'boolean'
            ];
        }
        if($this->method() == 'PUT'){
            return [
                'nome' => 'unique:modelos|min:3',
                'imagem' => 'required|image',
                'marca_id' => 'required',
                'numero_de_portas' => 'required|between:1,4',
                'lugares' => 'required|between:1,5',
                'air_bag' => 'required|boolean',
                'abs' => 'required|boolean'
            ];
        }
        return [
            'nome' => 'unique:modelos|min:3',
            'imagem' => 'required|image',
            'marca_id' => 'required',
            'numero_de_portas' => 'required|between:1,4',
            'lugares' => 'required|between:1,5',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'o campo :attribute é obrigatorio',
            'unique' => 'o campo :attribute deve ser unico',
            'digits_between' => ':attribute invalido'
        ];
    }
}
