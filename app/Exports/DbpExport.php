<?php

namespace App\Exports;

use App\Models\AsetUtama;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class DbpExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $tgl_laporan;
    protected $tgl_lalu;
    protected $search;

    public function __construct($tgl_laporan, $tgl_lalu, $search)
    {
        $this->tgl_laporan = $tgl_laporan;
        $this->tgl_lalu = $tgl_lalu;
        $this->search = $search;
    }

    public function view(): View
    {
        // 1. SETUP TANGGAL DINAMIS (PENTING!)
        // Kita harus set config lagi disini karena Export berjalan di proses terpisah
        $dateNow = Carbon::parse($this->tgl_laporan);
        $dateLalu = Carbon::parse($this->tgl_lalu);

        config([
            'laporan.tgl_sekarang' => $dateNow->format('Y-m-d'),
            'laporan.tgl_lalu' => $dateLalu->format('Y-m-d'),
        ]);

        // 2. QUERY DATA
        // Gunakan query yang SAMA PERSIS dengan di Livewire
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

        // Ambil SEMUA data (get), jangan dipaginate
        $data = $query->latest()->get();

        return view('exports.dbp', [
            'AsetUtama' => $data,
            'carbonLaporan' => $dateNow,
            'carbonLalu' => $dateLalu,
            'nama_skpd' => session('active_skpd_id') 
                            ? \App\Models\Skpd::find(session('active_skpd_id'))->nama 
                            : 'Semua SKPD'
        ]);
    }

    // Styling opsional agar Excel lebih rapi
    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk Header (Baris 1-3)
            1    => ['font' => ['bold' => true, 'size' => 12]],
            2    => ['font' => ['bold' => true]],
            3    => ['font' => ['bold' => true]],
        ];
    }
}