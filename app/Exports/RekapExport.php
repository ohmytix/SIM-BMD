<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RekapExport implements FromView, ShouldAutoSize, WithStyles
{
    protected array $rekap;
    protected string $namaDaerah;
    protected string $tglLalu;
    protected string $tglLaporan;

    public function __construct(
        array $rekap,
        string $namaDaerah,
        string $tglLalu,
        string $tglLaporan
    ) {
        $this->rekap       = $rekap;
        $this->namaDaerah  = $namaDaerah;
        $this->tglLalu     = $tglLalu;
        $this->tglLaporan  = $tglLaporan;
    }

    public function view(): View
    {
        return view('exports.rekap', [
            'rekap' => $this->rekap,
            'namaDaerah' => $this->namaDaerah,
            'tglLalu' => $this->tglLalu,
            'tglLaporan' => $this->tglLaporan,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        /** =========================
         * JUDUL
         * ========================= */
        $sheet->mergeCells('A1:V1');
        $sheet->mergeCells('A2:V2');
        $sheet->mergeCells('A3:V3');
        $sheet->mergeCells('A4:V4');

        $sheet->getStyle('A1:A4')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => [
                'horizontal' => 'center',
                'vertical'   => 'center',
            ],
        ]);

        /** =========================
         * HEADER
         * ========================= */
        $sheet->getStyle('A6:V7')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => 'center',
                'vertical'   => 'center',
                'wrapText'   => true,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin'],
            ],
        ]);

        /** =========================
         * WARNA HEADER
         * ========================= */
        $sheet->getStyle('A6:C7')->getFill()->setFillType('solid')->getStartColor()->setRGB('FFD966');
        $sheet->getStyle('D6:E7')->getFill()->setFillType('solid')->getStartColor()->setRGB('F4B084');
        $sheet->getStyle('F6:L7')->getFill()->setFillType('solid')->getStartColor()->setRGB('9DC3E6');
        $sheet->getStyle('M6:M7')->getFill()->setFillType('solid')->getStartColor()->setRGB('BDD7EE');
        $sheet->getStyle('N6:S7')->getFill()->setFillType('solid')->getStartColor()->setRGB('C6A2A2');
        $sheet->getStyle('T6:T7')->getFill()->setFillType('solid')->getStartColor()->setRGB('D9B2B2');
        $sheet->getStyle('U6:V7')->getFill()->setFillType('solid')->getStartColor()->setRGB('FF9999');

        /** =========================
         * BODY
         * ========================= */
        $lastRow = count($this->rekap) + 7;

        $sheet->getStyle("A8:V{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin'],
            ],
            'alignment' => [
                'vertical' => 'center',
            ],
        ]);

        /** =========================
         * FORMAT ANGKA (PENTING)
         * =========================
         * KECUALI:
         * A = No
         * B = Kode
         * C = Uraian
         * D = Jumlah
         */
        $sheet->getStyle("E8:V{$lastRow}")
            ->getNumberFormat()
            ->setFormatCode('#,##0.00');

        // Align angka ke kanan
        $sheet->getStyle("E8:V{$lastRow}")
            ->getAlignment()
            ->setHorizontal('right');

        // Kolom teks ke kiri
        $sheet->getStyle("B8:C{$lastRow}")
            ->getAlignment()
            ->setHorizontal('left');

        return [];
    }
}
