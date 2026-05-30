<?php

namespace App\Livewire\KodeBarang;

use Livewire\Component;
use App\Models\KodeBarang;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule;
#[Layout('layouts.app')]
class Edit extends Component
{
    public $id_data;

    // Properti sama seperti Create
    public $kode, $sub_sub_rincang, $sub_rincang, $rincian_objek, $objek;
    public $jenis, $kelompok, $akun, $kode_penyusutan, $usia_manfaat, $keterangan;
    public $a0_5, $a5_10, $a10_20, $a20_25, $a25_30, $a30_40;
    public $a40_45, $a45_50, $a50_65, $a65_75, $a75;

    public function mount($id)
    {
        $data = KodeBarang::findOrFail($id);
        $this->id_data = $data->id;
        $this->fill($data->toArray()); // Mengisi semua properti otomatis
    }

    public function update()
    {
        // 1. Pengaman: Pastikan ID Data terbaca
        if (!$this->id_data) {
            $this->dispatch('swal:modal', [
                'type' => 'error', 
                'title' => 'Error', 
                'text' => 'ID Data tidak ditemukan. Silakan refresh halaman.'
            ]);
            return;
        }

        // 2. Validasi (Gunakan Format String ini)
        // Rumusnya: unique:nama_tabel,nama_kolom,id_yang_diabaikan
        $validatedData = $this->validate([
            'kode' => 'required|string|max:255|unique:kode_barangs,kode,' . $this->id_data,
            
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
            
            // Kolom Angka (Rentang Usia) wajib didaftarkan agar ikut tersimpan
            'a0_5' => 'nullable|numeric', 
            'a5_10' => 'nullable|numeric',
            'a10_20' => 'nullable|numeric', 
            'a20_25' => 'nullable|numeric',
            'a25_30' => 'nullable|numeric', 
            'a30_40' => 'nullable|numeric',
            'a40_45' => 'nullable|numeric', 
            'a45_50' => 'nullable|numeric',
            'a50_65' => 'nullable|numeric', 
            'a65_75' => 'nullable|numeric',
            'a75' => 'nullable|numeric',
        ]);

        // 3. Update Data
        $data = KodeBarang::find($this->id_data);
        
        $data->update($validatedData);

        session()->flash('success', 'Kode Barang berhasil diperbarui.');
        return $this->redirect(route('KodeBarang.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.kode-barang.edit');
    }
}