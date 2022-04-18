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
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['player', 'admin']),
        ];
    }

    /**
     * Indicate that the user is a player.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function player()
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
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'admin',
            ];
        });
    }
}
