<?php

namespace Database\Seeders;

use App\Enums\Sources;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sources')->insert([
            ['name' => Sources::BBC_NEWS],
            ['name' => Sources::NEW_YORK_TIMES],
            ['name' => Sources::THE_GUARDIAN],
        ]);
    }
}
