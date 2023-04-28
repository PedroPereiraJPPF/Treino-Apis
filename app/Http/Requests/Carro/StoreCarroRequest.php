<?php
namespace App\Http\Requests\Carro;
use Illuminate\Foundation\Http\FormRequest;

class StoreCarroRequest extends FormRequest
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
        return [
            'modelo_id' => 'required|numeric',
            'placa' => 'required|string',
            'imagem' => 'image',
            'disponivel' => 'required|numeric',
            'km' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'o campo :attribute é obrigatorio',
            'numeric' => 'o campo :attribute deve ser um Número',
            'image' => 'o campo imagem deve ser uma imagem'
        ];
    }
}
