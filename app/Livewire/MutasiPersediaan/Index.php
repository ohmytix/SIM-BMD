<?php

namespace App\Livewire\MutasiPersediaan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Persediaan;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout; // <--- 1. IMPORT INI
use Livewire\Attributes\On;
#[Layout('layouts.app')] // <--- 2. PASANG INI DI ATAS CLASS
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // ... (Logika query data Anda tetap sama) ...
        
        $skpdId = Session::get('active_skpd_id', 1);

        $data = Persediaan::query()
            ->where('skpd_id', $skpdId)
            ->where('nama_barang', 'like', '%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        // Logika hitung saldo
        $data->getCollection()->transform(function ($persediaan) {
            $tambah = $persediaan->realisasi + 
                      $persediaan->hibah_penambahan + 
                      $persediaan->reklasifikasi_penambahan;
            
            $kurang = $persediaan->pemakaian + 
                      $persediaan->hibah_pengurangan + 
                      $persediaan->reklasifikasi_pengurangan;

            $persediaan->saldo_akhir_hitung = ($persediaan->saldo + $tambah) - $kurang;
            return $persediaan;
        });

        $activeSkpdId = session('active_skpd_id');
        $namaSkpdAktif = 'Semua Data'; // Default jika belum pilih

        if ($activeSkpdId) {
            $skpd = \App\Models\Skpd::find($activeSkpdId);
            $namaSkpdAktif = $skpd ? $skpd->nama : 'SKPD Tidak Ditemukan';
        }

        // 3. HAPUS ->layout() DARI SINI
        return view('livewire.mutasi-persediaan.index', [
            'tabel_persediaan' => $data,
            'namaDaerah' => $namaSkpdAktif
        ]); 
    }

    public function deleteTrigger($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    // Eksekusi Hapus (Hanya jalan kalau JS mengirim sinyal 'deleteConfirmed')
    #[On('deleteConfirmed')] // <--- 2. PASANG "TELINGA" INI
    public function delete($id) // <--- 3. Ganti nama jadi deleteData (biar tidak bingung)
    {
        $item = Persediaan::find($id);
        if ($item) {
            $item->delete();

            // Kirim notifikasi sukses ke JS
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Data berhasil dihapus.'
            ]);
        }
    }
}