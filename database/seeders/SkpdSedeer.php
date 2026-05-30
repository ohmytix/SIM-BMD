<?php

namespace Database\Seeders;

use App\Models\Skpd;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SkpdSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataSkpd = [
            ['nama' => 'Dinas Pendidikan dan Kebudayaan'],
            ['nama' => 'Dinas Kesehatan'],
            ['nama' => 'Dinas Pekerjaan Umum dan Penataan Ruang'],
            ['nama' => 'Badan Perencanaan Pembangunan Daerah (BAPPEDA)'],
            ['nama' => 'Badan Pengelolaan Keuangan dan Aset Daerah (BPKAD)'],
            ['nama' => 'Dinas Kependudukan dan Pencatatan Sipil'],
            ['nama' => 'Dinas Sosial'],
            ['nama' => 'Dinas Perhubungan'],
            ['nama' => 'Satuan Polisi Pamong Praja'],
            ['nama' => 'Dinas Penanaman Modal dan PTSP'],
        ];

        foreach($dataSkpd as $data)
        {
            Skpd::create($data);
        }
    }
}
