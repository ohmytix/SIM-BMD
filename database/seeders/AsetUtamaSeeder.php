<?php

namespace Database\Seeders;

use App\Models\AsetUtama;
use App\Models\KodeBarang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AsetUtamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // AsetUtama::factory(5)->create();
        $kodeBarang = KodeBarang::inRandomOrder()->first();
        $kodePotoCopy = KodeBarang::where("kode","1.3.2.05.01.03.008")->first();

        if(!$kodeBarang || !$kodePotoCopy){
            $this->command->error('Data KodeBarang tidak ditemukan. Jalankan KodeBarangSeeder dulu.');
            return;
        }
        AsetUtama::create([
            'skpd_id' => 1,
            'kode_barang_id' => $kodeBarang->id, // <-- ID dari KodeBarang
            // 'sub_sub_rincan_objek' => "Sepeda Motor",
            'spesifikasi' => "HONDA/SUPRA X ",
            'spesifikasi_lainnya' => "",
            'dokumen' => "F 3271 S",
            'cara_perolehan' => "PENGADAAN",
            'tanggal_perolehan' => "2012-12-31",
            'ukuran_barang' => "115",
            'satuan_barang' => "UNIT",
            'kondisi_barang' => "BAIK",
        ]);
        
        // 3. Buat Aset kedua menggunakan ID yang SAMA
        AsetUtama::create([
            'skpd_id' => 2,
            'kode_barang_id' => $kodeBarang->id, // <-- ID yang sama
            // 'sub_sub_rincan_objek' => "Sepeda Motor",
            'spesifikasi' => "YAMAHA SE88",
            'spesifikasi_lainnya' => "",
            'dokumen' => "F 3742 S",
            'cara_perolehan' => "PENGADAAN",
            'tanggal_perolehan' => "2018-09-12", // Format 2 digit lebih aman
            'ukuran_barang' => "",
            'satuan_barang' => "UNIT",
            'kondisi_barang' => "BAIK",
        ]);

            AsetUtama::create([
            'skpd_id' => 3,
            'kode_barang_id' => $kodePotoCopy->id,
            'spesifikasi' => "MESIN FOTOCOPY ",
            'spesifikasi_lainnya' => "DADF-AG1 ",
            'dokumen' => "CANON  ",
            'cara_perolehan' => "PEMBELIAN",
            'tanggal_perolehan' => "2021-12-06",
            'ukuran_barang' => "SEDANG",
            'satuan_barang' => "UNIT",
            'kondisi_barang' => "BAIK",
        ]);
    }
}
