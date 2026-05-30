<?php

namespace App\Livewire\Dbp\Perolehan;

use Livewire\Component;
use App\Models\PerolehanPengurangan;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PenguranganCreate extends Component
{
    public $aset_utama_id; // ID Induk
    
    // Properti Form
    public $koreksi_saldo_awal;
    public $hibah;
    public $mutasi;
    public $reklasifikasi;
    public $penghapusan;
    public $lainnya;

    public function mount($aset_utama_id)
    {
        $this->aset_utama_id = $aset_utama_id;
    }

    protected $rules = [
        'koreksi_saldo_awal' => 'nullable|numeric',
        'hibah' => 'nullable|numeric',
        'mutasi' => 'nullable|numeric',
        'reklasifikasi' => 'nullable|numeric',
        'penghapusan' => 'nullable|numeric',
        'lainnya' => 'nullable|numeric',
    ];

    public function store()
    {
        if (! session()->has('active_skpd_id')) {
            $this->dispatch('swal:modal', [
                'type' => 'warning', 
                'title' => 'SKPD Belum Dipilih!',
                'text'  => 'Silakan pilih SKPD terlebih dahulu sebelum menyimpan rincian.',
            ]);
            return;
        }

        $this->validate();

        PerolehanPengurangan::create([
            'aset_utama_id' => $this->aset_utama_id,
            'koreksi_saldo_awal' => $this->koreksi_saldo_awal,
            'hibah' => $this->hibah,
            'mutasi' => $this->mutasi,
            'reklasifikasi' => $this->reklasifikasi,
            'penghapusan' => $this->penghapusan,
            'lainnya' => $this->lainnya,
        ]);

        session()->flash('success', 'Data Perolehan Pengurangan berhasil disimpan.');

        return $this->redirect(route('AsetUtama.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.dbp.perolehan.pengurangan-create');
    }
}