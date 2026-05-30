<div class="container-fluid main-content">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Input Data Persediaan Baru</h5>
                </div>
                <div class="card-body">

                    <form wire:submit="store">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori Persediaan</label>
                            <select class="form-select" wire:model="kategori_persediaan">
                                <option value="">Pilih Kategori</option>
                                <option value="belanja_bahan">Belanja Bahan</option>
                                <option value="belanja_alat">Belanja Alat</option>
                                <option value="belanja_persediaan">Belanja Persediaan Untuk Dijual</option>
                            </select>
                            @error('kategori_persediaan')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Barang</label>
                            <input type="text" class="form-control" wire:model="nama_barang"
                                placeholder="Masukkan nama barang">
                            @error('nama_barang')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Saldo Awal</label>
                            <input type="number" class="form-control" wire:model="saldo" placeholder="0">
                        </div>

                        <hr>

                        <details class="mb-3 border rounded shadow-sm">
                            <summary class="p-3 bg-light" style="cursor: pointer; font-weight: bold;">
                                ➕ Penambahan
                            </summary>
                            <div class="p-3">
                                <div class="mb-3">
                                    <label class="form-label">Realisasi</label>
                                    <input type="number" class="form-control" wire:model="realisasi">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hibah</label>
                                    <input type="number" class="form-control" wire:model="hibah_penambahan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Reklasifikasi</label>
                                    <input type="number" class="form-control" wire:model="reklasifikasi_penambahan">
                                </div>
                            </div>
                        </details>

                        <details class="mb-3 border rounded shadow-sm">
                            <summary class="p-3 bg-light" style="cursor: pointer; font-weight: bold;">
                                ➖ Pengurangan
                            </summary>
                            <div class="p-3">
                                <div class="mb-3">
                                    <label class="form-label">Pemakaian</label>
                                    <input type="number" class="form-control" wire:model="pemakaian">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hibah pengurangan</label>
                                    <input type="number" class="form-control" wire:model="hibah_pengurangan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Reklasifikasi</label>
                                    <input type="number" class="form-control" wire:model="reklasifikasi_pengurangan">
                                </div>
                            </div>
                        </details>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Keterangan</label>
                            <input type="text" class="form-control" wire:model="keterangan">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" wire:loading.attr="disabled">
                                <span wire:loading.remove>Kirim Data Mutasi</span>
                                <span wire:loading>Menyimpan...</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
