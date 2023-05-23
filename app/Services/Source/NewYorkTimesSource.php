<?php

namespace App\Services\Source;

use App\Enums\Categories;
use App\Enums\Sources;
use App\Mappers\News\NewYorkTimesNewsMapper;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewYorkTimesSource implements INewsSource
{
    public function __construct(
        private string $endpoint,
        private string $apiKey,
        private NewYorkTimesNewsMapper $mapper,
    ) {
    }

    public function fetchNewsList(array $filters): array
    {
        try {
            $params = $this->constructParams($filters);

            $response = Http::get($this->endpoint, $params);

            if ($response->ok()) {
                $data = collect($response->json()["response"]["docs"]);

                return $data->map(fn ($item) => $this->mapper->fromApi($item))->all();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return [];
        }
    }

    private function constructParams(array $filters)
    {
        $categoryFilters = [];
        if (isset($filters['category'])) {
            $categories = Categories::getSourceCategories(Sources::NEW_YORK_TIMES);
            $categoryFilters = [
                'facet_filter' => true,
                'facet_fields' => 'section_name',
                'fq'           =>  $categories[$filters['category']][0] ?? '',
            ];
        }

        return collect([
            'api-key' => $this->apiKey,
            'q'       => $filters['keyword'] ?? '',
            'page'    => $filters['page'] ?? 1,
            'sort'    => 'newest',
        ])->merge($categoryFilters)->filter()->all();
    }
}
