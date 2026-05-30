<?php

namespace App\Livewire\PbBmd;

use Livewire\Component;
use App\Models\AsetUtama;
use Livewire\Attributes\Layout;

class BeritaAcara extends Component
{
    #[Layout('layouts.app')] // Pastikan ini mengarah ke file layout utama Anda
    
    public function getNilaiAset($kode)
{
    // Diasumsikan Anda memiliki model AsetUtama yang menyimpan data dari DBP 2025
    // Kode 1.3.4 biasanya merujuk pada Jalan, Jaringan, dan Irigasi
    return \App\Models\AsetUtama::where('kode_barang', 'like', $kode . '%')
        ->sum('nilai_perolehan'); // Sesuaikan nama kolom dengan database Anda
}
public function render()
{
    // 1. Nilai Tanah (1.3.1)
        $nilaiTanah = AsetUtama::whereHas('kodeBarang', function($query) {
                $query->where('kode', 'like', '1.3.1%');
            })
            ->with('PerolehanPenambahan')
            ->get()
            ->sum(function($aset) {
                return $aset->PerolehanPenambahan->saldo_awal ?? 0;
            });

        // 2. Peralatan dan Mesin (1.3.2)
        $nilaiPeralatan = AsetUtama::whereHas('kodeBarang', function($query) {
                $query->where('kode', 'like', '1.3.2%');
            })
            ->with('PerolehanPenambahan')
            ->get()
            ->sum(function($aset) {
                return $aset->PerolehanPenambahan->saldo_awal ?? 0;
            });

        //3. Gedung dan Bangunan (1.3.3)
        $nilaiGedung = AsetUtama::whereHas('kodeBarang', function($query) {
                $query->where('kode', 'like', '1.3.3%');
            })
            ->with('PerolehanPenambahan')
            ->get()
            ->sum(function($aset) {
                return $aset->PerolehanPenambahan->saldo_awal ?? 0;
            });
    // Mengambil total Saldo Awal untuk Jalan, Jaringan dan Irigasi (Kode 1.3.4)
    $nilaiJalan = \App\Models\AsetUtama::whereHas('kodeBarang', function($query) {
            // Gunakan kolom 'kode' sesuai schema Anda
            $query->where('kode', 'like', '1.3.4%');
        })
        ->with('PerolehanPenambahan') // Eager load agar tidak N+1 query
        ->get()
        ->sum(function($aset) {
            // Mengambil saldo_awal dari tabel perolehan_penambahans via relasi
            return $aset->PerolehanPenambahan->saldo_awal ?? 0;
        });

        //5.Aset tetap lainnya (1.3.5)
        $nilaiLainnya = AsetUtama::whereHas('kodeBarang', function($query) {
                $query->where('kode', 'like', '1.3.5%');
            })
            ->with('PerolehanPenambahan')
            ->get()
            ->sum(function($aset) {
                return $aset->PerolehanPenambahan->saldo_awal ?? 0;
            });

        // 6.Konstruksi dalam pengerjaan (1.3.6)
        $nilaiKonstruksi = AsetUtama::whereHas('kodeBarang', function($query) {
                $query->where('kode', 'like', '1.3.6%');
            })
            ->with('PerolehanPenambahan')
            ->get()
            ->sum(function($aset) {
                return $aset->PerolehanPenambahan->saldo_awal ?? 0;
            });
        // 7.Kemitraan dengan pihak ketiga (1.5.2)
        $nilaiKemitraan = AsetUtama::whereHas('kodeBarang', function($query) {
                $query->where('kode', 'like', '1.5.2%');
            })
            ->with('PerolehanPenambahan')
            ->get()
            ->sum(function($aset) {
                return $aset->PerolehanPenambahan->saldo_awal ?? 0;
            });
    // 8.Aset tidak berwujud (1.5.3)
        $nilaiTakBerwujud = AsetUtama::whereHas('kodeBarang', function($query) {
                $query->where('kode', 'like', '1.5.3%');
            })
            ->with('PerolehanPenambahan')
            ->get()
            ->sum(function($aset) {
                return $aset->PerolehanPenambahan->saldo_awal ?? 0;
            });
    // 9.Aset Lain lain (1.5.4)
        $nilaiLainlain = AsetUtama::whereHas('kodeBarang', function($query) {
                $query->where('kode', 'like', '1.5.3%');
            })
            ->with('PerolehanPenambahan')
            ->get()
            ->sum(function($aset) {
                return $aset->PerolehanPenambahan->saldo_awal ?? 0;
            });

    return view('livewire.pb-bmd.berita-acara', [
        'nilaiJalan' => $nilaiJalan,
        'nilaiTanah' => $nilaiTanah,
        'nilaiPeralatan' => $nilaiPeralatan,
        'nilaiGedung' => $nilaiGedung,
        'nilaiLainnya' => $nilaiLainnya,
        'nilaiKonstruksi' => $nilaiKonstruksi,
        'nilaiKemitraan' => $nilaiKemitraan,
        'nilaiTakBerwujud' => $nilaiTakBerwujud,
        'nilaiLainlain' => $nilaiLainlain
    ]);
}



}
