<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;

class UpdatePreferredCategoriesRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'categories_ids' => 'required|array',
            'categories_ids.*' => 'required|numeric',
        ];
    }
}
