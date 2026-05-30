<?php

namespace App\Livewire\MutasiPersediaan;

use Livewire\Component;
use App\Models\Persediaan;
use Livewire\Attributes\Layout; // <--- Import

#[Layout('layouts.app')]
class Create extends Component
{
    // Property Public
    public $kategori_persediaan;
    public $nama_barang;
    public $saldo = 0;
    public $realisasi = 0;
    public $hibah_penambahan = 0;
    public $reklasifikasi_penambahan = 0;
    public $pemakaian = 0;
    public $hibah_pengurangan = 0;
    public $reklasifikasi_pengurangan = 0;
    public $keterangan;

    // Rules Validasi
    protected $rules = [
        "kategori_persediaan" => "required|in:belanja_bahan,belanja_alat,belanja_persediaan",
        "nama_barang" => "required",
        "saldo" => "numeric",
        "realisasi" => "numeric",
        "hibah_penambahan" => "numeric",
        "reklasifikasi_penambahan" => "numeric",
        "pemakaian" => "numeric",
        "hibah_pengurangan" => "numeric",
        "reklasifikasi_pengurangan" => "numeric",
        "keterangan" => "required"
    ];

    public function store()
    {
        // 1. CEK SESSION DULU (Agar konsisten & Aman)
        if (! session()->has('active_skpd_id')) {
            $this->dispatch('swal:modal', [
                'type' => 'warning', 
                'title' => 'SKPD Belum Dipilih!',
                'text'  => 'Silakan pilih SKPD terlebih dahulu sebelum menyimpan data.',
            ]);
            return; 
        }

        $validatedData = $this->validate();

        // 2. PERBAIKAN: AMBIL DARI SESSION (JANGAN HARDCODE 1)
        $validatedData['skpd_id'] = session('active_skpd_id'); 

        Persediaan::create($validatedData);

        session()->flash('success', 'Data Persediaan Berhasil Disimpan!');

        return $this->redirect(route('MutasiPersediaan.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.mutasi-persediaan.create');
    }
}
