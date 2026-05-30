<?php

namespace App\Livewire\MutasiPersediaan;

use Livewire\Component;
use App\Models\Persediaan;
use Livewire\Attributes\Layout; // <--- Import

#[Layout('layouts.app')]
class Edit extends Component
{
    public $id_data; 
    
    // Property sama seperti Create
    public $kategori_persediaan, $nama_barang, $saldo, $realisasi, 
           $hibah_penambahan, $reklasifikasi_penambahan, 
           $pemakaian, $hibah_pengurangan, $reklasifikasi_pengurangan, $keterangan;

    public function mount($id)
    {
        // Ambil data tanpa cek SKPD session
        $data = Persediaan::findOrFail($id);

        // Isi form
        $this->id_data = $data->id;
        $this->kategori_persediaan = $data->kategori_persediaan;
        $this->nama_barang = $data->nama_barang;
        $this->saldo = $data->saldo;
        $this->realisasi = $data->realisasi;
        $this->hibah_penambahan = $data->hibah_penambahan;
        $this->reklasifikasi_penambahan = $data->reklasifikasi_penambahan;
        $this->pemakaian = $data->pemakaian;
        $this->hibah_pengurangan = $data->hibah_pengurangan;
        $this->reklasifikasi_pengurangan = $data->reklasifikasi_pengurangan;
        $this->keterangan = $data->keterangan;
    }

public function update()
    {
        // 1. Cek Session
        if (! session()->has('active_skpd_id')) {
            $this->dispatch('swal:modal', [
                'type' => 'warning', 
                'title' => 'SKPD Belum Dipilih!',
                'text'  => 'Sesi SKPD Anda telah berakhir.',
            ]);
            return;
        }

        // 2. Validasi Lengkap (Tambahkan yang kurang)
        $this->validate([
            "kategori_persediaan" => "required",
            "nama_barang" => "required",
            "keterangan" => "required",
            // Pastikan angka divalidasi
            "saldo" => "nullable|numeric",
            "realisasi" => "nullable|numeric",
            "hibah_penambahan" => "nullable|numeric",
            "reklasifikasi_penambahan" => "nullable|numeric",
            "pemakaian" => "nullable|numeric",
            "hibah_pengurangan" => "nullable|numeric",
            "reklasifikasi_pengurangan" => "nullable|numeric",
        ]);

        $data = Persediaan::find($this->id_data);
        
        $data->update([
            'kategori_persediaan' => $this->kategori_persediaan,
            'nama_barang' => $this->nama_barang,
            'saldo' => $this->saldo,
            'realisasi' => $this->realisasi,
            'hibah_penambahan' => $this->hibah_penambahan,
            'reklasifikasi_penambahan' => $this->reklasifikasi_penambahan,
            'pemakaian' => $this->pemakaian,
            'hibah_pengurangan' => $this->hibah_pengurangan,
            'reklasifikasi_pengurangan' => $this->reklasifikasi_pengurangan,
            'keterangan' => $this->keterangan,
        ]);

        session()->flash('success', 'Data Berhasil Di Update!');

        return $this->redirect(route('MutasiPersediaan.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.mutasi-persediaan.edit');
    }
}
