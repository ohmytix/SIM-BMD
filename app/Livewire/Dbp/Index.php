<?php

namespace App\Livewire\Dbp;

use Livewire\Component;
use App\Models\AsetUtama;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On; // <--- WAJIB DI IMPORT
use App\Models\HitungPenyusutanMutasi;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $mutasi_aset_id;
    public $mutasi_tanggal;
    public $mutasi_id;
    
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // 1. QUERY DATA
        // (Filter SKPD_ID sudah otomatis jalan berkat Trait HasSkpd)
        $query = AsetUtama::with([
            'kodeBarang', 
            'PerolehanPenambahan', 
            'PerolehanPengurangan',
            'PenyusutanPenambahan',
            'PenyusutanPengurangan',
            'Mutasi'
        ]);

        // 2. LOGIKA PENCARIAN
        if ($this->search) {
            $query->where(function($q) {
                $q->where('sub_sub_rincan_objek', 'like', '%'.$this->search.'%')
                  ->orWhereHas('kodeBarang', function($kb) {
                      $kb->where('kode', 'like', '%'.$this->search.'%');
                  });
            });
        }

        // 3. AMBIL NAMA SKPD AKTIF (PERBAIKAN DISINI)
        // Kita cari nama SKPD berdasarkan ID yang ada di session
        $activeSkpdId = session('active_skpd_id');
        $namaSkpdAktif = 'Semua Data'; // Default jika belum pilih

        if ($activeSkpdId) {
            $skpd = \App\Models\Skpd::find($activeSkpdId);
            $namaSkpdAktif = $skpd ? $skpd->nama : 'SKPD Tidak Ditemukan';
        }

        return view('livewire.dbp.index', [
            'AsetUtama' => $query->latest()->paginate(10),
            'namaDaerah' => $namaSkpdAktif // <--- Kirim nama dinamis ke View
        ]);
    }
    
    // TRIGGER 1: Hapus Aset Utama
    public function deleteAsetTrigger($id)
    {
        // Kirim ID sebagai STRING KOMBINASI: "aset-1"
        $this->dispatch('confirm-delete', id: 'aset-' . $id);
    }

    // TRIGGER 2: Hapus Mutasi
    public function deleteMutasiTrigger($id)
    {
        // Kirim ID sebagai STRING KOMBINASI: "mutasi-1"
        $this->dispatch('confirm-delete', id: 'mutasi-' . $id);
    }

    // EKSEKUTOR (Menangani respon dari JS)
    #[On('deleteConfirmed')]
    public function delete($id) // Parameter $id ini isinya string kombinasi (cth: "aset-1")
    {
        // Pecah string berdasarkan tanda "-"
        $parts = explode('-', $id);
        
        // Validasi format untuk mencegah error array offset
        if (count($parts) < 2) return;

        $type = $parts[0]; // 'aset' atau 'mutasi'
        $realId = $parts[1]; // ID asli (angka)

        if ($type === 'aset') {
            $data = AsetUtama::find($realId);
            if ($data) {
                $data->delete();
                $this->dispatch('alert', [
                    'type' => 'success', 
                    'message' => 'Data Aset berhasil dihapus.'
                ]);
            }
        } 
        elseif ($type === 'mutasi') {
            $data = HitungPenyusutanMutasi::find($realId);
            if ($data) {
                $data->delete();
                $this->dispatch('alert', [
                    'type' => 'success', 
                    'message' => 'Data Mutasi berhasil dihapus.'
                ]);
            }
        }
    }

    // === FITUR MODAL MUTASI ===
    public function openMutasiModal($asetId)
    {
        $this->resetErrorBag();
        $this->mutasi_aset_id = $asetId;
        
        $existingMutasi = HitungPenyusutanMutasi::where('aset_utama_id', $asetId)->first();

        if ($existingMutasi) {
            $this->mutasi_id = $existingMutasi->id;
            $this->mutasi_tanggal = $existingMutasi->tanggal_mutasi;
        } else {
            $this->mutasi_id = null;
            $this->mutasi_tanggal = null;
        }

        $this->dispatch('show-mutasi-modal');
    }

    public function saveMutasi()
    {
        // PERBAIKAN: Cek apakah Session SKPD aktif?
        if (! session()->has('active_skpd_id')) {
            $this->dispatch('swal:modal', [
                'type' => 'warning', 
                'title' => 'SKPD Belum Dipilih!',
                'text'  => 'Silakan pilih SKPD terlebih dahulu sebelum menyimpan data mutasi.',
            ]);
            return; // Berhenti disini
        }

        $this->validate([
            'mutasi_tanggal' => 'required|date',
        ]);

        HitungPenyusutanMutasi::updateOrCreate(
            ['aset_utama_id' => $this->mutasi_aset_id],
            ['tanggal_mutasi' => $this->mutasi_tanggal]
        );

        $this->dispatch('hide-mutasi-modal');
        
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Data Mutasi berhasil disimpan.'
        ]);
    }
}