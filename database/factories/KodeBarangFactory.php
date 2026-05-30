<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KodeBarang>
 */
class KodeBarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        "kode" => $this->faker->randomNumber(5),
        "sub_sub_rincang" => $this->faker->word(),
        "sub_rincang" => $this->faker->word(),
        "rincian_objek" => $this->faker->word(),
        "objek" => $this->faker->word(),
        "jenis" => $this->faker->word(),
        "kelompok" => $this->faker->word(),
        "akun" => $this->faker->word(),
        "kode_penyusutan" => $this->faker->numberBetween(1, 100),
        "usia_manfaat" => $this->faker->numberBetween(1, 50),
        "a0_5" => $this->faker->numberBetween(0, 1000),
        "a5_10" => $this->faker->numberBetween(0, 1000),
        "a10_20" => $this->faker->numberBetween(0, 1000),
        "a20_25" => $this->faker->numberBetween(0, 1000),
        "a25_30" => $this->faker->numberBetween(0, 1000),
        "a30_40" => $this->faker->numberBetween(0, 1000),
        "a40_45" => $this->faker->numberBetween(0, 1000),
        "a45_50" => $this->faker->numberBetween(0, 1000),
        "a50_65" => $this->faker->numberBetween(0, 1000),
        "a65_75" => $this->faker->numberBetween(0, 1000),
        "a75" => $this->faker->numberBetween(0, 1000),
        "keterangan" => $this->faker->sentence(),
        ];
    }
}
