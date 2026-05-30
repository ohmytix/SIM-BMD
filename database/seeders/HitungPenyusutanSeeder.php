<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HitungPenyusutanMutasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HitungPenyusutanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HitungPenyusutanMutasi::factory(5)->create();
    }
}
