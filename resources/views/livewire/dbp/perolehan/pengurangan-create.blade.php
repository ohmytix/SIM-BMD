<div class="d-flex flex-column p-3" 
     style="background: linear-gradient(180deg, #00bcd4 0%, #00acc1 100%); min-height: 100vh;">

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            
            <div class="bg-white rounded p-4 shadow-sm mb-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">Tambah Mutasi Pengurangan (Perolehan)</h5>
                <a href="{{ route('AsetUtama.index') }}" class="btn btn-secondary btn-sm" wire:navigate>
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    
                    <form wire:submit="store">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Koreksi Saldo Awal</label>
                                <input type="number" class="form-control @error('koreksi_saldo_awal') is-invalid @enderror" 
                                       wire:model="koreksi_saldo_awal">
                                @error('koreksi_saldo_awal') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Hibah</label>
                                <input type="number" class="form-control @error('hibah') is-invalid @enderror" 
                                       wire:model="hibah">
                                @error('hibah') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mutasi</label>
                                <input type="number" class="form-control @error('mutasi') is-invalid @enderror" 
                                       wire:model="mutasi">
                                @error('mutasi') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Reklasifikasi</label>
                                <input type="number" class="form-control @error('reklasifikasi') is-invalid @enderror" 
                                       wire:model="reklasifikasi">
                                @error('reklasifikasi') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Penghapusan</label>
                                <input type="number" class="form-control @error('penghapusan') is-invalid @enderror" 
                                       wire:model="penghapusan">
                                @error('penghapusan') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Lainnya</label>
                                <input type="number" class="form-control @error('lainnya') is-invalid @enderror" 
                                       wire:model="lainnya">
                                @error('lainnya') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>Simpan Data</span>
                                <span wire:loading><i class="bi bi-arrow-repeat spin"></i> Menyimpan...</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>