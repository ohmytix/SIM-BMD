<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kode_parent_barang', function (Blueprint $table) {
            $table->id();

            $table->string('kode')->unique(); 
            // contoh: 1.3.7.03.07.01

            $table->string('parent_kode')->nullable();
            // contoh: 1.3.7.03.07

            $table->string('uraian');
            // contoh: Gedung Kantor Permanen

            $table->unsignedTinyInteger('level');
            // contoh: 1,2,3,4,5,6

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('kode_parent_barang');
    }
};

