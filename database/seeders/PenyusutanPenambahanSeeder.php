<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PenyusutanPenambahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenyusutanPenambahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PenyusutanPenambahan::factory(5)->create();
    }
}
