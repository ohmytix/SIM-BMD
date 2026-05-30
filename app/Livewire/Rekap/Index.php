<?php

namespace App\Livewire\Rekap;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\AsetUtama;
use App\Models\KodeParentBarang;
use App\Models\Skpd;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapExport;
use Carbon\Carbon;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $tgl_lalu;
    public $tgl_laporan;
    public $search = '';
    
    public function mount()
    {
        // Default: 2025-06-30
        $this->tgl_laporan = session('detail_tgl_laporan', '2025-06-30');
        
        // Default: 2024-12-31
        $this->tgl_lalu = session('detail_tgl_lalu', '2024-12-31');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * ==========================================================
     * 🔑 SOURCE DATA (UI & EXPORT)
     * ==========================================================
     */
    public function getRekapData()
    {
        $asetGrouped = AsetUtama::with([
            'kodeBarang',
            'PenyusutanPenambahan',
            'PenyusutanPengurangan',
            'PerolehanPenambahan',
        ])->get()->groupBy(fn ($item) =>
            optional($item->kodeBarang)->kode
        );

        $parentMap = KodeParentBarang::pluck('uraian', 'kode')->toArray();
        $rekap = [];

        foreach ($asetGrouped as $kodeAnak => $items) {
            if (!$kodeAnak) continue;

            $firstItem  = $items->first();
            $jumlahUnit = $items->count();

            $segments = explode('.', $kodeAnak);
            $parentLevelMax = count($segments) - 1;

            /** ==========================
             * PARENT
             * ========================== */
            for ($i = 1; $i <= $parentLevelMax; $i++) {
                $parentKode = implode('.', array_slice($segments, 0, $i));

                if (!isset($rekap[$parentKode])) {
                    $rekap[$parentKode] = [
                        'type' => 'parent',
                        'kode' => $parentKode,
                        'uraian' => $parentMap[$parentKode] ?? '-',
                        'jumlah' => 0,
                        'saldo_awal' => 0,
                        'tambah_koreksi' => 0,
                        'tambah_barang' => 0,
                        'tambah_belanja' => 0,
                        'tambah_hibah' => 0,
                        'tambah_reklas' => 0,
                        'tambah_mutasi' => 0,
                        'tambah_lainnya' => 0,
                        'kurang_koreksi' => 0,
                        'kurang_hibah' => 0,
                        'kurang_reklas' => 0,
                        'kurang_mutasi' => 0,
                        'kurang_hapus' => 0,
                        'kurang_lainnya' => 0,
                    ];
                }

                $rekap[$parentKode]['jumlah'] += $jumlahUnit;
                $rekap[$parentKode]['saldo_awal'] +=
                    $items->sum(fn ($i) => $i->PerolehanPenambahan->saldo_awal ?? 0);

                $rekap[$parentKode]['tambah_koreksi'] += $items->sum(fn ($i) => $i->PenyusutanPenambahan->koreksi_saldo_awal ?? 0);
                $rekap[$parentKode]['tambah_barang']  += $items->sum(fn ($i) => $i->PenyusutanPenambahan->barang_lama ?? 0);
                $rekap[$parentKode]['tambah_belanja'] += $items->sum(fn ($i) => $i->PenyusutanPenambahan->belanja ?? 0);
                $rekap[$parentKode]['tambah_hibah']   += $items->sum(fn ($i) => $i->PenyusutanPenambahan->hibah ?? 0);
                $rekap[$parentKode]['tambah_reklas']  += $items->sum(fn ($i) => $i->PenyusutanPenambahan->reklasifikasi ?? 0);
                $rekap[$parentKode]['tambah_mutasi']  += $items->sum(fn ($i) => $i->PenyusutanPenambahan->mutasi ?? 0);
                $rekap[$parentKode]['tambah_lainnya'] += $items->sum(fn ($i) => $i->PenyusutanPenambahan->lainnya ?? 0);

                $rekap[$parentKode]['kurang_koreksi'] += $items->sum(fn ($i) => $i->PenyusutanPengurangan->koreksi_saldo_awal ?? 0);
                $rekap[$parentKode]['kurang_hibah']   += $items->sum(fn ($i) => $i->PenyusutanPengurangan->hibah ?? 0);
                $rekap[$parentKode]['kurang_reklas']  += $items->sum(fn ($i) => $i->PenyusutanPengurangan->reklasifikasi ?? 0);
                $rekap[$parentKode]['kurang_mutasi']  += $items->sum(fn ($i) => $i->PenyusutanPengurangan->mutasi ?? 0);
                $rekap[$parentKode]['kurang_hapus']   += $items->sum(fn ($i) => $i->PenyusutanPengurangan->penghapusan ?? 0);
                $rekap[$parentKode]['kurang_lainnya'] += $items->sum(fn ($i) => $i->PenyusutanPengurangan->lainnya ?? 0);
            }

            /** ==========================
             * ANAK
             * ========================== */
            $rekap[$kodeAnak] = [
                'type' => 'anak',
                'kode' => $kodeAnak,
                'uraian' => $firstItem->kodeBarang->sub_sub_rincang ?? '-',
                'jumlah' => $jumlahUnit,
                'saldo_awal' => $items->sum(fn ($i) => $i->PerolehanPenambahan->saldo_awal ?? 0),
                'tambah_koreksi' => $items->sum(fn ($i) => $i->PenyusutanPenambahan->koreksi_saldo_awal ?? 0),
                'tambah_barang' => $items->sum(fn ($i) => $i->PenyusutanPenambahan->barang_lama ?? 0),
                'tambah_belanja' => $items->sum(fn ($i) => $i->PenyusutanPenambahan->belanja ?? 0),
                'tambah_hibah' => $items->sum(fn ($i) => $i->PenyusutanPenambahan->hibah ?? 0),
                'tambah_reklas' => $items->sum(fn ($i) => $i->PenyusutanPenambahan->reklasifikasi ?? 0),
                'tambah_mutasi' => $items->sum(fn ($i) => $i->PenyusutanPenambahan->mutasi ?? 0),
                'tambah_lainnya' => $items->sum(fn ($i) => $i->PenyusutanPenambahan->lainnya ?? 0),
                'kurang_koreksi' => $items->sum(fn ($i) => $i->PenyusutanPengurangan->koreksi_saldo_awal ?? 0),
                'kurang_hibah' => $items->sum(fn ($i) => $i->PenyusutanPengurangan->hibah ?? 0),
                'kurang_reklas' => $items->sum(fn ($i) => $i->PenyusutanPengurangan->reklasifikasi ?? 0),
                'kurang_mutasi' => $items->sum(fn ($i) => $i->PenyusutanPengurangan->mutasi ?? 0),
                'kurang_hapus' => $items->sum(fn ($i) => $i->PenyusutanPengurangan->penghapusan ?? 0),
                'kurang_lainnya' => $items->sum(fn ($i) => $i->PenyusutanPengurangan->lainnya ?? 0),
            ];
        }

        ksort($rekap);
        $rekap = collect($rekap);

        if ($this->search) {
            $keyword = strtolower($this->search);
            $rekap = $rekap->filter(fn ($r) =>
                str_contains(strtolower($r['kode']), $keyword) ||
                str_contains(strtolower($r['uraian']), $keyword)
            );
        }

        $namaDaerah = 'Semua Data';
        if ($id = session('active_skpd_id')) {
            $namaDaerah = Skpd::find($id)?->nama ?? 'SKPD Tidak Ditemukan';
        }

        return compact('rekap', 'namaDaerah');
    }

    public function getSummaryRekap()
{
    $data = $this->getRekapData();
    $rekap = $data['rekap'];

    return [
        // SALDO AWAL (kode 1)
        'saldo_awal' => $rekap['1']['saldo_awal'] ?? 0,

        'jumlah' => $rekap['1.3']['jumlah'] ?? 0,
        'jumlah_lainnya' => $rekap['1.5']['jumlah'] ?? 0,

        // TOTAL PENAMBAHAN (semua tambah)
        'total_penambahan' =>
                ($rekap['1']['tambah_koreksi'] ?? 0)
                + ($rekap['1']['tambah_barang'] ?? 0)
                + ($rekap['1']['tambah_belanja'] ?? 0)
                + ($rekap['1']['tambah_hibah'] ?? 0),

        // TOTAL PENGURANGAN
        'total_pengurangan' =>
            $rekap->sum('kurang_koreksi')
            + $rekap->sum('kurang_hibah')
            + $rekap->sum('kurang_reklas')
            + $rekap->sum('kurang_mutasi')
            + $rekap->sum('kurang_hapus')
            + $rekap->sum('kurang_lainnya'),

        // SALDO AKHIR
        'saldo_akhir' =>
            ($rekap['1']['saldo_awal'] ?? 0)

            + (
                ($rekap['1']['tambah_koreksi'] ?? 0)
                + ($rekap['1']['tambah_barang'] ?? 0)
                + ($rekap['1']['tambah_belanja'] ?? 0)
                + ($rekap['1']['tambah_hibah'] ?? 0)
                + ($rekap['1']['tambah_reklas'] ?? 0)
                + ($rekap['1']['tambah_mutasi'] ?? 0)
                + ($rekap['1']['tambah_lainnya'] ?? 0)
            )

            - (
                ($rekap['1']['kurang_koreksi'] ?? 0)
                + ($rekap['1']['kurang_hibah'] ?? 0)
                + ($rekap['1']['kurang_reklas'] ?? 0)
                + ($rekap['1']['kurang_mutasi'] ?? 0)
                + ($rekap['1']['kurang_hapus'] ?? 0)
                + ($rekap['1']['kurang_lainnya'] ?? 0)
            ),
    ];
}

    public function render()
    {
        $data = $this->getRekapData();

        $page = $this->getPage();
        $perPage = 10;

        $rekap = new LengthAwarePaginator(
            $data['rekap']->forPage($page, $perPage)->values(),
            $data['rekap']->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        return view('livewire.rekap.index', [
            'rekap' => $rekap,
            'namaDaerah' => $data['namaDaerah'],
        ]);
    }

    /**
     * ==========================================================
     * 📤 EXPORT EXCEL
     * ==========================================================
     */
    public function exportExcel()
    {
        $data = $this->getRekapData();

        return Excel::download(
            new RekapExport(
                $data['rekap']->values()->toArray(),
                $data['namaDaerah'],
                $this->tgl_lalu,
                $this->tgl_laporan
            ),
            'rekap-aset.xlsx'
        );
    }
}
