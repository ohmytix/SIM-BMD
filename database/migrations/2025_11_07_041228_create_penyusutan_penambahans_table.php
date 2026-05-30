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
        Schema::create('penyusutan_penambahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId("aset_utama_id")->nullable()->constrained()->onDelete('cascade');
            $table->integer("saldo_awal")->nullable();
            $table->integer("koreksi_saldo_awal")->nullable();
            $table->integer("hibah")->nullable();
            $table->integer("mutasi")->nullable();
            $table->integer("reklasifikasi")->nullable();
            $table->integer("lainnya")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyusutan_penambahans');
    }
};
