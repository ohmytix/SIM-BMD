    <div class="flex-grow-1 p-3" style="background: linear-gradient(180deg, #00bcd4 0%, #00acc1 100%);">

        <div class="bg-white rounded p-4 shadow-sm mb-3">
            <h5 class="mb-4" style="font-size: 20px; font-weight: 600; color: #000;">
                SKPD {{ $namaDaerah }}
            </h5>
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
        <div class="bg-white rounded p-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('AsetUtama.create') }}" class="btn btn-primary" wire:navigate>
                        <i class="bi bi-plus-circle me-1"></i> Tambah Data
                    </a>
                    <a href="{{ route('AsetUtama.detail') }}" class="btn btn-primary" wire:navigate>
                        <i class="bi bi-plus-circle me-1"></i> Detail
                    </a>
                </div>
                <div class="w-25">
                    <input type="text" class="form-control" placeholder="Cari data..."
                        wire:model.live.debounce.300ms="search">
                </div>
            </div>
            <div class="table-responsive" style="overflow-x: auto; max-width: 100%;">
                <table class="table table-bordered table-hover mb-0"
                    style="font-size: 13px; width: max-content; min-width: 100%;">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="text-center align-middle" rowspan="3">NO</th>
                            <th class="text-center align-middle" rowspan="3">Kode Barang</th>
                            <th class="text-center align-middle" rowspan="3">Sub Sub Rincian Objek</th>
                            <th class="text-center align-middle" rowspan="3">Cara Perolehan</th>
                            <th class="text-center align-middle" rowspan="3">Tanggal Perolehan</th>
                            <th class="text-center align-middle" rowspan="3">Kondisi Barang</th>
                            <th class="text-center align-middle" colspan="2">Harga Perolehan</th>
                            <th class="text-center align-middle" colspan="2">Akumulasi Penyusutan</th>
                            <th class="text-center align-middle" rowspan="3">Tanggal Mutasi</th>
                            <th class="text-center align-middle" rowspan="3">Aksi Perolehan</th>
                            <th class="text-center align-middle" rowspan="3">Aksi Penyusutan</th>
                            <th class="text-center align-middle" rowspan="3">Aksi Mutasi</th>
                            <th class="text-center align-middle" rowspan="3">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Penambahan</th>
                            <th class="text-center align-middle">Pengurangan</th>
                            <th class="text-center align-middle">Penambahan</th>
                            <th class="text-center align-middle">Pengurangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($AsetUtama as $index => $aset)
                            <tr wire:key="{{ $aset->id }}">
                                <td class="text-center">{{ $AsetUtama->firstItem() + $index }}</td>
                                <td>{{ $aset->kodeBarang->kode ?? '-' }}</td>
                                <td>{{ $aset->kodeBarang->sub_sub_rincang ?? '-' }}</td>
                                <td>{{ $aset->cara_perolehan }}</td>
                                <td>{{ $aset->tanggal_perolehan ? date('d-m-Y', strtotime($aset->tanggal_perolehan)) : '-' }}</td>
                                <td>{{ $aset->kondisi_barang }}</td>
                                <td class="text-end">
                                    {{ number_format($aset->total_perolehan_penambahan ?? 0, 2, ',', '.') }}</td>
                                <td class="text-end">
                                    {{ number_format($aset->total_perolehan_pengurangan ?? 0, 2, ',', '.') }}</td>
                                <td class="text-end">
                                    {{ number_format($aset->total_penyusutan_penambahan ?? 0, 2, ',', '.') }}</td>
                                <td class="text-end">
                                    {{ number_format($aset->total_penyusutan_pengurangan ?? 0, 2, ',', '.') }}</td>
                                <td class="text-center">
                                    {{ $aset->Mutasi && $aset->Mutasi->tanggal_mutasi ? date('d-m-Y', strtotime($aset->Mutasi->tanggal_mutasi)) : '-' }}
                                </td>
                                <td class="text-center">
                                    @if ($aset->PerolehanPenambahan)
                                        <a href="{{ route('PerolehanPenambahan.edit', $aset->PerolehanPenambahan->id) }}"
                                            class="btn btn-success btn-sm" title="Edit Penambahan" wire:navigate>
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('PerolehanPenambahan.create', ['aset_utama_id' => $aset->id]) }}"
                                            class="btn btn-success btn-sm" title="Tambah Penambahan" wire:navigate>
                                            <i class="bi bi-plus-circle"></i>
                                        </a>
                                    @endif
                                    @if ($aset->PerolehanPengurangan)
                                        <a href="{{ route('PerolehanPengurangan.edit', $aset->PerolehanPengurangan->id) }}"
                                            class="btn btn-danger btn-sm" title="Edit Pengurangan" wire:navigate>
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('PerolehanPengurangan.create', ['aset_utama_id' => $aset->id]) }}"
                                            class="btn btn-danger btn-sm" title="Tambah Pengurangan" wire:navigate>
                                            <i class="bi bi-dash"></i>
                                        </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($aset->PenyusutanPenambahan)
                                        <a href="{{ route('PenyusutanPenambahan.edit', $aset->PenyusutanPenambahan->id) }}"
                                            class="btn btn-success btn-sm" title="Edit Penambahan" wire:navigate>
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('PenyusutanPenambahan.create', ['aset_utama_id' => $aset->id]) }}"
                                            class="btn btn-success btn-sm" title="Tambah Penambahan" wire:navigate>
                                            <i class="bi bi-plus-circle"></i>
                                        </a>
                                    @endif
                                    @if ($aset->PenyusutanPengurangan)
                                        <a href="{{ route('PenyusutanPengurangan.edit', $aset->PenyusutanPengurangan->id) }}"
                                            class="btn btn-danger btn-sm" title="Edit Pengurangan" wire:navigate>
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('PenyusutanPengurangan.create', ['aset_utama_id' => $aset->id]) }}"
                                            class="btn btn-danger btn-sm" title="Tambah Pengurangan" wire:navigate>
                                            <i class="bi bi-dash"></i>
                                        </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($aset->Mutasi)
                                        <button class="btn btn-warning btn-sm"
                                            wire:click="openMutasiModal({{ $aset->id }})" title="Edit Mutasi">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <button class="btn btn-danger btn-sm"
                                            wire:click="deleteMutasiTrigger({{ $aset->Mutasi->id }})"
                                            title="Hapus Mutasi">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-success btn-sm"
                                            wire:click="openMutasiModal({{ $aset->id }})" title="Tambah Mutasi">
                                            <i class="bi bi-plus-circle"></i>
                                        </button>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a class="btn btn-warning btn-sm"
                                            href="{{ route('AsetUtama.edit', $aset->id) }}" title="Edit"
                                            wire:navigate>
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <button class="btn btn-danger btn-sm"
                                            wire:click="deleteAsetTrigger({{ $aset->id }})" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="text-center py-4">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $AsetUtama->links() }}
            </div>
        </div>
        <div class="modal fade" id="mutasiModal" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $mutasi_id ? 'Edit Data Mutasi' : 'Input Data Mutasi' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Mutasi</label>
                                <input type="date" class="form-control" wire:model="mutasi_tanggal">
                                @error('mutasi_tanggal')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                            <button type="button" class="btn btn-primary" wire:click="saveMutasi"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove>Simpan</span>
                                <span wire:loading>Menyimpan...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @script
            <script>
                Livewire.on('show-mutasi-modal', () => {
                    const myModalEl = document.getElementById('mutasiModal');
                    const modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
                    modal.show();
                });
                Livewire.on('hide-mutasi-modal', () => {
                    const myModalEl = document.getElementById('mutasiModal');
                    const modal = bootstrap.Modal.getOrCreateInstance(myModalEl);

                    modal.hide();
                });
                document.getElementById('mutasiModal').addEventListener('hidden.bs.modal', event => {})
            </script>
        @endscript

    </div>
    </div>
