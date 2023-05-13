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
        $sources = array_values(Sources::getConstants());

        DB::table('sources')->insert(array_map(fn ($source) => ['name' => $source], $sources));
    }
}
