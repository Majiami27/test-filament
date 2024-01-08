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
            'mac_address' => fake()->macAddress(),
            'name' => fake()->word(10),
            'custom_id' => fake()->word(10),
            // 'area_id' => fake()->word(10),
            'ip' => fake()->localIpv4(),
            'ssid' => fake()->word(10),
            'status' => fake()->boolean(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Device $device) {
            $device->details()->saveMany(
                \App\Models\DeviceDetail::factory(8)
                    ->state([
                        'mac_address' => $device->mac_address,
                    ])
                    ->sequence(
                        fn ($sequence) => [
                            'port' => $sequence->index + 1,
                            'port_name' => 'Port '.($sequence->index + 1),
                        ]
                    )
                    ->make()
            );
        });
    }
}
