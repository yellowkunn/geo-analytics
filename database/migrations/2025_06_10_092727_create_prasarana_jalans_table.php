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
        Schema::create('prasarana_jalans', function (Blueprint $table) {
            $table->id('id_prasarana_jalan');
            $table->integer('no_ruas');
            $table->string('kode_ruas', 20);
            $table->text('nama_ruas')->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->float('panjang_ruas_km')->nullable();
            $table->float('panjang_survey_km')->nullable();
            $table->float('lebar_ruas_m')->nullable();
            $table->float('perkerasan_hotmix_km')->nullable();
            $table->float('perkerasan_lapen_km')->nullable();
            $table->float('perkerasan_beton_km')->nullable();
            $table->float('telford_kerikil')->nullable(); 
            $table->float('tanah_belum_tembus')->nullable();
            $table->float('kondisi_baik_km')->nullable();
            $table->decimal('kondisi_baik_persen', 5, 2)->nullable();
            $table->float('kondisi_sedang_km')->nullable();
            $table->decimal('kondisi_sedang_persen', 5, 2)->nullable();
            $table->float('kondisi_rusak_ringan_km')->nullable();
            $table->decimal('kondisi_rusak_ringan_persen', 5, 2)->nullable();
            $table->float('kondisi_rusak_berat_km')->nullable();
            $table->decimal('kondisi_rusak_berat_persen', 5, 2)->nullable();
            $table->integer('lhr')->nullable();
            $table->string('akses', 20)->nullable();
            $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prasarana_jalans');
    }
};
