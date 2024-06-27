<?php

namespace Database\Factories;

use App\Models\gallery;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = gallery::class;


    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'user_id' => User::pluck('id')->random(),
            'description' => $this->faker->text,
        ];
    }
}
