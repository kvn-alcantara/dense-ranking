<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['player', 'admin']),
        ];
    }

    /**
     * Indicate that the user is a player.
     *
     * @return Factory
     */
    public function player(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'player',
            ];
        });
    }

    /**
     * Indicate that the user is a admin.
     *
     * @return Factory
     */
    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'admin',
            ];
        });
    }
}
