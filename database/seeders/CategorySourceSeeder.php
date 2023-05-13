<?php

namespace Database\Seeders;

use App\Enums\Categories;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = Source::all()->pluck('id', 'name')->toArray();
        $categories = Category::all()->pluck('id', 'name')->toArray();

        $sourcesCategories = $this->getSourcesCategoriesMapping($sources, $categories);

        DB::table('category_source')->insert($sourcesCategories);
    }

    private function getSourcesCategoriesMapping(array $sources, array $categories)
    {
        $sourcesCategories = [];

        foreach ($sources as $sourceName => $sourceId) {
            $sourceCategories = Categories::getSourceCategories($sourceName);
            foreach ($sourceCategories as $categoryName => $categoriesList) {
                foreach ($categoriesList as $categoryItem) {
                    array_push($sourcesCategories, [
                        'name' => $categoryItem,
                        'category_id' => $categories[$categoryName],
                        'source_id' => $sourceId
                    ]);
                }
            }
        }

        return $sourcesCategories;
    }
}
