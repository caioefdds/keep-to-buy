<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'image' => '',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo "Nome Completo" é obrigatório',
            'birth_date.required' => 'O campo "Data de nascimento" é obrigatório',
            'gender.required' => 'O campo "Gênero" é obrigatório',
        ];
    }
}
