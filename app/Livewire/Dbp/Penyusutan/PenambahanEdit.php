<?php

namespace App\Livewire\Dbp\Penyusutan;

use Livewire\Component;
use App\Models\PenyusutanPenambahan;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PenambahanEdit extends Component
{
    public $id_data; // ID dari tabel penyusutan_penambahans
    
    // Properti Form
    public $saldo_awal;
    public $koreksi_saldo_awal;
    public $hibah;
    public $mutasi;
    public $reklasifikasi;
    public $lainnya;

    public function mount($id)
    {
        // 1. Ambil Data berdasarkan ID
        $data = PenyusutanPenambahan::findOrFail($id);

        // 2. Isi Properti Form dengan Data Database
        $this->id_data = $data->id;
        $this->saldo_awal = $data->saldo_awal;
        $this->koreksi_saldo_awal = $data->koreksi_saldo_awal;
        $this->hibah = $data->hibah;
        $this->mutasi = $data->mutasi;
        $this->reklasifikasi = $data->reklasifikasi;
        $this->lainnya = $data->lainnya;
    }

    protected $rules = [
        'saldo_awal' => 'nullable|numeric',
        'koreksi_saldo_awal' => 'nullable|numeric',
        'hibah' => 'nullable|numeric',
        'mutasi' => 'nullable|numeric',
        'reklasifikasi' => 'nullable|numeric',
        'lainnya' => 'nullable|numeric',
    ];

    public function update()
    {
        if (! session()->has('active_skpd_id')) {
        $this->dispatch('swal:modal', [
            'type' => 'warning', 
            'title' => 'SKPD Belum Dipilih!',
            'text'  => 'Sesi SKPD Anda telah berakhir. Silakan pilih SKPD ulang.',
        ]);
        return;
    }
        $this->validate();

        // 3. Update Data
        $data = PenyusutanPenambahan::find($this->id_data);
        
        $data->update([
            'saldo_awal' => $this->saldo_awal,
            'koreksi_saldo_awal' => $this->koreksi_saldo_awal,
            'hibah' => $this->hibah,
            'mutasi' => $this->mutasi,
            'reklasifikasi' => $this->reklasifikasi,
            'lainnya' => $this->lainnya,
        ]);

        session()->flash('success', 'Data Penyusutan Penambahan berhasil diperbarui.');

        return $this->redirect(route('AsetUtama.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.dbp.penyusutan.penambahan-edit');
    }
}