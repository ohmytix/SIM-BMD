<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hitung_penyusutan_mutasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId("aset_utama_id")->nullable()->constrained()->onDelete('cascade');
            $table->date("tanggal_mutasi");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hitung_penyusutan_mutasis');
    }
};
