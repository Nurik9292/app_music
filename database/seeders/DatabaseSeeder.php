<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Artist;
use App\Models\Country;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $json = file_get_contents(__DIR__ . "/../../countries.json");
        $countries = json_decode($json)->name;

        foreach ($countries as $code => $name)
            Country::factory()->create([
                'name' => $name,
                'code' => $code
            ]);

        Artist::factory(10)->create();
        Genre::factory(10)->create();
    }
}