<div class="flex-grow-1 p-3" style="background: linear-gradient(180deg, #00bcd4 0%, #00acc1 100%);">
    <!-- Card Section with Title and Stats -->

    <!-- Table Section -->
    <div class="bg-white rounded p-4 shadow-sm">
        <!-- Button Tambah Data -->
        <div class="mb-3">
            <a href="{{ route('MutasiPersediaan.create') }}" class="btn btn-primary" wire:navigate>
                <i class="bi bi-plus-circle me-1"></i> Tambah Data
            </a>

            <input type="text" class="form-control w-25" placeholder="Cari Barang..." wire:model.live="search">
        </div>

        <!-- Table Wrapper dengan scroll horizontal -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0" style="font-size: 13px; white-space: nowrap;">
                <thead class="table-light align-middle text-center">
                    <tr>
                        <th class="text-center align-middle" style="width: 50px;" rowspan="2">NO</th>
                        <th class="text-center align-middle" style="width: 250px;" rowspan="2">JENIS PERSEDIAAN</th>
                        <th class="text-center align-middle" style="width: 150px;" rowspan="2">SALDO
                            AWAL<br>01-01-2025</th>
                        <th class="text-center align-middle" style="width: 360px;" colspan="3">PENAMBAHAN</th>
                        <th class="text-center align-middle" style="width: 360px;" colspan="3">PENGURANGAN</th>
                        <th class="text-center align-middle" style="width: 150px;" rowspan="2">SALDO
                            AKHIR<br>30-09-2025</th>
                        <th class="text-center align-middle" style="width: 200px;" rowspan="2">KETERANGAN</th>
                        <th class="text-center align-middle" style="width: 150px;" rowspan="2">AKSI</th>
                    </tr>
                    <tr>
                        <th class="text-center align-middle" style="width: 120px;">REALISASI</th>
                        <th class="text-center align-middle" style="width: 120px;">HIBAH</th>
                        <th class="text-center align-middle" style="width: 120px;">REKLASIFIKASI</th>
                        <th class="text-center align-middle" style="width: 120px;">PEMAKAIAN</th>
                        <th class="text-center align-middle" style="width: 120px;">HIBAH</th>
                        <th class="text-center align-middle" style="width: 120px;">REKLASIFIKASI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tabel_persediaan as $index => $persediaan)
                        <tr wire:key="{{ $persediaan->id }}">
                            <td class="text-center">{{ $tabel_persediaan->firstItem() + $index }}</td>

                            <td>{{ $persediaan->kategori_persediaan }} - {{ $persediaan->nama_barang }}</td>

                            <td class="text-end">{{ number_format($persediaan->saldo, 0, ',', '.') }}</td>

                            <td class="text-end">{{ number_format($persediaan->realisasi, 0, ',', '.') }}</td>

                            <td class="text-end">{{ number_format($persediaan->hibah_penambahan, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($persediaan->reklasifikasi_penambahan, 0, ',', '.') }}
                            </td>

                            <td class="text-end">{{ number_format($persediaan->pemakaian, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($persediaan->hibah_pengurangan, 0, ',', '.') }}</td>
                            <td class="text-end">
                                {{ number_format($persediaan->reklasifikasi_pengurangan, 0, ',', '.') }}</td>

                            <td class="text-end fw-bold" style="background-color: #e3f2fd;">
                                {{ number_format($persediaan->saldo_akhir_hitung ?? 0, 0, ',', '.') }}
                            </td>

                            <td>{{ $persediaan->keterangan }}</td>

                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center flex-nowrap">
                                    <a class="btn btn-warning btn-sm"
                                        href="{{ route('MutasiPersediaan.edit', $persediaan->id) }}" wire:navigate
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button wire:click="deleteTrigger({{ $persediaan->id }})"
                                        class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $tabel_persediaan->links() }}
        </div>
    </div>
</div>
