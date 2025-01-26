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
        Schema::create('rute_mt', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->default(DB::raw('gen_random_uuid()'));
            $table->boolean('is_active')->default(true);
            $table->uuid('keberangkatan');
            $table->uuid('tujuan');
            $table->timestamps();
        });

        Schema::table('rute_mt', function (Blueprint $table) {
            $table->foreign('keberangkatan')->references('uuid')->on('kota_mt')->onDelete('cascade');
            $table->foreign('tujuan')->references('uuid')->on('kota_mt')->onDelete('cascade');
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
