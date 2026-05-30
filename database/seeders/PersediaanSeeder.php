<?php

namespace Database\Seeders;

use App\Models\Skpd;
use App\Models\Persediaan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PersediaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        // 1. Ambil salah satu ID SKPD yang sudah ada (untuk menghindari error foreign key)
        // Jika tabel SKPD kosong, kita paksa ID 1 (pastikan Anda menjalankan SkpdSeeder dulu)
        $skpd = Skpd::first();
        $skpdId = $skpd ? $skpd->id : 1; 

        // 2. Data Dummy Manual (Contoh Realistis)
        $dataPersediaan = [
            [
                'skpd_id' => $skpdId,
                'kategori_persediaan' => 'belanja_bahan',
                'nama_barang' => 'Kertas HVS A4 70gr (Sidu)',
                'saldo' => 5000000,
                'realisasi' => 2000000,
                'hibah_penambahan' => 0,
                'reklasifikasi_penambahan' => 0,
                'pemakaian' => 1500000,
                'hibah_pengurangan' => 0,
                'reklasifikasi_pengurangan' => 0,
                'keterangan' => 'Pengadaan ATK Triwulan I',
            ],
            [
                'skpd_id' => $skpdId,
                'kategori_persediaan' => 'belanja_alat',
                'nama_barang' => 'Toner Printer HP Laserjet 85A',
                'saldo' => 12000000,
                'realisasi' => 0,
                'hibah_penambahan' => 5000000, // Contoh ada hibah masuk
                'reklasifikasi_penambahan' => 0,
                'pemakaian' => 2500000,
                'hibah_pengurangan' => 0,
                'reklasifikasi_pengurangan' => 0,
                'keterangan' => 'Stok Gudang Utama',
            ],
            [
                'skpd_id' => $skpdId,
                'kategori_persediaan' => 'belanja_persediaan',
                'nama_barang' => 'Materai 10.000',
                'saldo' => 3000000,
                'realisasi' => 1000000,
                'hibah_penambahan' => 0,
                'reklasifikasi_penambahan' => 0,
                'pemakaian' => 500000,
                'hibah_pengurangan' => 0,
                'reklasifikasi_pengurangan' => 0,
                'keterangan' => 'Persediaan Benda Pos',
            ],
            [
                'skpd_id' => $skpdId,
                'kategori_persediaan' => 'belanja_bahan',
                'nama_barang' => 'Isi Staples Besar (No. 3)',
                'saldo' => 150000,
                'realisasi' => 50000,
                'hibah_penambahan' => 0,
                'reklasifikasi_penambahan' => 0,
                'pemakaian' => 25000,
                'hibah_pengurangan' => 0,
                'reklasifikasi_pengurangan' => 0,
                'keterangan' => 'Sisa Stok Tahun Lalu',
            ],
            [
                'skpd_id' => $skpdId,
                'kategori_persediaan' => 'belanja_bahan',
                'nama_barang' => 'Map Kertas Batik',
                'saldo' => 750000,
                'realisasi' => 250000,
                'hibah_penambahan' => 0,
                'reklasifikasi_penambahan' => 0,
                'pemakaian' => 100000,
                'hibah_pengurangan' => 0,
                'reklasifikasi_pengurangan' => 0,
                'keterangan' => 'Keperluan Rapat',
            ],
        ];

        // 3. Masukkan ke Database
        foreach ($dataPersediaan as $item) {
            Persediaan::create($item);
        }
    }
}
