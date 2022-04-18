<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'scores' => 'sometimes|required|array|min:1',
            'scores.*.value' => 'required|integer|gte:0',
            'scores.*.user_id' => 'sometimes|required|numeric|exists:users,id',
        ];
    }
}
