<div class="d-flex flex-column p-3" 
     style="background: linear-gradient(180deg, #00bcd4 0%, #00acc1 100%); min-height: 100vh;">

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            
            <div class="bg-white rounded p-4 shadow-sm mb-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">Edit Aset Utama</h5>
                <a href="{{ route('AsetUtama.index') }}" class="btn btn-secondary btn-sm" wire:navigate>
                    <i class="bi bi-arrow-left me-1"></i> Batal
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    
                    <form wire:submit="update">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kode Barang</label>
                            <select class="form-select @error('kode_barang') is-invalid @enderror" wire:model="kode_barang">
                                <option value="">Pilih Kode Barang</option>
                                @foreach ($kodeBarangs as $kode)
                                    <option value="{{ $kode->kode }}">
                                        {{ $kode->kode }} - {{ $kode->sub_sub_rincang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kode_barang') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Spesifikasi</label>
                                <textarea class="form-control @error('spesifikasi') is-invalid @enderror" 
                                    wire:model="spesifikasi" rows="3"></textarea>
                                @error('spesifikasi') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Spesifikasi Lainnya</label>
                                <textarea class="form-control @error('spesifikasi_lainnya') is-invalid @enderror" 
                                    wire:model="spesifikasi_lainnya" rows="3"></textarea>
                                @error('spesifikasi_lainnya') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Dokumen (Nama File/Path)</label>
                            <input type="text" class="form-control @error('dokumen') is-invalid @enderror" 
                                wire:model="dokumen">
                            @error('dokumen') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Cara Perolehan</label>
                                <select class="form-select @error('cara_perolehan') is-invalid @enderror" wire:model="cara_perolehan">
                                    <option value="">Pilih Cara Perolehan</option>
                                    <option value="Pembelian">Pembelian</option>
                                    <option value="Hibah">Hibah</option> <option value="Pengadaan">Pengadaan</option>
                                    <option value="Sewa">Sewa</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('cara_perolehan') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Perolehan</label>
                                <input type="date" class="form-control @error('tanggal_perolehan') is-invalid @enderror"
                                    wire:model="tanggal_perolehan">
                                @error('tanggal_perolehan') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Ukuran Barang</label>
                                <input type="text" class="form-control @error('ukuran_barang') is-invalid @enderror" 
                                    wire:model="ukuran_barang">
                                @error('ukuran_barang') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Satuan Barang</label>
                                <input type="text" class="form-control @error('satuan_barang') is-invalid @enderror" 
                                    wire:model="satuan_barang">
                                @error('satuan_barang') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Kondisi Barang</label>
                                <select class="form-select @error('kondisi_barang') is-invalid @enderror" wire:model="kondisi_barang">
                                    <option value="">Pilih Kondisi</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                                @error('kondisi_barang') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-warning text-white" wire:loading.attr="disabled">
                                <span wire:loading.remove>Update Data</span>
                                <span wire:loading><i class="bi bi-arrow-repeat spin"></i> Menyimpan...</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>