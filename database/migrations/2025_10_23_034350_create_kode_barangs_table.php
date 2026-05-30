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
        Schema::create('kode_barangs', function (Blueprint $table) {
            $table->id();
            $table->string("kode");
            $table->string("sub_sub_rincang");
            $table->string("sub_rincang")->nullable();
            $table->string("rincian_objek")->nullable();
            $table->string("objek")->nullable();
            $table->string("jenis")->nullable();
            $table->string("kelompok")->nullable();
            $table->string("akun")->nullable();
            $table->string("kode_penyusutan")->nullable();
            $table->integer("usia_manfaat")->nullable();
            $table->integer("a0_5")->nullable();
            $table->integer("a5_10")->nullable();
            $table->integer("a10_20")->nullable();
            $table->integer("a20_25")->nullable();
            $table->integer("a25_30")->nullable();
            $table->integer("a30_40")->nullable();
            $table->integer("a40_45")->nullable();
            $table->integer("a45_50")->nullable();
            $table->integer("a50_65")->nullable();
            $table->integer("a65_75")->nullable();
            $table->integer("a75")->nullable();
            $table->string("keterangan")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_barangs');
    }
};
