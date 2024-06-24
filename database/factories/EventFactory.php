<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'user_id' => User::pluck('id')->random(), // Mengambil ID user yang sudah ada
            'date_start' => $this->faker->dateTime,
            'date_end' => $this->faker->dateTime,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'description' => $this->faker->text(255), // Membatasi panjang description
        ];
    }
}