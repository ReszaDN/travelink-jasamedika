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
        Schema::create('customer_mt', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->default(DB::raw('gen_random_uuid()'));
            $table->boolean('is_active')->default(true);
            $table->string('nama');
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin', ['Perempuan', 'Laki-laki']);
            $table->text('alamat');
            $table->uuid('id_user');
            $table->timestamps();
        });

        Schema::table('customer_mt', function (Blueprint $table) {
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
