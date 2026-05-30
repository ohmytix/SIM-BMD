<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persediaan>
 */
class PersediaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "kategori_persediaan" => $this->faker->randomElement(["belanja_bahan", "belanja_alat","belanja_persediaan"]),
            "nama_barang" => $this->faker->word(),
            "saldo" => $this->faker->randomNumber(),
            "realisasi" => $this->faker->randomNumber(),
            "hibah_penambahan" => $this->faker->randomNumber(),
            "reklasifikasi_penambahan" => $this->faker->randomNumber(),
            "pemakaian" => $this->faker->randomNumber(),
            "hibah_pengurangan" => $this->faker->randomNumber(),
            "reklasifikasi_pengurangan" => $this->faker->randomNumber(),
            "keterangan" => $this->faker->word()
        ];
    }
}
