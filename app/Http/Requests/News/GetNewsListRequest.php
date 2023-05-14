<?php

namespace App\Http\Requests\News;

use App\Http\Requests\ApiRequest;

class GetNewsListRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'keyword' => 'string',
            'page' => 'numeric|min:0',
            'sources' => 'array',
            'categories' => 'array',
            'authors' => 'array',
        ];
    }
}
