<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MutasiAsetExport implements FromView, ShouldAutoSize, WithStyles, WithEvents
{
    protected $tglLaporan;
    protected $tglLalu;
    protected $search;
    protected $mutasiAset;
    protected $namaDaerah;

    public function __construct($tglLaporan, $tglLalu, $search = null)
    {
        $this->tglLaporan = $tglLaporan;
        $this->tglLalu    = $tglLalu;
        $this->search     = $search;

        // Ambil data dari logic Livewire (1 sumber data)
        $livewire = app(\App\Livewire\MutasiAset\Index::class);
        $livewire->search = $search;
        $this->mutasiAset = $livewire->getMutasiAsetData();

        $this->namaDaerah = session('active_skpd_id')
            ? \App\Models\Skpd::find(session('active_skpd_id'))?->nama
            : 'SEMUA DATA';
    }

    public function view(): View
    {
        return view('exports.mutasi-aset', [
            'mutasiAset' => $this->mutasiAset,
            'namaDaerah' => $this->namaDaerah,
            'tglLaporan' => $this->tglLaporan,
            'tglLalu'    => $this->tglLalu,
        ]);
    }

    /**
     * ===============================
     * BOLD BARIS JUDUL & HEADER
     * ===============================
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
            3 => ['font' => ['bold' => true]],
            4 => ['font' => ['bold' => true]],
            6 => ['font' => ['bold' => true]],
            7 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * ===============================
     * STYLE DETAIL (MIRIP SCREENSHOT)
     * ===============================
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /**
                 * ===============================
                 * MERGE & CENTER JUDUL
                 * ===============================
                 */
                $sheet->mergeCells('A1:T1');
                $sheet->mergeCells('A2:T2');
                $sheet->mergeCells('A3:T3');
                $sheet->mergeCells('A4:T4');

                $sheet->getStyle('A1:A4')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                /**
                 * ===============================
                 * HEADER TABEL (BARIS 6-7)
                 * ===============================
                 */
                $sheet->getStyle('A6:R7')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // AKUN NERACA
                $sheet->getStyle('A6:A7')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F4B183');

                // SALDO AWAL
                $sheet->getStyle('B6:B7')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFD966');

                // MUTASI PENAMBAHAN
                $sheet->getStyle('C6:J7')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('92D050');

                // MUTASI KURANG
                $sheet->getStyle('K6:Q7')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('9DC3E6');

                $sheet->getStyle('R6:R7')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('E6B8B7');

                /**
                 * ===============================
                 * BORDER DATA
                 * ===============================
                 */
                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("A8:R{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                /**
                 * ===============================
                 * FORMAT ANGKA (RUPIAH / AKUNTANSI)
                 * ===============================
                 */
                $sheet->getStyle("B8:R{$lastRow}")
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                /**
                 * ===============================
                 * ALIGNMENT DATA
                 * ===============================
                 */
                $sheet->getStyle("A8:A{$lastRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->getStyle("B8:R{$lastRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            }
        ];
    }
}
