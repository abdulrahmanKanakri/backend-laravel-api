<?php

namespace App\Services\Source;

use App\Enums\Categories;
use App\Enums\Sources;
use App\Mappers\News\TheGuardianNewsMapper;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TheGuardianSource implements INewsSource
{
    public function __construct(
        private string $endpoint,
        private string $apiKey,
        private TheGuardianNewsMapper $mapper,
    ) {
    }

    public function fetchNewsList(array $filters): array
    {
        try {
            $params = $this->constructParams($filters);

            $response = Http::get($this->endpoint, $params);

            if ($response->ok()) {
                $data = collect($response->json()["response"]["results"]);

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
            $categories = Categories::getSourceCategories(Sources::THE_GUARDIAN);
            $filters['category'] = $categories[$filters['category']][0] ?? '';
        }

        return collect([
            'api-key'     => $this->apiKey,
            'q'           => $filters['keyword'] ?? '',
            'section'     => $filters['category'] ?? '',
            'page'        => $filters['page'] ?? 1,
            'show-fields' => 'byline,trailText,thumbnail',
        ])->filter()->all();
    }
}
