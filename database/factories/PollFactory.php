<?php

namespace Database\Factories;

use App\Models\Poll;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PollFactory extends Factory
{
    protected $model = Poll::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'expires_at' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'user_id' => null,
        ];
    }
}
