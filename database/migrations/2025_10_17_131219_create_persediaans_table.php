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
        Schema::create('persediaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skpd_id')
          ->nullable() 
          ->constrained('skpds')
          ->onDelete('cascade');
            $table->enum("kategori_persediaan", ["belanja_bahan","belanja_alat", "belanja_persediaan"]); //belanja bahan/alat
            $table->string("nama_barang"); //tabung gas/ alat tulis kantor
            $table->integer("saldo"); 
            $table->integer("realisasi");
            $table->integer("hibah_penambahan");
            $table->integer("reklasifikasi_penambahan");
            $table->integer("pemakaian");
            $table->integer("hibah_pengurangan");
            $table->integer("reklasifikasi_pengurangan");
            $table->string("keterangan"); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persediaans');
    }
};
