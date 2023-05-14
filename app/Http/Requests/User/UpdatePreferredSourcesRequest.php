<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;

class UpdatePreferredSourcesRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'sources_ids' => 'array',
            'sources_ids.*' => 'numeric|exists:sources,id',
        ];
    }
}
