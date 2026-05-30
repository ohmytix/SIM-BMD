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
                    <div style="font-size: 18px; font-weight: 700; color: #000;">Rp 7.632.083</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="rounded p-3" style="background: linear-gradient(135deg, #f8bbd0 0%, #f48fb1 100%);">
                    <div style="font-size: 14px; color: #555; margin-bottom: 8px;">Total Penambahan</div>
                    <div style="font-size: 18px; font-weight: 700; color: #000;">Rp 7.632.083</div>
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


    {{-- TABLE --}}
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
                        <input type="text" class="form-control form-control-sm" placeholder="Cari Kode Barang / Uraian Aset"
                            wire:model.live.debounce.300ms="search">
                    </div>
                </div>
            </div>
            @if (count($rekap) == 0)
            <tr>
                <td colspan="18" class="text-center text-muted">
                    Data tidak ditemukan
                </td>
            </tr>
            @endif
        <div class="table-responsive" style="overflow-x: auto; max-width: 100%;">
            <table class="table table-bordered table-hover mb-0" style="border: 1px solid #000 !important;" >
                <thead class="table-light align-middle text-center" style="border: 1px solid #000 !important; position: sticky; top: 0; z-index: 10;">
                    <tr class="small">
                        <th rowspan="2" class="text-center align-middle" style="width: 250px;">No</th>
                        <th rowspan="2" class="text-center align-middle bg-card-5" style="width: 250px;">Kode Barang</th>
                        <th rowspan="2" class="text-center align-middle bg-card-3" style="width: 250px; white-space: nowrap;">Uraian</th>
                        <th colspan="2" class="text-center align-middle" style="width: 250px; background-color: #f87070ff;">Saldo Awal</th>
                        <th colspan="7" class="text-center align-middle" style="width: 250px; background-color: #95B3D7;">Penambahan</th>
                        <th rowspan="2" class="text-center align-middle" style="width: 250px; white-space: nowrap; background-color: #95B3D7;">Total Penambahan</th>
                        <th colspan="6" class="text-center align-middle" style="width: 250px; background-color: #b98b89ff;">Pengurangan</th>
                        <th rowspan="2" class="text-center align-middle" style="width: 250px; white-space: nowrap; background-color: #b98b89ff;">Total Pengurangan</th>
                        <th colspan="2" class="text-center align-middle" style="width: 250px; background-color: #f87070ff;">Saldo Akhir</th>
                    </tr>
                    <tr class="align-middle small">
                        <th class="text-center align-middle" style="width: 250px;">Jumlah</th>
                        <th class="text-center align-middle" style="width: 250px;">Perolehan</th>

                        <th class="text-center align-middle" style="width: 250px;">Koreksi</th>
                        <th class="text-center align-middle" style="width: 250px; white-space: nowrap;">Barang Lama</th>
                        <th class="text-center align-middle" style="width: 250px;">Belanja</th>
                        <th class="text-center align-middle" style="width: 250px;">Hibah</th>
                        <th class="text-center align-middle" style="width: 250px;">Reklas</th>
                        <th class="text-center align-middle" style="width: 250px;">Mutasi</th>
                        <th class="text-center align-middle" style="width: 250px;">Lainnya</th>

                        <th class="text-center align-middle" style="width: 250px;">Koreksi</th>
                        <th class="text-center align-middle" style="width: 250px;">Hibah</th>
                        <th class="text-center align-middle" style="width: 250px;">Reklas</th>
                        <th class="text-center align-middle" style="width: 250px;">Mutasi</th>
                        <th class="text-center align-middle" style="width: 250px;">Penghapusan</th>
                        <th class="text-center align-middle" style="width: 250px;">Lainnya</th>

                        <th class="text-center align-middle" style="width: 250px;">Perolehan</th>
                        <th class="text-center align-middle" style="width: 250px;">Jumlah</th>
                    </tr>
                </thead>

                <tbody class="small">
                    @forelse ($rekap as $i => $aset)
                        @php
                            $totalPenambahan =
                                $aset['tambah_koreksi'] +
                                $aset['tambah_barang'] +
                                $aset['tambah_belanja'] +
                                $aset['tambah_hibah'] +
                                $aset['tambah_reklas'] +
                                $aset['tambah_mutasi'] +
                                $aset['tambah_lainnya'];

                            $totalPengurangan =
                                $aset['kurang_koreksi'] +
                                $aset['kurang_hibah'] +
                                $aset['kurang_reklas'] +
                                $aset['kurang_mutasi'] +
                                $aset['kurang_hapus'] +
                                $aset['kurang_lainnya'];

                            $saldoAkhir = $aset['saldo_awal'] + $totalPenambahan - $totalPengurangan;
                        @endphp

                        <tr>
                            <td>{{ $rekap->firstItem() + $loop->index }}</td>
                            <td>{{ $aset['kode'] }}</td>
                            <td class="text-start " style="white-space: nowrap;">{{ $aset['uraian'] }}</td>

                            {{-- Saldo Awal --}}
                            <td>{{$aset['jumlah']}}</td>
                            <td>{{ number_format($aset['saldo_awal'], 2, ',', '.') }}</td>

                            {{-- Penambahan --}}
                            <td>{{ number_format($aset['tambah_koreksi'], 2, ',', '.') }}</td>
                            <td>{{ number_format($aset['tambah_barang'], 2, ',', '.') }}</td>
                            <td>{{ number_format($aset['tambah_belanja'], 2, ',', '.') }}</td>
                            <td>{{ number_format($aset['tambah_hibah'], 2, ',', '.') }}</td>
                            <td>{{ number_format($aset['tambah_reklas'], 2, ',', '.') }}</td>
                            <td>{{ number_format($aset['tambah_mutasi'], 2, ',', '.') }}</td>
                            <td>{{ number_format($aset['tambah_lainnya'], 2, ',', '.') }}</td>

                            <td class="fw-bold">
                                {{ number_format($totalPenambahan, 2, ',', '.') }}
                            </td>

                            {{-- Pengurangan --}}
                            <td>{{ number_format($aset['kurang_koreksi'], 2, ',', '.') }}</td>
                            <td>{{ number_format($aset['kurang_hibah'], 2, ',', '.') }}</td>
                            <td>{{ number_format($aset['kurang_reklas'], 2, ',', '.') }}</td>
                            <td>{{ number_format($aset['kurang_mutasi'], 2, ',', '.') }}</td>
                            <td>{{ number_format($aset['kurang_hapus'], 2, ',', '.') }}</td>
                            <td>{{ number_format($aset['kurang_lainnya'], 2, ',', '.') }}</td>

                            <td class="fw-bold">
                                {{ number_format($totalPengurangan, 2, ',', '.') }}
                            </td>

                            {{-- Saldo Akhir --}}
                            <td class="fw-bold">
                                {{ number_format($saldoAkhir, 2, ',', '.') }}
                            </td>
                            <td>{{$aset['jumlah']}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="22" class="text-center text-muted">
                                Data tidak tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
            <div class="mt-3 d-flex justify-content-end">
                {{ $rekap->links() }}
            </div>

        </div>
    </div>
</div>
