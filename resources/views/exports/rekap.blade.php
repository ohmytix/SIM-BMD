<table border="1">
    {{-- JUDUL --}}
    <tr>
        <td colspan="19" align="center"><b>PEMERINTAH KOTA SUKABUMI</b></td>
    </tr>
    <tr>
        <td colspan="19" align="center"><b>{{ strtoupper($namaDaerah) }}</b></td>
    </tr>
    <tr>
        <td colspan="19" align="center"><b>KERTAS KERJA MUTASI ASET</b></td>
    </tr>
    <tr>
        <td colspan="19" align="center">
            <b>PERIODE {{ \Carbon\Carbon::parse($tglLalu)->format('d-m-Y') }}
            S.D {{ \Carbon\Carbon::parse($tglLaporan)->format('d-m-Y') }}</b>
        </td>
    </tr>

    <tr><td colspan="19"></td></tr>
    <tr>
        <th rowspan="2" >No</th>
        <th rowspan="2">Kode Barang</th>
        <th rowspan="2" >Uraian</th>
        <th colspan="2" >Saldo Awal</th>
        <th colspan="7" >Penambahan</th>
        <th rowspan="2" >Total Penambahan</th>
        <th colspan="6" >Pengurangan</th>
        <th rowspan="2" >Total Pengurangan</th>
        <th colspan="2" >Saldo Akhir</th>
    </tr>
    <tr>
        <th >Jumlah</th>
        <th >Perolehan</th>
        <th >Koreksi</th>
        <th >Barang Lama</th>
        <th >Belanja</th>
        <th >Hibah</th>
        <th >Reklas</th>
        <th >Mutasi</th>
        <th >Lainnya</th>
        <th >Koreksi</th>
        <th >Hibah</th>
        <th >Reklas</th>
        <th >Mutasi</th>
        <th >Penghapusan</th>
        <th >Lainnya</th>
        <th >Perolehan</th>
        <th >Jumlah</th>
    </tr>

    @foreach ($rekap as $i => $a)
        @php
            $tambah = $a['tambah_koreksi'] + $a['tambah_barang'] + $a['tambah_belanja'] +
                      $a['tambah_hibah'] + $a['tambah_reklas'] + $a['tambah_mutasi'] +
                      $a['tambah_lainnya'];

            $kurang = $a['kurang_koreksi'] + $a['kurang_hibah'] + $a['kurang_reklas'] +
                      $a['kurang_mutasi'] + $a['kurang_hapus'] + $a['kurang_lainnya'];

            $akhir = $a['saldo_awal'] + $tambah - $kurang;
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $a['kode'] }}</td>
            <td>{{ $a['uraian'] }}</td>
            <td>{{ $a['jumlah'] }}</td>
            <td>{{ $a['saldo_awal'] }}</td>
            <td>{{ $a['tambah_koreksi'] }}</td>
            <td>{{ $a['tambah_barang'] }}</td>
            <td>{{ $a['tambah_belanja'] }}</td>
            <td>{{ $a['tambah_hibah'] }}</td>
            <td>{{ $a['tambah_reklas'] }}</td>
            <td>{{ $a['tambah_mutasi'] }}</td>
            <td>{{ $a['tambah_lainnya'] }}</td>
            <td>{{ $tambah }}</td>
            <td>{{ $a['kurang_koreksi'] }}</td>
            <td>{{ $a['kurang_hibah'] }}</td>
            <td>{{ $a['kurang_reklas'] }}</td>
            <td>{{ $a['kurang_mutasi'] }}</td>
            <td>{{ $a['kurang_hapus'] }}</td>
            <td>{{ $a['kurang_lainnya'] }}</td>
            <td>{{ $kurang }}</td>
            <td>{{ $akhir }}</td>
            <td>{{ $a['jumlah'] }}</td>
        </tr>
    @endforeach
</table>
