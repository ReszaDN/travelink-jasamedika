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
        Schema::create('pemesanan_tt', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->default(DB::raw('gen_random_uuid()'));
            $table->boolean('is_active')->default(true);
            $table->integer('jumlah_pesan');
            $table->integer('total_harga');
            $table->date('tgl_order');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->uuid('id_jadwal');
            $table->uuid('id_user');
            $table->timestamps();
        });

        Schema::table('pemesanan_tt', function (Blueprint $table) {
            $table->foreign('id_jadwal')->references('uuid')->on('jadwal_mt')->onDelete('cascade');
            $table->foreign('id_user')->references('uuid')->on('users')->onDelete('cascade');
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
