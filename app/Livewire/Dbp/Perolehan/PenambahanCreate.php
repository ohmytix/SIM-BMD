<?php

namespace App\Livewire\Dbp\Perolehan;

use Livewire\Component;
use App\Models\PerolehanPenambahan;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PenambahanCreate extends Component
{
    public $aset_utama_id; // ID Induk
    
    // Properti Form
    public $saldo_awal;
    public $koreksi_saldo_awal;
    public $belanja;
    public $hibah;
    public $mutasi;
    public $reklasifikasi;
    public $lainnya;

    public function mount($aset_utama_id)
    {
        $this->aset_utama_id = $aset_utama_id;
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

        PerolehanPenambahan::create([
            'aset_utama_id' => $this->aset_utama_id,
            'saldo_awal' => $this->saldo_awal,
            'koreksi_saldo_awal' => $this->koreksi_saldo_awal,
            'belanja' => $this->belanja,
            'hibah' => $this->hibah,
            'mutasi' => $this->mutasi,
            'reklasifikasi' => $this->reklasifikasi,
            'lainnya' => $this->lainnya,
        ]);

        session()->flash('success', 'Data Mutasi Penambahan berhasil disimpan.');

        return $this->redirect(route('AsetUtama.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.dbp.perolehan.penambahan-create');
    }
}