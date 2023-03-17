<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarcaRequest extends FormRequest
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
                
            ];
        }
        if($this->method() == 'PUT'){
            return [
                'nome' => 'required',
                'imagem' => 'required|image'
            ];
        }
        return [
            'nome' => 'unique:marcas|min:3',
            'imagem'  => 'required|image',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'o campo :attribute é obrigatorio',
            'unique' => 'o campo :attribute deve ser unico'
        ];
    }
}
