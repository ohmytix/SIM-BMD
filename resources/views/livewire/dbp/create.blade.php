<div class="d-flex flex-column p-3"
    style="background: linear-gradient(180deg, #00bcd4 0%, #00acc1 100%); min-height: 100vh;">

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <div class="bg-white rounded p-4 shadow-sm mb-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">Tambah Aset Utama</h5>
                <a href="{{ route('AsetUtama.index') }}" class="btn btn-secondary btn-sm" wire:navigate>
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form wire:submit="store">
                        <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                        <div class="flex-grow-1">
                            <label class="fw-bold mb-1">Jumlah Barang yang Ingin Diinput</label>
                            <div class="input-group" style="max-width: 200px;">
                                <input type="number" class="form-control fw-bold text-center" wire:model="jumlah_input"
                                    min="1" max="50">
                                <span class="input-group-text">Unit</span>
                            </div>
                            <small class="text-muted d-block mt-1">
                                Biarkan <b>1</b> jika hanya input satuan. Isi <b>5</b> jika ingin input 5 barang identik
                                sekaligus.
                            </small>
                        </div>
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-bold">Kode Barang</label>

                            @if ($kode_barang_id)
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light fw-bold text-success" 
                                           value="{{ $selectedKodeDisplay }}" readonly>
                                    <button class="btn btn-danger" type="button" wire:click="resetKode">
                                        <i class="bi bi-x-lg"></i> Ganti
                                    </button>
                                </div>
                                @else
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control" 
                                           placeholder="Ketik Kode atau Nama Barang..."
                                           wire:model.live.debounce.300ms="searchKode">
                                </div>

                                @if (!empty($searchKode) && count($hasilPencarian) > 0)
                                    <ul class="list-group position-absolute w-100 shadow-lg" 
                                        style="z-index: 1000; max-height: 250px; overflow-y: auto; top: 75px;">
                                        
                                        @foreach ($hasilPencarian as $item)
                                            <li class="list-group-item list-group-item-action cursor-pointer" 
                                                style="cursor: pointer;"
                                                wire:click="selectKode({{ $item->id }}, '{{ $item->kode }}', '{{ $item->sub_sub_rincang ?? $item->sub_sub_rincian_objek }}')">
                                                <div class="fw-bold">{{ $item->kode }}</div>
                                                <small class="text-muted">{{ $item->sub_sub_rincang ?? $item->sub_sub_rincian_objek }}</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                @elseif (!empty($searchKode))
                                    <ul class="list-group position-absolute w-100 shadow" style="z-index: 1000; top: 75px;">
                                        <li class="list-group-item text-center text-muted">Data tidak ditemukan.</li>
                                    </ul>
                                @endif
                            @endif

                            @error('kode_barang_id')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Spesifikasi</label>
                                <textarea class="form-control @error('spesifikasi') is-invalid @enderror" wire:model="spesifikasi" rows="3"></textarea>
                                @error('spesifikasi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Spesifikasi Lainnya</label>
                                <textarea class="form-control @error('spesifikasi_lainnya') is-invalid @enderror" wire:model="spesifikasi_lainnya"
                                    rows="3"></textarea>
                                @error('spesifikasi_lainnya')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Dokumen (Nama File/Path)</label>
                            <input type="text" class="form-control @error('dokumen') is-invalid @enderror"
                                wire:model="dokumen">
                            @error('dokumen')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Cara Perolehan</label>
                                <select class="form-select @error('cara_perolehan') is-invalid @enderror"
                                    wire:model="cara_perolehan">
                                    <option value="">Pilih Cara Perolehan</option>
                                    <option value="Pembelian">Pembelian</option>
                                    <option value="Pengadaan">Pengadaan</option>
                                    <option value="Sewa">Sewa</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('cara_perolehan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Perolehan</label>
                                <input type="date"
                                    class="form-control @error('tanggal_perolehan') is-invalid @enderror"
                                    wire:model="tanggal_perolehan">
                                @error('tanggal_perolehan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Ukuran Barang</label>
                                <input type="text" class="form-control @error('ukuran_barang') is-invalid @enderror"
                                    wire:model="ukuran_barang">
                                @error('ukuran_barang')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Satuan Barang</label>
                                <input type="text" class="form-control @error('satuan_barang') is-invalid @enderror"
                                    wire:model="satuan_barang">
                                @error('satuan_barang')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Kondisi Barang</label>
                                <select class="form-select @error('kondisi_barang') is-invalid @enderror"
                                    wire:model="kondisi_barang">
                                    <option value="">Pilih Kondisi</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                                @error('kondisi_barang')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>Simpan Data Aset</span>
                                <span wire:loading><i class="bi bi-arrow-repeat spin"></i> Menyimpan...</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
