<?php

namespace Database\Factories;

use App\Models\Atab;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtabFactory extends Factory
{
    public function definition(): array
    {
        return [
            'recipient_id' => User::factory(),
            'sender_id' => null,
            'body' => fake()->paragraph(),
            'is_anonymous' => true,
            'mood' => fake()->optional()->randomElement(['happy', 'sad', 'angry', 'frustrated', 'confused', 'grateful']),
        ];
    }
}
