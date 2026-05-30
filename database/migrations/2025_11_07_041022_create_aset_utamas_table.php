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
        Schema::create('aset_utamas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skpd_id')->constrained('skpds')->onDelete('cascade');
            $table->foreignId("kode_barang_id") 
                  ->nullable()
                  ->constrained("kode_barangs") 
                  ->nullOnDelete();
            $table->string("spesifikasi")->nullable();
            $table->string("spesifikasi_lainnya")->nullable();
            $table->string("dokumen")->nullable();
            $table->string("cara_perolehan")->nullable();
            $table->date("tanggal_perolehan")->nullable();
            $table->string("ukuran_barang")->nullable();
            $table->string("satuan_barang")->nullable();
            $table->string("kondisi_barang")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_utamas');
    }
};
