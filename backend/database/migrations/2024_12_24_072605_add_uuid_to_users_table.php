<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->uuid('uuid')->unique()->after('id')->default(DB::raw('gen_random_uuid()')); // Menambahkan kolom uuid
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('uuid');
    });
}

};

