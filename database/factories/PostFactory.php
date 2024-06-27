<?php

namespace Database\Factories;

use App\Models\categories;
use App\Models\post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\factory>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = post::class;

    public function definition(): array
    {

        return [
            'category_id' => categories::pluck('id')->random(),
            'user_id' => User::pluck('id')->random(),
            'title'=> $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'status' => rand(1, 3)
        ];
    }
}
