<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\KirimUangController;
use App\Http\Controllers\MintaUangController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/data-pengguna', [AuthController::class, 'dataPengguna'])->middleware('auth:sanctum');
Route::put('/update-user', [AuthController::class, 'updateUser'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->post('/update-photo', [AuthController::class, 'updateUserPhoto']);
Route::middleware('auth:sanctum')->get('/get-saldo', [AuthController::class, 'getSaldoUser']);

Route::middleware('auth:sanctum')->get('/kas-masuk/data', [KasController::class, 'getDataKasMasuk']);
Route::middleware('auth:sanctum')->post('/kas-masuk/save', [KasController::class, 'insertDataKasMasuk']);
Route::middleware('auth:sanctum')->get('/kas-masuk/detail/{notrans}', [KasController::class, 'getDetailKasMasuk']);
Route::middleware('auth:sanctum')->delete('/kas-masuk/delete/{notrans}', [KasController::class, 'deleteDataKasMasuk']);
Route::middleware('auth:sanctum')->put('/kas-masuk/update/{notrans}', [KasController::class, 'updateDataKasMasuk']);

Route::middleware('auth:sanctum')->get('/kas-keluar/data', [KasController::class, 'getDataKasKeluar']);
Route::middleware('auth:sanctum')->post('/kas-keluar/save', [KasController::class, 'insertDataKasKeluar']);
Route::middleware('auth:sanctum')->get('/kas-keluar/detail/{notrans}', [KasController::class, 'getDetailKasKeluar']);
Route::middleware('auth:sanctum')->delete('/kas-keluar/delete/{notrans}', [KasController::class, 'deleteDataKasKeluar']);
Route::middleware('auth:sanctum')->put('/kas-keluar/update/{notrans}', [KasController::class, 'updateDataKasKeluar']); 

Route::middleware('auth:sanctum')->get('/kirim-uang/data', [KirimUangController::class, 'getDataKirimUang']);
Route::middleware('auth:sanctum')->post('/kirim-uang/save', [KirimUangController::class, 'insertDataKirimUang']); 

Route::middleware('auth:sanctum')->get('/minta-uang/data', [MintaUangController::class, 'getDataMintaUang']);
Route::middleware('auth:sanctum')->post('/minta-uang/save', [MintaUangController::class, 'insertDataMintaUang']);
Route::middleware('auth:sanctum')->get('/minta-uang/detail/{noref}', [MintaUangController::class, 'getDataDetail']);
Route::middleware('auth:sanctum')->post('/minta-uang/proses-permintaan/{noref}', [MintaUangController::class, 'prosesPermintaan']);
    
