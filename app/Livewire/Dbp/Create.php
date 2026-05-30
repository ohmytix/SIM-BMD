<?php

namespace App\Livewire\Dbp;

use Livewire\Component;
use App\Models\AsetUtama;
use App\Models\KodeBarang;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class Create extends Component
{
    // === 1. PROPERTI BARU UNTUK SEARCHABLE DROPDOWN ===
    public $searchKode = '';        // Menampung input ketikan user
    public $selectedKodeDisplay = ''; // Menampung teks untuk ditampilkan setelah dipilih
    
    // Properti Public (Sesuai kolom di database)
    public $kode_barang_id; // Ini wajib public agar wire:model tetap jalan
    
    public $sub_sub_rincan_objek;
    public $spesifikasi;
    public $spesifikasi_lainnya;
    public $dokumen;
    public $cara_perolehan;
    public $tanggal_perolehan;
    public $ukuran_barang;
    public $satuan_barang;
    public $kondisi_barang;
    public $jumlah_input = 1;

    // Rules Validasi
    protected $rules = [
        'kode_barang_id' => 'required|exists:kode_barangs,id',
        'sub_sub_rincan_objek' => 'nullable|string',
        'spesifikasi' => 'nullable|string',
        'spesifikasi_lainnya' => 'nullable|string',
        'dokumen' => 'nullable|string',
        'cara_perolehan' => 'nullable|string',
        'tanggal_perolehan' => 'nullable|date',
        'ukuran_barang' => 'nullable|string',
        'satuan_barang' => 'nullable|string',
        'kondisi_barang' => 'nullable|string',
        'jumlah_input' => 'required|integer|min:1|max:50',
    ];

    // === 2. METHOD BARU UNTUK MENANGANI PILIHAN ===
    
    // Dijalankan saat user mengklik salah satu hasil pencarian
    public function selectKode($id, $kode, $nama)
    {
        $this->kode_barang_id = $id; // Set ID untuk disimpan ke DB
        $this->selectedKodeDisplay = $kode . ' - ' . $nama; // Set tampilan text
        $this->searchKode = ''; // Kosongkan pencarian agar list tertutup
    }

    // Dijalankan saat tombol "Ganti" diklik
    public function resetKode()
    {
        $this->kode_barang_id = null;
        $this->selectedKodeDisplay = '';
        $this->searchKode = '';
    }

    public function store()
    {
        // 1. CEK SESSION
        if (! session()->has('active_skpd_id')) {
            $this->dispatch('swal:modal', [
                'type' => 'warning', 
                'title' => 'SKPD Belum Dipilih!',
                'text'  => 'Silakan pilih SKPD terlebih dahulu pada menu di bagian atas halaman sebelum menyimpan data.',
            ]);
            return;
        }
        
        $this->validate();
        
        DB::transaction(function () {
            // 3. LOOPING SEBANYAK JUMLAH INPUT
            for ($i = 0; $i < $this->jumlah_input; $i++) {
                AsetUtama::create([
                    'kode_barang_id' => $this->kode_barang_id,
                    'sub_sub_rincan_objek' => $this->sub_sub_rincan_objek,
                    'spesifikasi' => $this->spesifikasi,
                    'spesifikasi_lainnya' => $this->spesifikasi_lainnya,
                    'dokumen' => $this->dokumen,
                    'cara_perolehan' => $this->cara_perolehan,
                    'tanggal_perolehan' => $this->tanggal_perolehan,
                    'ukuran_barang' => $this->ukuran_barang,
                    'satuan_barang' => $this->satuan_barang,
                    'kondisi_barang' => $this->kondisi_barang,
                    // skpd_id otomatis terisi via Trait HasSkpd
                ]);
            }
        });

        $pesan = $this->jumlah_input > 1 
            ? $this->jumlah_input . ' Data Aset berhasil diduplikasi & ditambahkan.' 
            : 'Data Aset berhasil ditambahkan.';

        session()->flash('success', $pesan);
        
        return $this->redirect(route('AsetUtama.index'), navigate: true);
    }

    public function render()
    {
        // === 3. LOGIKA PENCARIAN EFISIEN ===
        $hasilPencarian = [];

        // Hanya cari jika user mengetik (minimal 1 karakter)
        if (!empty($this->searchKode)) {
            $hasilPencarian = KodeBarang::query()
                ->where('kode', 'like', '%' . $this->searchKode . '%')
                // Pastikan nama kolom 'sub_sub_rincang' sesuai dengan database Anda
                ->orWhere('sub_sub_rincang', 'like', '%' . $this->searchKode . '%') 
                ->take(15) // PENTING: Batasi hasil maksimal 15 agar tidak berat
                ->get();
        }

        return view('livewire.dbp.create', [
            // Kirim $hasilPencarian, BUKAN KodeBarang::all()
            'hasilPencarian' => $hasilPencarian 
        ]);
    }
}