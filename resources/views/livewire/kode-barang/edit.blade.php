<div class="d-flex flex-column p-3" 
     style="background: linear-gradient(180deg, #00bcd4 0%, #00acc1 100%); min-height: 100vh;">

    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="bg-white rounded p-4 shadow-sm mb-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">Edit Kode Barang</h5>
                <a href="{{ route('KodeBarang.index') }}" class="btn btn-secondary btn-sm" wire:navigate>
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form wire:submit="update">
                        
                        <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">Informasi Dasar</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror" wire:model="kode">
                                @error('kode') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-bold">Sub Sub Rincian <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('sub_sub_rincang') is-invalid @enderror" wire:model="sub_sub_rincang">
                                @error('sub_sub_rincang') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sub Rincian</label>
                                <input type="text" class="form-control" wire:model="sub_rincang">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rincian Objek</label>
                                <input type="text" class="form-control" wire:model="rincian_objek">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Objek</label>
                                <input type="text" class="form-control" wire:model="objek">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jenis</label>
                                <input type="text" class="form-control" wire:model="jenis">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kelompok</label>
                                <input type="text" class="form-control" wire:model="kelompok">
                            </div>
                        </div>

                        <h6 class="text-primary fw-bold mb-3 mt-4 border-bottom pb-2">Data Akuntansi & Penyusutan</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Akun <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="akun">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kode Penyusutan</label>
                                <input type="text" class="form-control" wire:model="kode_penyusutan">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Usia Manfaat (Tahun)</label>
                                <input type="number" class="form-control" wire:model="usia_manfaat">
                            </div>
                        </div>

                        <h6 class="text-primary fw-bold mb-3 mt-4 border-bottom pb-2">Detail Rentang Usia</h6>
                        <div class="row g-2">
                            <div class="col-md-2 col-6"><label class="small">0-5 Thn</label><input type="number" class="form-control form-control-sm" wire:model="a0_5"></div>
                            <div class="col-md-2 col-6"><label class="small">5-10 Thn</label><input type="number" class="form-control form-control-sm" wire:model="a5_10"></div>
                            <div class="col-md-2 col-6"><label class="small">10-20 Thn</label><input type="number" class="form-control form-control-sm" wire:model="a10_20"></div>
                            <div class="col-md-2 col-6"><label class="small">20-25 Thn</label><input type="number" class="form-control form-control-sm" wire:model="a20_25"></div>
                            <div class="col-md-2 col-6"><label class="small">25-30 Thn</label><input type="number" class="form-control form-control-sm" wire:model="a25_30"></div>
                            <div class="col-md-2 col-6"><label class="small">30-40 Thn</label><input type="number" class="form-control form-control-sm" wire:model="a30_40"></div>
                            <div class="col-md-2 col-6"><label class="small">40-45 Thn</label><input type="number" class="form-control form-control-sm" wire:model="a40_45"></div>
                            <div class="col-md-2 col-6"><label class="small">45-50 Thn</label><input type="number" class="form-control form-control-sm" wire:model="a45_50"></div>
                            <div class="col-md-2 col-6"><label class="small">50-65 Thn</label><input type="number" class="form-control form-control-sm" wire:model="a50_65"></div>
                            <div class="col-md-2 col-6"><label class="small">65-75 Thn</label><input type="number" class="form-control form-control-sm" wire:model="a65_75"></div>
                            <div class="col-md-2 col-6"><label class="small">> 75 Thn</label><input type="number" class="form-control form-control-sm" wire:model="a75"></div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" wire:model="keterangan" rows="2"></textarea>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>Simpan Data</span>
                                <span wire:loading>Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>