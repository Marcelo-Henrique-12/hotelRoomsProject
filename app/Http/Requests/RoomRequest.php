<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','max:191'],
            'description' => ['required', 'string', 'min:10', 'max:500'],
            'hotel_id' => ['required', 'exists:hotels,id'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.regex' => 'O nome deve conter apenas letras e espaços.',
            'name.max' => 'O nome não pode ter mais de 191 caracteres.',
            'name.unique' => 'O nome já está cadastrado.',
            'description.required' => 'O campo descrição é obrigatório.',
            'description.string' => 'O descrição deve ser uma string.',
            'description.min' => 'O descrição deve ter pelo menos 3 caracteres.',
            'description.max' => 'O descrição não pode ter mais de 255 caracteres.',
            'hotel_id.required' => 'Selecione um Hotel.',
            'hotel_id.exists' => 'O hotel selecionado não é válido.',
        ];
    }
}
