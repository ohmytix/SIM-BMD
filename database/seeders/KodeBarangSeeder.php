<?php

namespace Database\Seeders;

use App\Models\KodeBarang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KodeBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // KodeBarang::factory(5)->create();
        DB::table('kode_barangs')->insert([
            'kode' => "1.3.2.02.01.04.001",
            'sub_sub_rincang' => "Sepeda Motor",
            'sub_rincang' => "ENDARAAN BERMOTOR BERODA DUA",
            'rincian_objek' => "ALAT ANGKUTAN DARAT BERMOTOR",
            'objek' => "ALAT ANGKUTAN",
            'jenis' => "PERALATAN DAN MESIN",
            'kelompok' => "ASET TETAP",
            'akun' => "ASET",
            'kode_penyusutan' => "1.3.7.01.02.01.004",
            'usia_manfaat' => 7,
            'a0_5' => 1,
            'a5_10' => 1,
            'a10_20' => 1,
            'a20_25' => 1,
            'a25_30' => 2,
            'a30_40' => 2,
            'a40_45' => 2,
            'a45_50' => 2,
            'a50_65' => 3,
            'a65_75' => 3,
            'a75' => 3,
            'keterangan' => "keterangan",
        ]);
        KodeBarang::create([
            'kode' => "1.3.2.05.01.03.008",
            'sub_sub_rincang' => "Mesin Fotocopy Double Folio",
            'sub_rincang' => "ALAT REPRODUKSI (PENGGANDAAN)",
            'rincian_objek' => "ALAT KANTOR",
            'objek' => "ALAT KANTOR DAN RUMAH TANGGA",
            'jenis' => "PERALATAN DAN MESIN",
            'kelompok' => "ASET TETAP",
            'akun' => "ASET",
            'kode_penyusutan' => "1.3.7.01.05.01.003",
            'usia_manfaat' => 5,
            // 'a0_5' => ,
            // 'a5_10' => 1,
            // 'a10_20' => 1,
            // 'a20_25' => 1,
            'a25_30' => 1,
            'a30_40' => 1,
            'a40_45' => 1,
            'a45_50' => 1,
            'a50_65' => 2,
            'a65_75' => 2,
            'a75' => 3,
            'keterangan' => "keterangan",
        ]);
    }
}
