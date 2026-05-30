<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\HasSkpd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsetUtama extends Model
{
    use HasFactory;
    use HasSkpd;
    protected $guarded = ["id"];

    public function PerolehanPenambahan(): HasOne
    {
        return $this->hasOne(PerolehanPenambahan::class);
    }

    public function PerolehanPengurangan(): HasOne
    {
        return $this->hasOne(PerolehanPengurangan::class);
    }

    public function PenyusutanPenambahan(): HasOne
    {
        return $this->hasOne(PenyusutanPenambahan::class);
    }

    public function PenyusutanPengurangan(): HasOne
    {
        return $this->hasOne(PenyusutanPengurangan::class);
    }

    public function kodeBarang(): BelongsTo
    {
        return $this->belongsTo(KodeBarang::class);
    }

        private function getTglLaporanConfig() {
        return Carbon::parse(config('laporan.tgl_sekarang', '2025-06-30')); 
    }

    private function getTglLaluConfig() {
        return Carbon::parse(config('laporan.tgl_lalu', '2024-12-31'));
    }

    public function Mutasi()
    {
        return $this->hasOne(HitungPenyusutanMutasi::class, 'aset_utama_id');
    }

    public function getTotalPerolehanPenambahanAttribute(): int
    {
        if(! $this->PerolehanPenambahan){
            return 0;
        }
        return $this->PerolehanPenambahan->koreksi_saldo_awal +
               $this->PerolehanPenambahan->belanja +
               $this->PerolehanPenambahan->hibah +
               $this->PerolehanPenambahan->mutasi +
               $this->PerolehanPenambahan->reklasifikasi +
               $this->PerolehanPenambahan->lainnya;
    }


    public function getTotalPerolehanPenguranganAttribute(): int 
    {
        if(! $this->PerolehanPengurangan)
        {
            return 0;
        }
        return $this->PerolehanPengurangan->koreksi_saldo_awal +
               $this->PerolehanPengurangan->hibah +
               $this->PerolehanPengurangan->mutasi +
               $this->PerolehanPengurangan->reklasifikasi +
               $this->PerolehanPengurangan->penghapusan +
               $this->PerolehanPengurangan->lainnya;
    }
    public function getBarangLamaAttribute(): int
    {
        $tglPerolehan = Carbon::parse($this->tanggal_perolehan); 
        $tglLaporan = $this->getTglLaporanConfig();
        $bulanLaporan = $tglLaporan->month;
        if ($tglPerolehan->year == $tglLaporan->year) {
            return 0;
        }
        $umurEkonomis = $this->umur_ekonomis_bulan; 
        if ($umurEkonomis == 0) {
            return 0;
        }
        $sisaUmur2024 = $this->sisa_umur; 
        if ($sisaUmur2024 <= 0) {
            return 0;
        }
        if ($sisaUmur2024 <= $bulanLaporan) {
            if (! $this->PenyusutanPenambahan) {
                return 0; 
            }
            $saldoAwalPenyusutan = $this->PenyusutanPenambahan->saldo_awal ?? 0; 
            $koreksiSaldoPenyusutan = $this->PenyusutanPenambahan->koreksi_saldo_awal ?? 0;
            $hasil = -($saldoAwalPenyusutan + $koreksiSaldoPenyusutan);
            return (int)$hasil;
        } else {
            $nilaiPenyusutanPerBulan = $this->nilai_penyusutan_per_bulan;
            return $nilaiPenyusutanPerBulan * $bulanLaporan; 
        }
    }
    public function getBelanjaAttribute(): int
    {
        $tglPerolehan = Carbon::parse($this->tanggal_perolehan);
        $tglLaporan = $this->getTglLaporanConfig();
        if ($tglPerolehan->year != $tglLaporan->year) {
            return 0;
        }
        $umurBarang2025 = $this->umur_barang_2025; 
        
        $nilaiPenyusutanPerBulan = $this->nilai_penyusutan_per_bulan;
        return (int)($umurBarang2025 * $nilaiPenyusutanPerBulan);
    }
    public function getTotalPenyusutanPenambahanAttribute(): int 
    {
        $nilaiInduk = ($this->barang_lama ?? 0) + ($this->belanja ?? 0);

        if (! $this->PenyusutanPenambahan) {
            return $nilaiInduk;
        }
        return $this->PenyusutanPenambahan->koreksi_saldo_awal +
               $nilaiInduk +
               $this->PenyusutanPenambahan->hibah +
               $this->PenyusutanPenambahan->mutasi +
               $this->PenyusutanPenambahan->reklasifikasi +
               $this->PenyusutanPenambahan->lainnya;
    }
    public function getTotalPenyusutanPenguranganAttribute(): int 
    {
        if(! $this->PenyusutanPengurangan)
        {
            return 0;
        }
        return $this->PenyusutanPengurangan->koreksi_saldo_awal +
               $this->PenyusutanPengurangan->hibah +
               $this->PenyusutanPengurangan->mutasi +
               $this->PenyusutanPengurangan->reklasifikasi +
               $this->PenyusutanPengurangan->penghapusan +
               $this->PenyusutanPengurangan->lainnya;
    }
    public function getHargaPerolehanAkhirAttribute(): int
    {
        $saldoAwal = optional($this->PerolehanPenambahan)->saldo_awal ?? 0;
        $totalPenambahan = $this->total_perolehan_penambahan;
        $totalPengurangan = $this->total_perolehan_pengurangan;
        return $saldoAwal + $totalPenambahan - $totalPengurangan;
    }
    public function getUmurEkonomisBulanAttribute(): int 
    {
        if (! $this->kodeBarang || ! $this->kodeBarang->usia_manfaat)
        {
            return 0;
        }
        return $this->kodeBarang->usia_manfaat * 12;
    }
    public function getUmurBarang2024Attribute(): int
    {
        $tglLalu = $this->getTglLaluConfig();
        $tglPerolehan = Carbon::parse($this->tanggal_perolehan);
        if ($tglPerolehan->greaterThan($tglLalu)) {
            return 0;
        }
        return $tglPerolehan->diffInMonths($tglLalu) + 1;
    }
    public function getUmurBarang2025Attribute(): int 
    {
        $tglLaporan = $this->getTglLaporanConfig();
        $tglPerolehan = Carbon::parse($this->tanggal_perolehan);
        if ($tglPerolehan->greaterThan($tglLaporan)) return 0;
        return $tglPerolehan->diffInMonths($tglLaporan) + 1;
    }
    public function getSisaUmurAttribute(): int 
    {
        if ($this->umur_ekonomis_bulan == 0) return 0;
        return $this->umur_ekonomis_bulan - $this->umur_barang_2024;
    }

    public function getNilaiPenyusutanPerBulanAttribute(): int
    {
        $hargaPerolehan = $this->harga_perolehan_akhir;
        $umurEkonomis = $this->umur_ekonomis_bulan;
        if ($umurEkonomis == 0 || $hargaPerolehan == 0) return 0;
        $nilai = round($hargaPerolehan / $umurEkonomis, 0);
        return (int)$nilai * -1; // Dibuat negatif seperti di sheet
    }

    public function getAkumulasiPenyusutanAkhirAttribute(): int 
    {
        $saldoAwal = optional($this->PenyusutanPenambahan)->saldo_awal ?? 0;
        $totalPenyusutanPenambahan = $this->total_penyusutan_penambahan;
        $totalPenyusutanPengurangan = $this->total_penyusutan_pengurangan;
        return $saldoAwal + $totalPenyusutanPenambahan - $totalPenyusutanPengurangan;
    }

    public function getHargaBarangAttribute(): int
    {
        $saldoAwal = $this->PerolehanPenambahan->saldo_awal ?? 0;
        $totalPenambahan = $this->total_perolehan_penambahan ?? 0;
        return $saldoAwal + $totalPenambahan;
    }
    public function getNilaiBukuAttribute(): int 
    {
        $hargaPerolehan = $this->HargaPerolehanAkhir ?? 0;
        $akumulasiPenyusutan = $this->AkumulasiPenyusutanAkhir ?? 0;
        return $hargaPerolehan + $akumulasiPenyusutan;
    }
    public function getUmurSdMutasiAttribute(): ?int // Mengizinkan hasil null
    {
        // Pengecekan 1: IF(BF39="",""...)
        // Cek jika relasi 'Mutasi' ada DAN 'tanggal_mutasi' tidak kosong.
        if (! $this->Mutasi || ! $this->Mutasi->tanggal_mutasi) {
            return null; // Mengembalikan null (atau 0) jika tidak ada tanggal mutasi
        }
        $tglPerolehan = Carbon::parse($this->tanggal_perolehan);
        $tglMutasi = Carbon::parse($this->Mutasi->tanggal_mutasi);

        // Pengecekan keamanan jika tanggal mutasi sebelum tanggal perolehan
        if ($tglPerolehan->greaterThan($tglMutasi)) {
            return 0;
        }
        return $tglPerolehan->diffInMonths($tglMutasi) + 1;
    }


    public function getBebanMutasiAttribute(): int
    {
        // Kita cek dari hasil "Umur S.D Mutasi". 
        // Jika hasilnya null/0, berarti tidak ada tanggal mutasi.
        $umurSdMutasi = $this->umur_sd_mutasi;
        
        if (empty($umurSdMutasi)) {
            return 0;
        }
        $umur2024 = $this->umur_barang_2024;
        $penyusutanPerBulan = $this->nilai_penyusutan_per_bulan; // (Sudah negatif)

        // (Umur s/d Mutasi - Umur s/d 2024)
        $bulanBerjalan2025 = $umurSdMutasi - $umur2024;

        // (Bulan di 2025) * (Biaya Penyusutan Bulanan)
        return (int)($bulanBerjalan2025 * $penyusutanPerBulan);
    }


    public function getAkmMutasiAttribute(): int
    {
        $umurSdMutasi = $this->umur_sd_mutasi; 
        // Jika tidak ada tanggal mutasi, $umurSdMutasi akan null/0
        if (empty($umurSdMutasi)) {
            return 0;
        }
        $umurEkonomis = $this->umur_ekonomis_bulan;
        if ($umurSdMutasi >= $umurEkonomis) {
            /**
             * Skenario A: Aset Sudah Lunas (Fully Depreciated)
             * Rumus Sheet: -R39
             */

            // (R39: Saldo Awal Akumulasi Penyusutan)
            $saldoAwalPenyusutan = $this->PenyusutanPenambahan->saldo_awal ?? 0;
            
            return (int)($saldoAwalPenyusutan * -1);

        } else {
            /**
             * Skenario B: Aset Belum Lunas
             * Rumus Sheet: BG39*AM39
             */
             
            // (AM39: Nilai Penyusutan Per Bulan)
            $penyusutanPerBulan = $this->nilai_penyusutan_per_bulan; // (Nilai ini sudah negatif)

            return (int)($umurSdMutasi * $penyusutanPerBulan);
        }
    }


}
