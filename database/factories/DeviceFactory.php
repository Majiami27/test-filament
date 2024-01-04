<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mac_address' => fake()->word(10),
            'name' => fake()->word(10),
            'custom_id' => fake()->word(10),
            // 'area_id' => fake()->word(10),
            'ip' => fake()->word(10),
            'ssid' => fake()->word(10),
            'status' => fake()->boolean(),
        ];
    }
}
