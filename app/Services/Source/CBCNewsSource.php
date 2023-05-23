<?php

namespace App\Services\Source;

use App\Enums\Categories;
use App\Enums\Sources;
use App\Mappers\News\CBCNewsMapper;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CBCNewsSource implements INewsSource
{
    public function __construct(
        private string $endpoint,
        private string $apiKey,
        private CBCNewsMapper $mapper,
    ) {
    }

    public function fetchNewsList(array $filters): array
    {
        try {
            $params = $this->constructParams($filters);

            $response = Http::get($this->endpoint, $params);

            if ($response->ok()) {
                $data = collect($response->json()["articles"]);

                return $data->map(fn ($item) => $this->mapper->fromApi($item))->all();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return [];
        }
    }

    private function constructParams(array $filters)
    {
        if (isset($filters['category'])) {
            $categories = Categories::getSourceCategories(Sources::CBC_NEWS);
            $filters['category'] = $categories[$filters['category']][0] ?? '';
        }

        return collect([
            'apiKey'   => $this->apiKey,
            'q'        => $filters['keyword'] ?? '',
            'page'     => $filters['page'] ??  1,
            'pageSize' => 5,
            'sources'  => 'cbc-news'
        ])->filter()->all();
    }
}
