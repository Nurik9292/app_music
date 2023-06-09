<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Album;
use App\Models\Artist;
use App\Models\BlockName;
use App\Models\Country;
use App\Models\File;
use App\Models\Genre;
use App\Models\Playlist;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (count(Country::all()) == 0) {
            $json = file_get_contents(__DIR__ . "/../../countries.json");
            $countries = json_decode($json)->name;

            foreach ($countries as $code => $name)
                Country::factory()->create([
                    'name' => $name,
                    'code' => $code
                ]);
        }

        if (count(User::where('email', 'like', 'super@example.com')->get()) == false)
            User::factory()->create([
                'name' => 'Super',
                'email' => 'super@example.com',
                'password' => 'super123!',
                'role' => 1,
            ]);

        if (count(User::where('email', 'like', 'admin@example.com')->get()) == false)
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => 'admin123!',
                'role' => 2,
            ]);

        if (count((Album::all())) == 0)
            Album::factory(5)->create();
        if (count((Artist::all())) == 0)
            Artist::factory(10)->create();
        if (count((Genre::all())) == 0)
            Genre::factory(10)->create();
        if (count((Playlist::all())) == 0)
            Playlist::factory(5)->create();


        File::truncate();

        File::factory()->create([
            'path' => null,
            'scanTime' => 0,
            'local' => 'tm'
        ]);


        File::factory()->create([
            'path' => null,
            'scanTime' => 0,
            'local' => 'ru'
        ]);


        File::factory()->create([
            'path' => null,
            'scanTime' => 0,
            'local' => 'en'
        ]);
    }
}