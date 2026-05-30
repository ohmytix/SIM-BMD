<?php

namespace Database\Factories;

use App\Models\KodeBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AsetUtama>
 */
class AsetUtamaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kodeBarang = KodeBarang::inRandomOrder()->first();
        return [
            'kode_barang_id' => $kodeBarang->id,
            "sub_sub_rincan_objek" => $this->faker->sentence(3), // Kalimat pendek
            "spesifikasi" => $this->faker->sentence(6), // Kalimat yang lebih panjang
            "spesifikasi_lainnya" => $this->faker->sentence(4),
            "dokumen" => $this->faker->word() . '.pdf', // Contoh nama file
            "cara_perolehan" => $this->faker->randomElement(['Pembelian', 'Hibah', 'Sewa', 'Lainnya']),
            "tanggal_perolehan" => $this->faker->date(),
            "ukuran_barang" => $this->faker->randomNumber(2) . 'x' . $this->faker->randomNumber(2) . ' M',
            "satuan_barang" => $this->faker->randomElement(['Unit', 'Buah', 'Meter', 'Set']),
            "kondisi_barang" => $this->faker->randomElement(['Baik', 'Rusak Ringan', 'Rusak Berat']),
        ];
    }
}
