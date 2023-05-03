<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Album;
use App\Models\Artist;
use App\Models\BlockName;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Playlist;
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

        Album::factory(5)->create();
        Playlist::factory(5)->create();
        Artist::factory(10)->create();
        Genre::factory(10)->create();



        BlockName::factory()->create(['key' => 'new_and_update', 'name' => 'Новинки и обновления']);
        BlockName::factory()->create(['key' => 'recom', 'name' => 'Рекомендуем послушать']);
        BlockName::factory()->create(['key' => 'new_track', 'name' => 'Новая музыка']);
        BlockName::factory()->create(['key' => 'best_track', 'name' => 'Лучшие новые песни']);
        BlockName::factory()->create(['key' => 'chart', 'name' => 'Чарты']);
        BlockName::factory()->create(['key' => 'genre_and_category', 'name' => 'Жанры и Категориия']);
        BlockName::factory()->create(['key' => 'for_child', 'name' => 'Для детей']);
        BlockName::factory()->create(['key' => 'fun', 'name' => 'Настроение']);
    }
}