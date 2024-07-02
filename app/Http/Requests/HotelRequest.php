<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HotelRequest extends FormRequest
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
            'name' => ['required','regex:/^[\pL\s]+$/u','max:191', Rule::unique('hotels', 'name')->ignore($this->hotel)],
            'zip_code' => ['required', 'size:8'],
            'address' => ['required', 'string', 'min:3', 'max:255'],
            'city' => ['required', 'string', 'min:3', 'max:255'],
            'state' => ['required', 'string', 'min:2', 'max:100'],
            'website' => ['nullable', 'url', 'max:255'],
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
            'zip_code.required' => 'O campo CEP é obrigatório.',
            'zip_code.size' => 'O CEP deve ter exatamente 8 caracteres.',
            'address.required' => 'O campo endereço é obrigatório.',
            'address.string' => 'O endereço deve ser uma string.',
            'address.min' => 'O endereço deve ter pelo menos 3 caracteres.',
            'address.max' => 'O endereço não pode ter mais de 255 caracteres.',
            'city.required' => 'O campo cidade é obrigatório.',
            'city.string' => 'A cidade deve ser uma string.',
            'city.min' => 'A cidade deve ter pelo menos 3 caracteres.',
            'city.max' => 'A cidade não pode ter mais de 255 caracteres.',
            'state.required' => 'O campo estado é obrigatório.',
            'state.string' => 'O estado deve ser uma string.',
            'state.min' => 'O estado deve ter pelo menos 2 caracteres.',
            'state.max' => 'O estado não pode ter mais de 100 caracteres.',
            'website.url' => 'O campo website deve ser uma URL válida.',
            'website.max' => 'O website não pode ter mais de 255 caracteres.',
        ];
    }
}
