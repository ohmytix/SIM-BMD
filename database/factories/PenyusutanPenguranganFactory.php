<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PenyusutanPengurangan>
 */
class PenyusutanPenguranganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "koreksi_saldo_awal" => $this->faker->numberBetween(0, 1000000),
            "hibah" => $this->faker->numberBetween(0, 5000000),
            "mutasi" => $this->faker->numberBetween(0, 2000000),
            "reklasifikasi" => $this->faker->numberBetween(0, 1000000),
            "penghapusan" => $this->faker->numberBetween(100000, 5000000),
            "lainnya" => $this->faker->numberBetween(0, 500000),
        ];
    }
}
