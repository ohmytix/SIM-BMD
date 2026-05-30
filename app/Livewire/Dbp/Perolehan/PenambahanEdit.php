<?php

namespace App\Livewire\Dbp\Perolehan;

use Livewire\Component;
use App\Models\PerolehanPenambahan;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PenambahanEdit extends Component
{
    public $id_data;
    
    // Properti Form
    public $saldo_awal;
    public $koreksi_saldo_awal;
    public $belanja;
    public $hibah;
    public $mutasi;
    public $reklasifikasi;
    public $lainnya;

    public function mount($id)
    {
        $data = PerolehanPenambahan::findOrFail($id);

        $this->id_data = $data->id;
        $this->saldo_awal = $data->saldo_awal;
        $this->koreksi_saldo_awal = $data->koreksi_saldo_awal;
        $this->belanja = $data->belanja;
        $this->hibah = $data->hibah;
        $this->mutasi = $data->mutasi;
        $this->reklasifikasi = $data->reklasifikasi;
        $this->lainnya = $data->lainnya;
    }

    protected $rules = [
        'saldo_awal' => 'nullable|numeric',
        'koreksi_saldo_awal' => 'nullable|numeric',
        'belanja' => 'nullable|numeric',
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

        $data = PerolehanPenambahan::find($this->id_data);
        
        $data->update([
            'saldo_awal' => $this->saldo_awal,
            'koreksi_saldo_awal' => $this->koreksi_saldo_awal,
            'belanja' => $this->belanja,
            'hibah' => $this->hibah,
            'mutasi' => $this->mutasi,
            'reklasifikasi' => $this->reklasifikasi,
            'lainnya' => $this->lainnya,
        ]);

        session()->flash('success', 'Data Mutasi Penambahan berhasil diperbarui.');

        return $this->redirect(route('AsetUtama.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.dbp.perolehan.penambahan-edit');
    }
}