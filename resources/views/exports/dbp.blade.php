<!DOCTYPE html>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000000; padding: 5px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bg-grey { background-color: #f2f2f2; }
        .bg-blue { background-color: #cfe2f3; }
        .bg-green { background-color: #d9ead3; }
        .bg-yellow { background-color: #fff2cc; }
        .bg-red { background-color: #f4cccc; }
    </style>
</head>
<body>

<table>
    <thead>
        <tr>
            <th colspan="59" style="text-align: center; font-weight: bold; font-size: 14px; height: 30px;">
                LAPORAN DETAIL ASET & PENYUSUTAN - {{ strtoupper($nama_skpd) }}
            </th>
        </tr>
        <tr>
            <th colspan="59" style="text-align: center; height: 25px;">
                PERIODE: {{ $carbonLalu->format('d/m/Y') }} s.d {{ $carbonLaporan->format('d/m/Y') }}
            </th>
        </tr>
        <tr>
            <th colspan="59" style="border: none; height: 10px;"></th>
        </tr>

        <tr>
            <th rowspan="3" class="bg-grey" style="width: 30px;">NO</th>
            <th rowspan="3" class="bg-grey" style="width: 100px;">Kode</th>
            <th rowspan="3" class="bg-grey" style="width: 200px;">Sub Sub Rincian Objek</th>
            <th rowspan="3" class="bg-grey" style="width: 150px;">Spesifikasi</th>
            <th rowspan="3" class="bg-grey" style="width: 150px;">Spesifikasi Lainnya</th>
            <th rowspan="3" class="bg-grey">Dokumen</th>
            <th rowspan="3" class="bg-grey">Cara Perolehan</th>
            <th rowspan="3" class="bg-grey">Tgl Perolehan</th>
            <th rowspan="3" class="bg-grey">Ukuran</th>
            <th rowspan="3" class="bg-grey">Satuan</th>
            <th rowspan="3" class="bg-grey">Kondisi</th>
            <th rowspan="3" class="bg-grey">Harga Perolehan</th>
            <th rowspan="3" class="bg-grey">Akumulasi Penyusutan</th>
            <th rowspan="3" class="bg-grey">Nilai Buku</th>
            <th rowspan="3" class="bg-grey">Keterangan</th>

            <th colspan="16" class="bg-blue">HARGA PEROLEHAN</th>
            <th colspan="6" class="bg-green">UMUR BARANG S.D</th>
            <th rowspan="3" class="bg-grey">Kode Akm. Peny.</th>
            <th colspan="17" class="bg-yellow">AKUMULASI PENYUSUTAN</th>
            <th colspan="4" class="bg-red">MUTASI</th>
        </tr>

        <tr>
            <th colspan="8">Penambahan</th>
            <th colspan="7">Pengurangan</th>
            <th rowspan="2" class="bg-blue">Harga Perolehan Akhir</th>

            <th rowspan="2">Harga Barang</th>
            <th rowspan="2">Umur Eko.</th>

            <th rowspan="2" class="bg-yellow">{{ $carbonLalu->format('d-m-Y') }}</th>
            <th rowspan="2" class="bg-blue">{{ $carbonLaporan->format('d-m-Y') }}</th>

            <th rowspan="2">Sisa Umur</th>
            <th rowspan="2">Penyusutan / Bln</th>

            <th colspan="9">Penambahan</th>
            <th colspan="7">Pengurangan</th>
            <th rowspan="2" class="bg-yellow">Akm. Penyusutan Akhir</th>

            <th rowspan="2">Tgl Mutasi</th>
            <th rowspan="2">Umur s.d Mutasi</th>
            <th rowspan="2">Beban Mutasi</th>
            <th rowspan="2">AKM Mutasi</th>
        </tr>

        <tr>
            <th>Saldo Awal</th>
            <th>Koreksi Saldo</th>
            <th>Belanja</th>
            <th>Hibah</th>
            <th>Mutasi</th>
            <th>Reklas</th>
            <th>Lainnya</th>
            <th>Total Tambah</th>

            <th>Koreksi Saldo</th>
            <th>Hibah</th>
            <th>Mutasi</th>
            <th>Reklas</th>
            <th>Hapus</th>
            <th>Lainnya</th>
            <th>Total Kurang</th>

            <th>Saldo Awal</th>
            <th>Koreksi Saldo</th>
            <th>Brg Lama</th>
            <th>Belanja</th>
            <th>Hibah</th>
            <th>Mutasi</th>
            <th>Reklas</th>
            <th>Lainnya</th>
            <th>Total Tambah</th>

            <th>Koreksi Saldo</th>
            <th>Hibah</th>
            <th>Mutasi</th>
            <th>Reklas</th>
            <th>Hapus</th>
            <th>Lainnya</th>
            <th>Total Kurang</th>
        </tr>
    </thead>
    
    <tbody>
        @foreach($AsetUtama as $index => $aset)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ optional($aset->kodeBarang)->kode ?? '-' }}</td>
                <td>{{ mb_convert_encoding($aset->sub_sub_rincan_objek, 'UTF-8', 'UTF-8') }}</td>
                <td>{{ mb_convert_encoding($aset->spesifikasi, 'UTF-8', 'UTF-8') }}</td>
                <td>{{ mb_convert_encoding($aset->spesifikasi_lainnya, 'UTF-8', 'UTF-8') }}</td>
                <td>{{ mb_convert_encoding($aset->dokumen, 'UTF-8', 'UTF-8') }}</td>
                <td>{{ $aset->cara_perolehan }}</td>
                <td class="text-center" style="mso-number-format:'\@';">{{ $aset->tanggal_perolehan ? date('d/m/Y', strtotime($aset->tanggal_perolehan)) : '-' }}</td>
                <td>{{ $aset->ukuran_barang }}</td>
                <td>{{ $aset->satuan_barang }}</td>
                <td>{{ $aset->kondisi_barang }}</td>

                <td>{{ number_format($aset->harga_perolehan_akhir, 2, ',', '.') }}</td>
                <td>{{ number_format($aset->akumulasi_penyusutan_akhir, 2, ',', '.') }}</td>
                <td>{{ number_format($aset->nilai_buku, 2, ',', '.') }}</td>
                <td>{{ mb_convert_encoding($aset->keterangan, 'UTF-8', 'UTF-8') }}</td>

                <td>{{ number_format(optional($aset->PerolehanPenambahan)->saldo_awal ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PerolehanPenambahan)->koreksi_saldo_awal ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PerolehanPenambahan)->belanja ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PerolehanPenambahan)->hibah ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PerolehanPenambahan)->mutasi ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PerolehanPenambahan)->reklasifikasi ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PerolehanPenambahan)->lainnya ?? 0, 2, ',', '.') }}</td>
                <td class="bg-grey"><b>{{ number_format($aset->total_perolehan_penambahan ?? 0, 2, ',', '.') }}</b></td>

                <td>{{ number_format(optional($aset->PerolehanPengurangan)->koreksi_saldo_awal ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PerolehanPengurangan)->hibah ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PerolehanPengurangan)->mutasi ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PerolehanPengurangan)->reklasifikasi ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PerolehanPengurangan)->penghapusan ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PerolehanPengurangan)->lainnya ?? 0, 2, ',', '.') }}</td>
                <td class="bg-grey"><b>{{ number_format($aset->total_perolehan_pengurangan ?? 0, 2, ',', '.') }}</b></td>

                <td class="bg-blue"><b>{{ number_format($aset->harga_perolehan_akhir, 2, ',', '.') }}</b></td>
                
                <td>{{ number_format($aset->harga_barang ?? 0, 2, ',', '.') }}</td>
                <td class="text-center">{{ $aset->umur_ekonomis_bulan }}</td>
                <td class="text-center">{{ $aset->umur_barang_2024 ?? 0 }}</td>
                <td class="text-center">{{ $aset->umur_barang_2025 ?? 0 }}</td>
                <td class="text-center"><b>{{ $aset->sisa_umur ?? 0 }}</b></td>
                <td>{{ number_format($aset->nilai_penyusutan_per_bulan ?? 0, 2, ',', '.') }}</td>
                
                <td class="text-center">{{ optional($aset->kodeBarang)->kode_penyusutan ?? '-' }}</td>

                <td>{{ number_format(optional($aset->PenyusutanPenambahan)->saldo_awal ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PenyusutanPenambahan)->koreksi_saldo_awal ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($aset->barang_lama ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($aset->belanja ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PenyusutanPenambahan)->hibah ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PenyusutanPenambahan)->mutasi ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PenyusutanPenambahan)->reklasifikasi ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PenyusutanPenambahan)->lainnya ?? 0, 2, ',', '.') }}</td>
                <td class="bg-grey"><b>{{ number_format($aset->total_penyusutan_penambahan ?? 0, 2, ',', '.') }}</b></td>

                <td>{{ number_format(optional($aset->PenyusutanPengurangan)->koreksi_saldo_awal ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PenyusutanPengurangan)->hibah ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PenyusutanPengurangan)->mutasi ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PenyusutanPengurangan)->reklasifikasi ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PenyusutanPengurangan)->penghapusan ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format(optional($aset->PenyusutanPengurangan)->lainnya ?? 0, 2, ',', '.') }}</td>
                <td class="bg-grey"><b>{{ number_format($aset->total_penyusutan_pengurangan ?? 0, 2, ',', '.') }}</b></td>

                <td class="bg-yellow"><b>{{ number_format($aset->akumulasi_penyusutan_akhir ?? 0, 2, ',', '.') }}</b></td>
                
                <td class="text-center" style="mso-number-format:'\@';">{{ $aset->Mutasi && $aset->Mutasi->tanggal_mutasi ? date('d/m/Y', strtotime($aset->Mutasi->tanggal_mutasi)) : '-' }}</td>
                <td class="text-center">{{ number_format($aset->umur_sd_mutasi ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($aset->beban_mutasi ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($aset->akm_mutasi ?? 0, 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>