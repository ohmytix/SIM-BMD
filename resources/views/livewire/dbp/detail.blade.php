<div class="d-flex flex-column p-3"
    style="background: linear-gradient(180deg, #00bcd4 0%, #00acc1 100%); min-height: 100vh; max-width: 100vw; overflow-x: hidden;">

    <div class="bg-white rounded p-4 shadow-sm mb-3 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold text-dark">Laporan Detail Aset & Penyusutan</h5>
            <small class="text-muted">
                Posisi Laporan Periode Awal: <span
                    class="fw-bold text-primary">{{ $carbonLalu->translatedFormat('d F Y') }}</span>
            </small>
            <br>
            <small class="text-muted">
                Posisi Laporan Periode Akhir: <span
                    class="fw-bold text-primary">{{ $carbonLaporan->translatedFormat('d F Y') }}</span>
            </small>
        </div>

        <a href="{{ route('AsetUtama.index') }}" class="btn btn-secondary btn-sm" wire:navigate>
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Index
        </a>
    </div>

    <div class="bg-white rounded p-4 shadow-sm d-flex flex-column" style="overflow: hidden;">

        <div class="d-flex justify-content-end mb-3 gap-3 align-items-center">
            <button wire:click="exportExcel" wire:loading.attr="disabled" class="btn btn-success btn-sm">

                <span wire:loading.remove target="exportExcel">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                </span>

                <span wire:loading target="exportExcel">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Sedang Memproses...
                </span>

            </button>
            <div class="d-flex gap-3 align-items-center bg-light p-2 rounded border">

                <div class="d-flex align-items-center">
                    <label class="me-2 small fw-bold text-secondary">Periode Awal:</label>
                    <input type="date" class="form-control form-control-sm border-warning" wire:model.live="tgl_lalu"
                        style="width: 130px;" title="Mengubah kolom sebelah kiri">
                </div>

                <span class="text-muted fw-bold">s/d</span>

                <div class="d-flex align-items-center">
                    <label class="me-2 small fw-bold text-primary">Periode Akhir:</label>
                    <input type="date" class="form-control form-control-sm border-primary"
                        wire:model.live="tgl_laporan" style="width: 130px;"
                        title="Mengubah kolom sebelah kanan (misal: 06-2025)">
                </div>
                <div class="w-25">
                    <input type="text" class="form-control form-control-sm" placeholder="Cari Kode / Nama Barang..."
                        wire:model.live.debounce.300ms="search">
                </div>
            </div>


        </div>

        <div class="table-responsive border rounded custom-scrollbar" style="overflow-x: auto; width: 100%;">

            <table class="table table-bordered table-striped table-hover mb-0 align-middle"
                style="font-size: 11px; white-space: nowrap; width: max-content;">

                <thead class="table-light text-center fw-bold" style="position: sticky; top: 0; z-index: 10;">
                    <tr class="align-middle">
                        <th rowspan="3" class="bg-light" style="position: sticky; left: 0; z-index: 20;">NO</th>
                        <th rowspan="3" class="bg-light" style="position: sticky; left: 40px; z-index: 20;">Kode</th>
                        <th rowspan="3" style="min-width: 200px;">Sub Sub Rincian Objek</th>
                        <th rowspan="3">Spesifikasi</th>
                        <th rowspan="3">Spesifikasi Lainnya</th>
                        <th rowspan="3">Dokumen</th>
                        <th rowspan="3">Cara Perolehan</th>
                        <th rowspan="3">Tgl Perolehan</th>
                        <th rowspan="3">Ukuran</th>
                        <th rowspan="3">Satuan</th>
                        <th rowspan="3">Kondisi</th>
                        <th rowspan="3">Harga Perolehan</th>
                        <th rowspan="3">Akumulasi Penyusutan</th>
                        <th rowspan="3">Nilai Buku</th>
                        <th rowspan="3">Keterangan</th>

                        <th colspan="16" class="bg-primary text-white bg-opacity-75">HARGA PEROLEHAN</th>
                        <th colspan="6" class="bg-success text-white bg-opacity-75">UMUR BARANG S.D</th>
                        <th rowspan="3">Kode Akm. Peny.</th>
                        <th colspan="17" class="bg-warning text-dark bg-opacity-25">AKUMULASI PENYUSUTAN</th>
                        <th colspan="4" class="bg-danger text-white bg-opacity-75">MUTASI</th>
                    </tr>

                    <tr class="align-middle">
                        <th colspan="8" class="bg-light">Penambahan</th>
                        <th colspan="7" class="bg-light">Pengurangan</th>
                        <th rowspan="2" class="bg-primary text-white bg-opacity-50">Harga Perolehan Akhir</th>

                        <th rowspan="2">Harga Barang</th>
                        <th rowspan="2">Umur Eko.</th>

                        <th rowspan="2" class="bg-warning bg-opacity-10 text-dark">
                            {{ $carbonLalu->format('d-m-Y') }}
                        </th>

                        <th rowspan="2" class="bg-primary bg-opacity-10 text-dark">
                            {{ $carbonLaporan->format('d-m-Y') }}
                        </th>

                        <th rowspan="2">Sisa Umur</th>
                        <th rowspan="2">Penyusutan / Bln</th>

                        <th colspan="9" class="bg-light">Penambahan</th>
                        <th colspan="7" class="bg-light">Pengurangan</th>
                        <th rowspan="2" class="bg-warning text-dark bg-opacity-50">Akm. Penyusutan Akhir</th>

                        <th rowspan="2">Tgl Mutasi</th>
                        <th rowspan="2">Umur s.d Mutasi</th>
                        <th rowspan="2">Beban Mutasi</th>
                        <th rowspan="2">AKM Mutasi</th>
                    </tr>

                    <tr class="align-middle text-secondary" style="font-size: 10px;">
                        <th>Saldo Awal</th>
                        <th>Koreksi Saldo</th>
                        <th>Belanja</th>
                        <th>Hibah</th>
                        <th>Mutasi</th>
                        <th>Reklas</th>
                        <th>Lainnya</th>
                        <th class="fw-bold text-dark">Total Tambah</th>

                        <th>Koreksi Saldo</th>
                        <th>Hibah</th>
                        <th>Mutasi</th>
                        <th>Reklas</th>
                        <th>Hapus</th>
                        <th>Lainnya</th>
                        <th class="fw-bold text-dark">Total Kurang</th>

                        <th>Saldo Awal</th>
                        <th>Koreksi Saldo</th>
                        <th>Brg Lama</th>
                        <th>Belanja</th>
                        <th>Hibah</th>
                        <th>Mutasi</th>
                        <th>Reklas</th>
                        <th>Lainnya</th>
                        <th class="fw-bold text-dark">Total Tambah</th>

                        <th>Koreksi Saldo</th>
                        <th>Hibah</th>
                        <th>Mutasi</th>
                        <th>Reklas</th>
                        <th>Hapus</th>
                        <th>Lainnya</th>
                        <th class="fw-bold text-dark">Total Kurang</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($AsetUtama as $index => $aset)
                        <tr wire:key="{{ $aset->id }}">
                            <td class="text-center bg-white" style="position: sticky; left: 0; z-index: 5;">
                                {{ $AsetUtama->firstItem() + $index }}
                            </td>
                            <td class="bg-white" style="position: sticky; left: 40px; z-index: 5;">
                                <span
                                    class="badge bg-light text-dark border">{{ $aset->kodeBarang->kode ?? '-' }}</span>
                            </td>

                            <td class="text-wrap" style="min-width: 200px;">{{ $aset->kodeBarang->sub_sub_rincang ?? '-' }}</td>
                            <td>{{ $aset->spesifikasi }}</td>
                            <td>{{ $aset->spesifikasi_lainnya }}</td>
                            <td>{{ $aset->dokumen }}</td>
                            <td>{{ $aset->cara_perolehan }}</td>
                            <td class="text-center">
                                {{ $aset->tanggal_perolehan ? date('d-m-Y', strtotime($aset->tanggal_perolehan)) : '-' }}
                            </td>
                            <td class="text-center">{{ $aset->ukuran_barang }}</td>
                            <td class="text-center">{{ $aset->satuan_barang }}</td>
                            <td class="text-center">{{ $aset->kondisi_barang }}</td>

                            <td class="text-end fw-bold">
                                {{ number_format($aset->harga_perolehan_akhir ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end text-danger">
                                {{ number_format($aset->akumulasi_penyusutan_akhir ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end fw-bold text-primary">
                                {{ number_format($aset->nilai_buku ?? 0, 2, ',', '.') }}</td>
                            <td>{{ $aset->keterangan }}</td>

                            <td class="text-end text-muted">
                                {{ number_format($aset->PerolehanPenambahan->saldo_awal ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end text-muted">
                                {{ number_format($aset->PerolehanPenambahan->koreksi_saldo_awal ?? 0, 2, ',', '.') }}
                            </td>
                            <td class="text-end">
                                {{ number_format($aset->PerolehanPenambahan->belanja ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PerolehanPenambahan->hibah ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PerolehanPenambahan->mutasi ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PerolehanPenambahan->reklasifikasi ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PerolehanPenambahan->lainnya ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end fw-bold bg-light">
                                {{ number_format($aset->total_perolehan_penambahan ?? 0, 2, ',', '.') }}</td>

                            <td class="text-end text-muted">
                                {{ number_format($aset->PerolehanPengurangan->koreksi_saldo_awal ?? 0, 2, ',', '.') }}
                            </td>
                            <td class="text-end">
                                {{ number_format($aset->PerolehanPengurangan->hibah ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PerolehanPengurangan->mutasi ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PerolehanPengurangan->reklasifikasi ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PerolehanPengurangan->penghapusan ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PerolehanPengurangan->lainnya ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end fw-bold bg-light">
                                {{ number_format($aset->total_perolehan_pengurangan ?? 0, 2, ',', '.') }}</td>

                            <td class="text-end fw-bold bg-primary bg-opacity-10">
                                {{ number_format($aset->harga_perolehan_akhir ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($aset->harga_barang ?? 0, 2, ',', '.') }}</td>
                            <td class="text-center">{{ $aset->umur_ekonomis_bulan }}</td>
                            <td class="text-center">{{ $aset->umur_barang_2024 ?? 0 }}</td>
                            <td class="text-center">{{ $aset->umur_barang_2025 ?? 0 }}</td>
                            <td class="text-center fw-bold">{{ $aset->sisa_umur ?? 0 }}</td>
                            <td class="text-end">
                                {{ number_format($aset->nilai_penyusutan_per_bulan ?? 0, 2, ',', '.') }}</td>
                            <td class="text-center">{{ $aset->kodeBarang->kode_penyusutan ?? '-' }}</td>

                            <td class="text-end text-muted">
                                {{ number_format($aset->PenyusutanPenambahan->saldo_awal ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end text-muted">
                                {{ number_format($aset->PenyusutanPenambahan->koreksi_saldo_awal ?? 0, 2, ',', '.') }}
                            </td>
                            <td class="text-end">{{ number_format($aset->barang_lama ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($aset->belanja ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PenyusutanPenambahan->hibah ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PenyusutanPenambahan->mutasi ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PenyusutanPenambahan->reklasifikasi ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PenyusutanPenambahan->lainnya ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end fw-bold bg-light">
                                {{ number_format($aset->total_penyusutan_penambahan ?? 0, 2, ',', '.') }}</td>

                            <td class="text-end text-muted">
                                {{ number_format($aset->PenyusutanPengurangan->koreksi_saldo_awal ?? 0, 2, ',', '.') }}
                            </td>
                            <td class="text-end">
                                {{ number_format($aset->PenyusutanPengurangan->hibah ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PenyusutanPengurangan->mutasi ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PenyusutanPengurangan->reklasifikasi ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PenyusutanPengurangan->penghapusan ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($aset->PenyusutanPengurangan->lainnya ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end fw-bold bg-light">
                                {{ number_format($aset->total_penyusutan_pengurangan ?? 0, 2, ',', '.') }}</td>

                            <td class="text-end fw-bold bg-warning bg-opacity-10">
                                {{ number_format($aset->akumulasi_penyusutan_akhir ?? 0, 2, ',', '.') }}</td>
                            <td class="text-center">
                                {{ $aset->Mutasi && $aset->Mutasi->tanggal_mutasi ? date('d-m-Y', strtotime($aset->Mutasi->tanggal_mutasi)) : '-' }}
                            </td>
                            <td class="text-center">{{ number_format($aset->umur_sd_mutasi ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($aset->beban_mutasi ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($aset->akm_mutasi ?? 0, 2, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="60" class="text-center py-5 text-muted">
                                Data tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $AsetUtama->links() }}
        </div>
    </div>
</div>
