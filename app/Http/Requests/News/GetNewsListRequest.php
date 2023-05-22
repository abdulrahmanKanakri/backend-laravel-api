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
            'keyword' => 'nullable|string',
            'page' => 'nullable|numeric|min:0',
            'source' => 'nullable|string',
            'category' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ];
    }
}
