<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;

class UpdatePreferredAuthorsRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'authors_ids' => 'array',
            'authors_ids.*' => 'numeric|exists:authors,id',
        ];
    }
}
