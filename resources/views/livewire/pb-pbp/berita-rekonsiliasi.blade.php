<div>
    <div class="card shadow-sm">
        {{-- Header (Sama seperti sebelumnya) --}}
        <div class="card-header text-white" style="background: linear-gradient(180deg, #00bcd4 0%, #00acc1 100%);">
            <h5 class="mb-0 fw-bold">Berita Acara Rekonsiliasi (PB-PBP)</h5>
        </div>

        <div class="card-body bg-white">

            {{-- FILTER --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Pilih Aset</label>
                            <select class="form-select">
                                <option>Aset Lancar</option>
                                <option>Aset tetap</option>
                                <option>Aset Lainnya</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Periode Saldo</label>
                            <input type="text" class="form-control"
                                placeholder="Pilih rentang tanggal">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-select">
                                <option>Semua Status</option>
                                <option>Sesuai</option>
                                <option>Tidak Sesuai</option>
                            </select>
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button class="btn btn-secondary w-100">Filter</button>
                        </div>
                    </div>
                </div>
            </div>

         {{-- TABEL --}}   

        <div class="card-body bg-white">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Uraian Aset</th>
                            <th>Penggunaan Barang</th>
                            <th>Sesuai</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                       {{-- Baris: Tanah --}}
                       <tr>
                            <td class="text-center">1</td>
                            <td>Tanah</td>
                            <td class="text-center">
                                {{ number_format($nilaiTanah, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">Sesuai</span>
                            </td>
                            <td>-</td>
                            
                        </tr>
                       {{-- Baris: Peralatan dan Mesin --}}
                       <tr>
                            <td class="text-center">2</td>
                            <td>Peralatan dan Mesin</td>
                            <td class="text-center">
                                {{ number_format($nilaiPeralatan, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <select class="form-select">
                                <option><span class ="badage bg-success">Sesuai</span></option>
                                <option><span class ="badage bg-danger">Tidak sesuai</span></option>
                            </select>
                            </td>
                            <td>-</td>
                            
                        </tr>
                        {{-- Baris: Gedung dan Bangunan --}}
                       <tr>
                            <td class="text-center">3</td>
                            <td>Gedung dan Bangunan</td>
                            <td class="text-center">
                                {{ number_format($nilaiGedung, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">Sesuai</span>
                            </td>
                            <td>-</td>
                            
                        </tr>
                       {{-- Baris: Jalan, Jaringan dan Irigasi --}}
                        <tr>
                            <td class="text-center">4</td>
                            <td>Jalan, Jaringan dan Irigasi</td>
                            <td class="text-center">
                                {{ number_format($nilaiJalan, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">Sesuai</span>
                            </td>
                            <td>-</td>
                           
                        </tr>
                        {{-- Baris: Aset Tetap Lainnya --}}
                        <tr>
                            <td class="text-center">5</td>
                            <td>Aset Tetap Lainnya</td>
                            <td class="text-center">
                                {{ number_format($nilaiLainnya, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">Sesuai</span>
                            </td>
                            <td>-</td>
                            
                        </tr>
                        {{-- Baris: Konstruksi Dalam Pengerjaan --}}
                        <tr>
                            <td class="text-center">6</td>
                            <td>Konstruksi Dalam Pengerjaan</td>
                            <td class="text-center">
                                {{ number_format($nilaiKonstruksi, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">Sesuai</span>
                            </td>
                            <td>-</td>
                            
                        </tr>
                        {{-- Baris: Kemitraan dengan pihak ketiga --}}
                        <tr>
                            <td class="text-center">7</td>
                            <td>Kemitraan dengan pihak ketiga</td>
                            <td class="text-center">
                                {{ number_format($nilaiKemitraan, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">Sesuai</span>
                            </td>
                            <td>-</td>
                            
                        </tr>
                        {{-- Baris: Aset tidak berwujud --}}
                        <tr>
                            <td class="text-center">8</td>
                            <td>Aset tidak berwujud</td>
                            <td class="text-center">
                                {{ number_format($nilaiTakBerwujud, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">Sesuai</span>
                            </td>
                            <td>-</td>
                            
                        </tr>
                        {{-- Baris: Aset lain lian --}}
                        <tr>
                            <td class="text-center">9</td>
                            <td>Aset Lain Lain</td>
                            <td class="text-center">
                                {{ number_format($nilaiLainlain, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">Sesuai</span>
                            </td>
                            <td>-</td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>