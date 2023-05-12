<?php

namespace Database\Seeders;

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
        $categories = [
            'Technology',
            'Movies',
            'Health',
            'Food',
            'Music',
            'Science',
            'Books',
            'Travel',
            'Business',
            'History',
            'Sports',
            'Arts',
            'World',
        ];

        DB::table('categories')->insert(array_map(function ($c) {
            return ['name' => $c];
        }, $categories));
    }
}
