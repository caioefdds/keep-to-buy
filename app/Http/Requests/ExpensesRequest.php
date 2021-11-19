<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpensesRequest extends FormRequest
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
            'value' => 'required',
            'category_id' => '',
            'status' => 'required',
            'date' => 'required',
            'type' => 'required',
            'repeat' => '',
            'repeat_times' => '',
            'repeat_type' => '',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo "Descrição" é obrigatório',
            'value.required' => 'O campo "Valor" é obrigatório',
            'status.required' => 'O campo "Status" é obrigatório',
            'date.required' => 'O campo "Data" é obrigatório',
            'type.required' => 'Escolha um tipo de receita',
        ];
    }
}
