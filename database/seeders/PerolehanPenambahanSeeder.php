<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerolehanPenambahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PerolehanPenambahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         PerolehanPenambahan::factory(5)->create();
    }
}
