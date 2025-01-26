<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\Controller_anggota;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/anggota', [Controller_anggota::class, 'index']);
