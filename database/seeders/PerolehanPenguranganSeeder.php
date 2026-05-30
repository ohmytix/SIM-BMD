<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerolehanPengurangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PerolehanPenguranganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PerolehanPengurangan::factory(5)->create();
    }
}
