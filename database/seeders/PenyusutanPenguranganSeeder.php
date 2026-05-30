<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PenyusutanPengurangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenyusutanPenguranganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PenyusutanPengurangan::factory(5)->create();
    }
}
