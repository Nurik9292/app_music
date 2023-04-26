<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'release_date' => Carbon::now(),
            'added_date' => Carbon::now(),
            'status' => true,
            'is_national' => true,
            'description' => $this->faker->text(),
            'type' => 'album',

        ];
    }
}