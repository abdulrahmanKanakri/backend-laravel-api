<?php

namespace Database\Seeders;

use App\Enums\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = array_values(Categories::getConstants());

        DB::table('categories')->insert(array_map(fn ($category) => ['name' => $category], $categories));
    }
}
