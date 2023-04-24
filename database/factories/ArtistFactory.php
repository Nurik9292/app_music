<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'bio_tk' => $this->faker->text(),
            'bio_ru' => $this->faker->text(),
            'artwork_url' => $this->faker->imageUrl(),
            'thumb_url' => $this->faker->imageUrl(),
            'country_id' => random_int(1, 10),
            'status' => true,

        ];
    }
}