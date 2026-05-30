<?php

namespace App\Livewire\Dbp\Penyusutan;

use Livewire\Component;
use App\Models\PenyusutanPengurangan;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PenguranganEdit extends Component
{
    public $id_data;
    
    // Properti Form
    public $koreksi_saldo_awal;
    public $hibah;
    public $mutasi;
    public $reklasifikasi;
    public $penghapusan;
    public $lainnya;

    public function mount($id)
    {
        $data = PenyusutanPengurangan::findOrFail($id);

        $this->id_data = $data->id;
        $this->koreksi_saldo_awal = $data->koreksi_saldo_awal;
        $this->hibah = $data->hibah;
        $this->mutasi = $data->mutasi;
        $this->reklasifikasi = $data->reklasifikasi;
        $this->penghapusan = $data->penghapusan;
        $this->lainnya = $data->lainnya;
    }

    protected $rules = [
        'koreksi_saldo_awal' => 'nullable|numeric',
        'hibah' => 'nullable|numeric',
        'mutasi' => 'nullable|numeric',
        'reklasifikasi' => 'nullable|numeric',
        'penghapusan' => 'nullable|numeric',
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

        $data = PenyusutanPengurangan::find($this->id_data);
        
        $data->update([
            'koreksi_saldo_awal' => $this->koreksi_saldo_awal,
            'hibah' => $this->hibah,
            'mutasi' => $this->mutasi,
            'reklasifikasi' => $this->reklasifikasi,
            'penghapusan' => $this->penghapusan,
            'lainnya' => $this->lainnya,
        ]);

        session()->flash('success', 'Data Penyusutan Pengurangan berhasil diperbarui.');

        return $this->redirect(route('AsetUtama.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.dbp.penyusutan.pengurangan-edit');
    }
}