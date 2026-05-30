<table>
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

    {{-- HEADER --}}
    <tr>
        <th rowspan="2">AKUN NERACA</th>
        <th rowspan="2">SALDO AWAL AUDITED</th>

        <th colspan="7">MUTASI PENAMBAHAN</th>
        <th rowspan="2">TOTAL PENAMBAHAN</th>

        <th colspan="6">MUTASI PENGURANGAN</th>
        <th rowspan="2">TOTAL PENGURANGAN</th>

        <th rowspan="2">SALDO AKHIR</th>
    </tr>

    <tr>
        <th>KOREKSI</th>
        <th>BMD SEBELUM 2025</th>
        <th>REALISASI BELANJA 2025</th>
        <th>HIBAH</th>
        <th>MUTASI</th>
        <th>REKLASIFIKASI</th>
        <th>LAINNYA</th>

        <th>KOREKSI</th>
        <th>HIBAH</th>
        <th>MUTASI</th>
        <th>REKLASIFIKASI</th>
        <th>PENGHAPUSAN</th>
        <th>LAINNYA</th>
    </tr>

    {{-- DATA --}}
    @foreach ($mutasiAset as $row)
        <tr>
            <td>{{ $row['uraian'] }}</td>

            <td align="right">{{ number_format($row['saldo_awal'],2,',','.') }}</td>

            {{-- PENAMBAHAN --}}
            <td align="right">{{ number_format($row['tambah_koreksi'],2,',','.') }}</td>
            <td align="right">{{ number_format($row['tambah_barang'],2,',','.') }}</td>
            <td align="right">{{ number_format($row['tambah_belanja'],2,',','.') }}</td>
            <td align="right">{{ number_format($row['tambah_hibah'],2,',','.') }}</td>
            <td align="right">{{ number_format($row['tambah_mutasi'],2,',','.') }}</td>
            <td align="right">{{ number_format($row['tambah_reklas'],2,',','.') }}</td>
            <td align="right">{{ number_format($row['tambah_lainnya'],2,',','.') }}</td>

            <td align="right"><b>{{ number_format($row['total_penambahan'],2,',','.') }}</b></td>

            {{-- PENGURANGAN --}}
            <td align="right">{{ number_format($row['kurang_koreksi'],2,',','.') }}</td>
            <td align="right">{{ number_format($row['kurang_hibah'],2,',','.') }}</td>
            <td align="right">{{ number_format($row['kurang_mutasi'],2,',','.') }}</td>
            <td align="right">{{ number_format($row['kurang_reklas'],2,',','.') }}</td>
            <td align="right">{{ number_format($row['kurang_hapus'],2,',','.') }}</td>
            <td align="right">{{ number_format($row['kurang_lainnya'],2,',','.') }}</td>

            <td align="right"><b>{{ number_format($row['total_pengurangan'],2,',','.') }}</b></td>

            <td align="right"><b>{{ number_format($row['saldo_akhir'],2,',','.') }}</b></td>
        </tr>
    @endforeach
</table>
