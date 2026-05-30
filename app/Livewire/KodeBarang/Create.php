<?php

namespace App\Livewire\KodeBarang;

use Livewire\Component;
use App\Models\KodeBarang;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    // Properti Utama
    public $kode, $sub_sub_rincang, $sub_rincang, $rincian_objek, $objek;
    public $jenis, $kelompok, $akun, $kode_penyusutan, $usia_manfaat, $keterangan;

    // Properti Rentang Usia
    public $a0_5, $a5_10, $a10_20, $a20_25, $a25_30, $a30_40;
    public $a40_45, $a45_50, $a50_65, $a65_75, $a75;

    protected $rules = [
        'kode' => 'required|string|max:255|unique:kode_barangs,kode',
        'sub_sub_rincang' => 'required|string|max:255',
        'sub_rincang' => 'nullable|string|max:255',
        'rincian_objek' => 'nullable|string|max:255',
        'objek' => 'nullable|string|max:255',
        'jenis' => 'nullable|string|max:255',
        'kelompok' => 'nullable|string|max:255',
        'akun' => 'nullable|string|max:255',
        'kode_penyusutan' => 'nullable|string|max:255',
        'usia_manfaat' => 'nullable|numeric',
        'keterangan' => 'nullable|string',
        // Rentang Usia
        'a0_5' => 'nullable|numeric', 'a5_10' => 'nullable|numeric',
        'a10_20' => 'nullable|numeric', 'a20_25' => 'nullable|numeric',
        'a25_30' => 'nullable|numeric', 'a30_40' => 'nullable|numeric',
        'a40_45' => 'nullable|numeric', 'a45_50' => 'nullable|numeric',
        'a50_65' => 'nullable|numeric', 'a65_75' => 'nullable|numeric',
        'a75' => 'nullable|numeric',
    ];

    public function store()
    {
        $this->validate();

        // Ambil semua properti public dan simpan
        KodeBarang::create($this->all());

        session()->flash('success', 'Kode Barang berhasil ditambahkan.');
        return $this->redirect(route('KodeBarang.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.kode-barang.create');
    }
}