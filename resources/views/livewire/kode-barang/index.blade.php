<div class="flex-grow-1 p-3" style="background: linear-gradient(180deg, #00bcd4 0%, #00acc1 100%);">

    <div class="bg-white rounded p-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex gap-2">
                 <a href="{{ route('KodeBarang.create') }}" class="btn btn-primary" wire:navigate>
                <i class="bi bi-plus-circle me-1"></i> Tambah Kode Barang
            </a>

            </div>
            <div class="w-25">
                <input type="text" class="form-control form-control-sm" placeholder="Cari Kode / Nama..."
                    wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="table-responsive" style="overflow-x: auto; max-width: 100%; max-height: 65vh; overflow-y: auto;">
            <table class="table table-bordered table-striped table-hover mb-0 align-middle text-nowrap"
                style="font-size: 13px;">
                <thead class="table-light text-center fw-bold align-middle">
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Sub Sub Rincian</th>
                        <th>Sub Rincian</th>
                        <th>Rincian</th>
                        <th>Objek</th>
                        <th>Jenis</th>
                        <th>Kelompok</th>
                        <th>Akun</th>
                        <th>Kd. Peny.</th>
                        <th>Usia</th>
                        <th>A0-5</th>
                        <th>A>5-10</th>
                        <th>A>10-20</th>
                        <th>A>20-25</th>
                        <th>A>25-30</th>
                        <th>A>30-40</th>
                        <th>A>40-45</th>
                        <th>A>45-50</th>
                        <th>A>50-65</th>
                        <th>A>65-75</th>
                        <th>A>75</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tabel_kodebarang as $index => $item)
                        <tr wire:key="{{ $item->id }}">
                            <td class="text-center">{{ $tabel_kodebarang->firstItem() + $index }}</td>
                            <td class="fw-bold">{{ $item->kode }}</td>

                            <td>{{ $item->sub_sub_rincang ?? $item->sub_sub_rincian_objek }}</td>

                            <td>{{ $item->sub_rincang ?? $item->sub_rincian_objek }}</td>
                            <td>{{ $item->rincian_objek }}</td>
                            <td>{{ $item->objek }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->kelompok }}</td>
                            <td>{{ $item->akun }}</td>
                            <td class="text-center">{{ $item->kode_penyusutan }}</td>
                            <td class="text-center">{{ $item->usia_manfaat }} Thn</td>
                            <td class="text-center">{{ $item->a0_5 }}</td>
                            <td class="text-center">{{ $item->a5_10 }}</td>
                            <td class="text-center">{{ $item->a10_20 }}</td>
                            <td class="text-center">{{ $item->a20_25 }}</td>
                            <td class="text-center">{{ $item->a25_30 }}</td>
                            <td class="text-center">{{ $item->a30_40 }}</td>
                            <td class="text-center">{{ $item->a40_45 }}</td>
                            <td class="text-center">{{ $item->a45_50 }}</td>
                            <td class="text-center">{{ $item->a50_65 }}</td>
                            <td class="text-center">{{ $item->a65_75 }}</td>
                            <td class="text-center">{{ $item->a75 }}</td>
                            <td class="text-center">
                                <a href="{{ route('KodeBarang.edit', $item->id) }}" class="btn btn-warning btn-sm"
                                    wire:navigate title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button wire:click="deleteTrigger({{ $item->id }})" class="btn btn-danger btn-sm"
                                    title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Data tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $tabel_kodebarang->links() }}
        </div>
    </div>
</div>
</div>
