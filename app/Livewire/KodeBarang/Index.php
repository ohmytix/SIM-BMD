<?php

namespace App\Livewire\KodeBarang;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KodeBarang;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // 1. Trigger dari Tombol Hapus di View
    // Persis seperti MutasiPersediaan
    public function deleteTrigger($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    // 2. Eksekutor (Dijalankan setelah konfirmasi JS)
    // Persis seperti MutasiPersediaan
    #[On('deleteConfirmed')]
    public function delete($id)
    {
        $data = KodeBarang::find($id);
        
        if ($data) {
            $data->delete();

            // Kirim notifikasi sukses ke JS
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Kode Barang berhasil dihapus.'
            ]);
        }
    }

    public function render()
    {
        $query = KodeBarang::query();

        if ($this->search) {
            $query->where('kode', 'like', '%' . $this->search . '%')
                  ->orWhere('sub_sub_rincang', 'like', '%' . $this->search . '%')
                  ->orWhere('akun', 'like', '%' . $this->search . '%');
        }

        return view('livewire.kode-barang.index', [
            'tabel_kodebarang' => $query->latest()->paginate(15)
        ]);
    }
}