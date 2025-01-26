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
        Schema::create('pemesanandetail_tt', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->default(DB::raw('gen_random_uuid()'));
            $table->boolean('is_active')->default(true);
            $table->string('nama_penumpang');
            $table->integer('no_identitas');
            $table->uuid('id_pemesanan');
            $table->timestamps();
        });

        Schema::table('pemesanandetail_tt', function (Blueprint $table) {
            $table->foreign('id_pemesanan')->references('uuid')->on('pemesanan_tt')->onDelete('cascade');
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
