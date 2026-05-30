<?php

namespace App\Livewire\MutasiAset;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\AsetUtama;
use App\Models\Skpd;
use App\Exports\MutasiAsetExport;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    /* ===============================
     * FILTER & PARAMETER
     * =============================== */
    public $search = '';
    public $tgl_laporan;
    public $tgl_lalu;

    /* ===============================
     * INIT
     * =============================== */
    public function mount()
    {
        $this->tgl_laporan = now()->format('Y-m-d');
        $this->tgl_lalu    = now()->startOfYear()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /* ===============================
     * EXPORT EXCEL
     * =============================== */
    public function exportExcel()
    {
        return Excel::download(
            new MutasiAsetExport(
                $this->tgl_laporan,
                $this->tgl_lalu,
                $this->search ?: null
            ),
            'mutasi-aset.xlsx'
        );
    }

    /* ===============================
     * LOGIC MUTASI ASET (TIDAK DIUBAH)
     * =============================== */
    public function getMutasiAsetData()
    {
        /** ===============================
         * 1️⃣ AKUN NERACA
         * =============================== */
        $akunNeracaTetap = [
            '1'     => 'ASET',
            '1.3'   => 'ASET TETAP',
            '1.3.1' => 'ASET TETAP TANAH',
            '1.3.2' => 'ASET TETAP PERALATAN DAN MESIN',
            '1.3.3' => 'ASET TETAP GEDUNG DAN BANGUNAN',
            '1.3.4' => 'ASET TETAP JALAN, IRIGASI DAN JARINGAN',
            '1.3.5' => 'ASET TETAP LAINNYA',
            '1.3.6' => 'KONSTRUKSI DALAM PENGERJAAN',

            '2'     => 'AKUMULASI PENYUSUTAN',
            '2.1'   => 'ALSIN',
            '2.2'   => 'GEDUNG BANGUNAN',
            '2.3'   => 'JIJ',
            '2.4'   => 'ATL',

            '1.5'   => 'ASET LAINNYA',
            '1.5.2' => 'KEMITRAAN DENGAN PIHAK KETIGA',
            '1.5.3' => 'ASET TIDAK BERWUJUD',
            '1.5.4' => 'ASET LAIN-LAIN',

            '2.5' => 'AKUMULASI AMORTISASI TIDAK BERWUJUD',
            '2.6' => 'AKUMULASI PENYUSUTAN LAINNYA'
        ];

        /** ===============================
         * 2️⃣ MAPPING PENYUSUTAN
         * =============================== */
        $mapPenyusutan = [
            '2'   => '1',
            '2.1' => '1.3.2',
            '2.2' => '1.3.3',
            '2.3' => '1.3.4',
            '2.4' => '1.3.5',
            '2.5' => '1.5.3',
            '2.6' => '1.5.4',
        ];

        /** ===============================
         * 3️⃣ DATA ASET
         * =============================== */
        $aset = AsetUtama::with([
            'kodeBarang',
            'PerolehanPenambahan',
            'PerolehanPengurangan',
            'PenyusutanPenambahan',
            'PenyusutanPengurangan',
        ])->get();

        /** ===============================
         * 4️⃣ HITUNG MUTASI
         * =============================== */
        $mutasiAset = [];

        foreach ($akunNeracaTetap as $kodeAkun => $uraian) {

            $row = [
                'kode' => $kodeAkun,
                'uraian' => $uraian,
                'saldo_awal' => 0,

                'tambah_koreksi' => 0,
                'tambah_barang' => 0,
                'tambah_belanja' => 0,
                'tambah_hibah' => 0,
                'tambah_mutasi' => 0,
                'tambah_reklas' => 0,
                'tambah_lainnya' => 0,

                'kurang_koreksi' => 0,
                'kurang_hibah' => 0,
                'kurang_mutasi' => 0,
                'kurang_reklas' => 0,
                'kurang_hapus' => 0,
                'kurang_lainnya' => 0,
            ];

            foreach ($aset as $item) {
                $kodeBarang = $item->kodeBarang->kode ?? null;
                if (!$kodeBarang) continue;

                /** ===============================
                 * PEROLEHAN (1.x)
                 * =============================== */
                if (str_starts_with($kodeAkun, '1')) {
                    if (!str_starts_with($kodeBarang, $kodeAkun)) continue;

                    if ($p = $item->PerolehanPenambahan) {
                        $row['saldo_awal']     += $p->saldo_awal ?? 0;
                        $row['tambah_koreksi'] += $p->koreksi_saldo_awal ?? 0;
                        $row['tambah_barang']  += $p->barang_lama ?? 0;
                        $row['tambah_belanja'] += $p->belanja ?? 0;
                        $row['tambah_hibah']   += $p->hibah ?? 0;
                        $row['tambah_mutasi']  += $p->mutasi ?? 0;
                        $row['tambah_reklas']  += $p->reklasifikasi ?? 0;
                        $row['tambah_lainnya'] += $p->lainnya ?? 0;
                    }

                    if ($k = $item->PerolehanPengurangan) {
                        $row['kurang_koreksi'] += $k->koreksi_saldo_awal ?? 0;
                        $row['kurang_hibah']   += $k->hibah ?? 0;
                        $row['kurang_mutasi']  += $k->mutasi ?? 0;
                        $row['kurang_reklas']  += $k->reklasifikasi ?? 0;
                        $row['kurang_hapus']   += $k->penghapusan ?? 0;
                        $row['kurang_lainnya'] += $k->lainnya ?? 0;
                    }
                }

                /** ===============================
                 * PENYUSUTAN (2.x)
                 * =============================== */
                if (str_starts_with($kodeAkun, '2')) {
                    // === AKUMULASI PENYUSUTAN TOTAL (2) ===
                    if ($kodeAkun === '2') {

                        if ($p = $item->PenyusutanPenambahan) {
                            $row['saldo_awal']     += $p->saldo_awal ?? 0;
                            $row['tambah_koreksi'] += $p->koreksi_saldo_awal ?? 0;
                            $row['tambah_barang']  += $p->barang_lama ?? 0;
                            $row['tambah_belanja'] += $p->belanja ?? 0;
                            $row['tambah_hibah']   += $p->hibah ?? 0;
                            $row['tambah_mutasi']  += $p->mutasi ?? 0;
                            $row['tambah_reklas']  += $p->reklasifikasi ?? 0;
                            $row['tambah_lainnya'] += $p->lainnya ?? 0;
                        }

                        if ($k = $item->PenyusutanPengurangan) {
                            $row['kurang_koreksi'] += $k->koreksi_saldo_awal ?? 0;
                            $row['kurang_mutasi']  += $k->mutasi ?? 0;
                            $row['kurang_reklas']  += $k->reklasifikasi ?? 0;
                            $row['kurang_hapus']   += $k->penghapusan ?? 0;
                            $row['kurang_lainnya'] += $k->lainnya ?? 0;
                        }

                        continue;
                    }

                    // === PENYUSUTAN PER KELOMPOK (2.1 - 2.6) ===
                    if (!isset($mapPenyusutan[$kodeAkun])) continue;
                    if (!str_starts_with($kodeBarang, $mapPenyusutan[$kodeAkun])) continue;

                    if ($p = $item->PenyusutanPenambahan) {
                        $row['saldo_awal']     += $p->saldo_awal ?? 0;
                        $row['tambah_koreksi'] += $p->koreksi_saldo_awal ?? 0;
                        $row['tambah_barang']  += $p->barang_lama ?? 0;
                        $row['tambah_belanja'] += $p->belanja ?? 0;
                        $row['tambah_hibah']   += $p->hibah ?? 0;
                        $row['tambah_mutasi']  += $p->mutasi ?? 0;
                        $row['tambah_reklas']  += $p->reklasifikasi ?? 0;
                        $row['tambah_lainnya'] += $p->lainnya ?? 0;
                    }

                    if ($k = $item->PenyusutanPengurangan) {
                        $row['kurang_koreksi'] += $k->koreksi_saldo_awal ?? 0;
                        $row['kurang_mutasi']  += $k->mutasi ?? 0;
                        $row['kurang_reklas']  += $k->reklasifikasi ?? 0;
                        $row['kurang_hapus']   += $k->penghapusan ?? 0;
                        $row['kurang_lainnya'] += $k->lainnya ?? 0;
                    }
                }
            }

            $totalPenambahan = array_sum([
                $row['tambah_koreksi'],
                $row['tambah_barang'],
                $row['tambah_belanja'],
                $row['tambah_hibah'],
                $row['tambah_mutasi'],
                $row['tambah_reklas'],
                $row['tambah_lainnya'],
            ]);

            $totalPengurangan = array_sum([
                $row['kurang_koreksi'],
                $row['kurang_hibah'],
                $row['kurang_mutasi'],
                $row['kurang_reklas'],
                $row['kurang_hapus'],
                $row['kurang_lainnya'],
            ]);

            $row['total_penambahan'] = $totalPenambahan;
            $row['total_pengurangan'] = $totalPengurangan;
            $row['saldo_akhir'] = $row['saldo_awal'] + $totalPenambahan - $totalPengurangan;

            $mutasiAset[] = $row;
        }

        if ($this->search) {
            $keyword = strtolower($this->search);
            $mutasiAset = collect($mutasiAset)->filter(fn ($row) =>
                str_contains(strtolower($row['kode']), $keyword) ||
                str_contains(strtolower($row['uraian']), $keyword)
            )->values()->all();
        }

        return $mutasiAset;
    }

    /* ===============================
     * RENDER
     * =============================== */
    public function render()
    {
        $mutasiAset = $this->getMutasiAsetData();

        $namaDaerah = session('active_skpd_id')
            ? Skpd::find(session('active_skpd_id'))?->nama
            : 'Semua Data';

        $summary = app(\App\Livewire\Rekap\Index::class)->getSummaryRekap();

        return view('livewire.mutasi-aset.index',['summary' => $summary],
         compact(
            'mutasiAset',
            'namaDaerah'
        ));
    }
}
