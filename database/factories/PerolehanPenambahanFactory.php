<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PerolehanPenambahan>
 */
class PerolehanPenambahanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "saldo_awal" => $this->faker->numberBetween(1000000, 50000000),
            "koreksi_saldo_awal" => $this->faker->numberBetween(0, 1000000),
            "belanja" => $this->faker->numberBetween(500000, 10000000),
            "hibah" => $this->faker->numberBetween(0, 5000000),
            "mutasi" => $this->faker->numberBetween(0, 2000000),
            "reklasifikasi" => $this->faker->numberBetween(0, 1000000),
            "lainnya" => $this->faker->numberBetween(0, 500000),
        ];
    }
}
