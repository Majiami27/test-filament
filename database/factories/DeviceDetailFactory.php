<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeviceDetail>
 */
class DeviceDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mac_address' => fake()->macAddress(),
            'port' => fake()->numberBetween(1, 8),
            'port_name' => fake()->word(10),
            'status' => fake()->boolean(),
        ];
    }
}
