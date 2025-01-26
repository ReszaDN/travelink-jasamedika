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
        Schema::create('jadwal_mt', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->default(DB::raw('gen_random_uuid()'));
            $table->boolean('is_active')->default(true);
            $table->datetime('tgl_keberangkatan');
            $table->integer('harga');
            $table->integer('kuota');
            $table->uuid('id_rute');
            $table->uuid('id_kendaraan');
            $table->timestamps();
        });

        Schema::table('jadwal_mt', function (Blueprint $table) {
            $table->foreign('id_rute')->references('uuid')->on('rute_mt')->onDelete('cascade');
            $table->foreign('id_kendaraan')->references('uuid')->on('kendaraan_mt')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
