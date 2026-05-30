<div class="flex-grow-1 p-3" style="background: linear-gradient(180deg, #00bcd4 0%, #00acc1 100%);">
    <!-- Card Section with Title and Stats -->
    <div class="bg-white rounded p-4 shadow-sm mb-3">
        <!-- Title -->
        <h5 class="mb-4" style="font-size: 20px; font-weight: 600; color: #000;">Mutasi Persediaan {{ $namaDaerah }}</h5>

        <!-- Stats Cards -->
        <div class="row g-3">
            <div class="col-lg-3 col-md-6">
                <div class="rounded p-3" style="background: linear-gradient(135deg, #80deea 0%, #4dd0e1 100%);">
                    <div style="font-size: 14px; color: #555; margin-bottom: 8px;">Saldo Awal</div>
                    <div style="font-size: 18px; font-weight: 700; color: #000;">{{ number_format($summary['saldo_awal']) }}</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="rounded p-3" style="background: linear-gradient(135deg, #f8bbd0 0%, #f48fb1 100%);">
                    <div style="font-size: 14px; color: #555; margin-bottom: 8px;">Total Penambahan</div>
                    <div style="font-size: 18px; font-weight: 700; color: #000;">{{ number_format($summary['total_penambahan']) }}</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="rounded p-3" style="background: linear-gradient(135deg, #fff59d 0%, #ffee58 100%);">
                    <div style="font-size: 14px; color: #555; margin-bottom: 8px;">Total Pengurangan</div>
                    <div style="font-size: 18px; font-weight: 700; color: #000;">Rp 7.632.083</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="rounded p-3" style="background: linear-gradient(135deg, #ce93d8 0%, #ba68c8 100%);">
                    <div style="font-size: 14px; color: #555; margin-bottom: 8px;">Saldo Akhir</div>
                    <div style="font-size: 18px; font-weight: 700; color: #000;">Rp 7.632.083</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= TABLE ================= --}}

    <div class="bg-white rounded p-4 shadow-sm">
        <div class="mb-3">
            <div class="d-flex gap-3 align-items-center bg-light p-2 rounded border">
                <button
                    wire:click="exportExcel"
                    class="btn btn-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </button>

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
                <div class="w-50">
                    <input type="text" class="form-control form-control-sm" placeholder="Cari Data..."
                        wire:model.live.debounce.300ms="search">
                </div>
            </div>
        </div>
            @if (count($mutasiAset) == 0)
            <tr>
                <td colspan="18" class="text-center text-muted">
                    Data tidak ditemukan
                </td>
            </tr>
            @endif
            <div class="table-responsive" style="overflow-x:auto; max-width:100%;">
                <table class="table table-bordered table-hover mb-0" style="border: 1px solid #000 !important; font-size: 13px; white-space: nowrap;">
                    <thead class="table-light align-middle text-center"
                        style="border: 1px solid #000 !important; position: sticky; top: 0; z-index: 10;">
                        <tr class="small">
                            <th rowspan="2" class="text-center align-middle bg-card-5" style="width: 250px;">Akun Neraca</th>
                            <th rowspan="2" class="text-center align-middle bg-card-3" style="width: 150px;">Saldo Awal Audited</th>
                            <th class="text-center align-middle" style="width: 150px; background-color: #92D050;" colspan="7">Mutasi Penambahan</th>
                            <th class="text-center align-middle" style="width: 150px; background-color: #92D050;" rowspan="2">Total Penambahan</th>
                            <th class="text-center align-middle" style="width: 150px; background-color: #95B3D7;" colspan="6">Mutasi Pengurangan</th>
                            <th class="text-center align-middle" style="width: 150px; background-color: #95B3D7;" rowspan="2">Total Pengurangan</th>
                            <th class="text-center align-middle" style="width: 150px; background-color: #E6B8B7;" rowspan="2">Saldo Akhir</th>
                        </tr>

                        <tr class="align-middle small">
                            <th class="text-center align-middle" style="width: 120px; ">Koreksi</th>
                            <th class="text-center align-middle" style="width: 120px; ">BMD Sebelum 2025</th>
                            <th class="text-center align-middle" style="width: 120px; ">Realisasi Belanja 2025</th>
                            <th class="text-center align-middle" style="width: 120px; ">Hibah</th>
                            <th class="text-center align-middle" style="width: 120px; ">Mutasi</th>
                            <th class="text-center align-middle" style="width: 120px; ">Reklasifikasi</th>
                            <th class="text-center align-middle" style="width: 120px; ">Lainnya</th>

                            <th class="text-center align-middle" style="width: 120px;">Koreksi</th>
                            <th class="text-center align-middle" style="width: 120px;">Hibah</th>
                            <th class="text-center align-middle" style="width: 120px;">Mutasi</th>
                            <th class="text-center align-middle" style="width: 120px;">Reklasifikasi</th>
                            <th class="text-center align-middle" style="width: 120px;">Penghapusan</th>
                            <th class="text-center align-middle" style="width: 120px;">Lainnya</th>
                        </tr>
                    </thead>

                    <tbody class="small">
                        @forelse ($mutasiAset as $i => $item)
                            <tr>
                                <td>{{ $item['uraian'] }}</td>
                            
                                <td class="text-center fw-bold">
                                    {{ number_format($item['saldo_awal'], 2, ',', '.') }}
                                </td>

                                <td class="text-end">
                                    {{ number_format($item['tambah_koreksi'], 2, ',', '.') }}
                                </td>
                                <td class="text-end">{{ number_format($item['tambah_barang'], 2, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['tambah_belanja'], 2, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['tambah_hibah'], 2, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['tambah_mutasi'], 2, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['tambah_reklas'], 2, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['tambah_lainnya'], 2, ',', '.') }}</td>
                                <td class="text-end fw-bold">{{ number_format($item['total_penambahan'], 2, ',', '.') }}</td>
                                
                                <td class="text-end">{{ number_format($item['kurang_koreksi'], 2, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['kurang_hibah'], 2, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['kurang_mutasi'], 2, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['kurang_reklas'], 2, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['kurang_hapus'], 2, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['kurang_lainnya'], 2, ',', '.') }}</td>
                                <td class="text-end fw-bold">{{ number_format($item['total_pengurangan'], 2, ',', '.') }}</td>
                                <td class="text-end fw-bold">{{ number_format($item['saldo_akhir'], 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="18" class="text-center text-muted">
                                    Data mutasi tidak tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
