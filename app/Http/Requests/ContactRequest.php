<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|min:3',
            'cpf'   => ['required', 'max:14', Rule::unique('contacts', 'email')->ignore($this->contact)],
            'email' => 'required|email',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email'    => 'Formato inválido!',
            'required' => ':attribute é um campo obrigatório!',
            'unique'   => 'Já existe um registro para esse :attribute.',
            'min'      => ':attribute deve conter pelo menos :min caracteres.',
            'max'      => ':attribute deve conter no máximo :max caracteres.'
        ];
    }

    /**
     * @return array|string[]
     */
    public function attributes(): array
    {
        return [
            'name'  => 'Nome',
            'email' => 'E-mail',
            'cpf'   => 'CPF'
        ];
    }
}
