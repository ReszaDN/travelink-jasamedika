<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\master\DashboardAdmin;
use App\Http\Controllers\master\PemesananController;



//AUTH
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});


//DASHBOARD ADMIN
Route::post('/add-kota', [DashboardAdmin::class, 'addKota']);
Route::get('/get-kota', [DashboardAdmin::class, 'getKota']);
Route::post('/delete-kota', [DashboardAdmin::class, 'deleteKota']);
Route::post('/add-rute', [DashboardAdmin::class, 'addRute']);
Route::get('/get-rute', [DashboardAdmin::class, 'getRute']);
Route::post('/delete-rute', [DashboardAdmin::class, 'deleteRute']);
Route::post('/add-kendaraan', [DashboardAdmin::class, 'addKendaraan']);
Route::get('/get-kendaraan', [DashboardAdmin::class, 'getKendaraan']);
Route::post('/delete-kendaraan', [DashboardAdmin::class, 'deleteKendaraan']);
Route::post('/add-jadwal', [DashboardAdmin::class, 'addJadwalKeberangkatan']);
Route::get('/get-jadwal', [DashboardAdmin::class, 'getJadwalKeberangkatan']);
Route::post('/delete-jadwal', [DashboardAdmin::class, 'deleteJadwal']);
Route::get('/get-pemesanan', [DashboardAdmin::class, 'getDataPesanan']);
Route::post('/edit-status', [DashboardAdmin::class, 'updateStatusBayar']);


//Customer
//PROSES BOOKING
Route::post('/get-list-jadwal', [PemesananController::class, 'getListJadwal']);
Route::middleware('auth:sanctum', 'check.user.type ')-> post('/pesan-tiket', [PemesananController::class, 'pesanTiket']);

