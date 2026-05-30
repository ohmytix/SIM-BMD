<?php

namespace App\Livewire\Dbp;

use Livewire\Component;
use App\Models\AsetUtama;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
#[Layout('layouts.app')]
class Detail extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    
    // Dua Properti Tanggal
    public $tgl_laporan; // Periode Akhir (Kanan, misal: 06-2025)
    public $tgl_lalu;    // Periode Awal (Kiri, misal: 12-2024)

    // 1. LIFECYCLE MOUNT: Ambil dari Session masing-masing
    public function mount()
    {
        // Default: 2025-06-30
        $this->tgl_laporan = session('detail_tgl_laporan', '2025-06-30');
        
        // Default: 2024-12-31
        $this->tgl_lalu = session('detail_tgl_lalu', '2024-12-31');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // 2. SAAT TANGGAL LAPORAN (KANAN) DIUBAH
    public function updatedTglLaporan() 
    {
        session(['detail_tgl_laporan' => $this->tgl_laporan]);
        $this->resetPage(); 
    }

    // 3. SAAT TANGGAL LALU (KIRI) DIUBAH - (BARU)
    public function updatedTglLalu() 
    {
        session(['detail_tgl_lalu' => $this->tgl_lalu]);
        $this->resetPage(); 
    }


public function exportExcel()
{
    // 1. Setup Nama File & Config
    $fileName = 'DBP_2025_' . date('d-m-Y_H-i') . '.xls';

    $dateNow = \Carbon\Carbon::parse($this->tgl_laporan);
    $dateLalu = \Carbon\Carbon::parse($this->tgl_lalu);

    config([
        'laporan.tgl_sekarang' => $dateNow->format('Y-m-d'),
        'laporan.tgl_lalu' => $dateLalu->format('Y-m-d'),
    ]);

    // 2. Query Data
    $data = \App\Models\AsetUtama::with([
        'kodeBarang', 'PerolehanPenambahan', 'PerolehanPengurangan',
        'PenyusutanPenambahan', 'PenyusutanPengurangan', 'Mutasi'
    ]);

    if ($this->search) {
        $data->where(function($q) {
            $q->where('sub_sub_rincan_objek', 'like', '%'.$this->search.'%')
              ->orWhereHas('kodeBarang', function($kb) {
                  $kb->where('kode', 'like', '%'.$this->search.'%');
              });
        });
    }

    $AsetUtama = $data->latest()->get();

    $namaSkpd = 'Semua Data';
    if (session('active_skpd_id')) {
        $skpd = \App\Models\Skpd::find(session('active_skpd_id'));
        $namaSkpd = $skpd ? $skpd->nama : 'SKPD Tidak Ditemukan';
    }

    // 3. Render View ke Variable
    // Kita render dulu HTML-nya ke dalam string
    $htmlContent = view('exports.dbp', [
        'AsetUtama' => $AsetUtama,
        'carbonLaporan' => $dateNow,
        'carbonLalu' => $dateLalu,
        'nama_skpd' => $namaSkpd
    ])->render();

    // 4. RETURN STREAM DOWNLOAD (INI KUNCINYA)
    // Livewire akan mengenali ini sebagai perintah download file
    return response()->streamDownload(function () use ($htmlContent) {
        echo $htmlContent;
    }, $fileName);
}

    public function render()
    {
        // === SETUP TANGGAL DINAMIS ===
        // Parse tanggal dari input user (bukan dihitung otomatis lagi)
        $dateNow = Carbon::parse($this->tgl_laporan);
        $dateLalu = Carbon::parse($this->tgl_lalu); 

        // === INJECT KE CONFIG (Agar Model Tahu) ===
        // Config ini akan dibaca oleh Model AsetUtama untuk perhitungan rumus
        config([
            'laporan.tgl_sekarang' => $dateNow->format('Y-m-d'),
            'laporan.tgl_lalu' => $dateLalu->format('Y-m-d'),
        ]);

        $query = AsetUtama::with([
            'kodeBarang', 'PerolehanPenambahan', 'PerolehanPengurangan',
            'PenyusutanPenambahan', 'PenyusutanPengurangan', 'Mutasi'
        ]);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('sub_sub_rincan_objek', 'like', '%'.$this->search.'%')
                  ->orWhereHas('kodeBarang', function($kb) {
                      $kb->where('kode', 'like', '%'.$this->search.'%');
                  });
            });
        }

        return view('livewire.dbp.detail', [
            'AsetUtama' => $query->latest()->paginate(20),
            'carbonLaporan' => $dateNow, 
            'carbonLalu' => $dateLalu // Kirim variabel ini agar Header Tabel berubah sesuai input
        ]);
    }
}