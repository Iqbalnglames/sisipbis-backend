<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ArmadaController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:api');
Route::resource('/users',UserController::class);
Route::resource('/armada', ArmadaController::class);
Route::get('/absensi', [AbsensiController::class, 'showAbsen']);
Route::post('/absensi', [AbsensiController::class, 'createAbsen']);
Route::get('/izin', [AbsensiController::class, 'showIzin']);
Route::post('/izin', [AbsensiController::class, 'createIzin']);
Route::get('/pengaduan', [PengaduanController::class, 'showPengaduan']);
Route::post('/pengaduan', [PengaduanController::class, 'createPengaduan']);
Route::get('/detail-pengaduan/{detail_pengaduan}', [PengaduanController::class, 'showDetailPengaduan']);
Route::put('/update-pengaduan/{update_pengaduan}', [PengaduanController::class, 'updatePengaduan']);
Route::get('/user-image/{filename}', [ImageController::class, 'showImage']);
Route::get('/detail-maintenances/{filename}', [ImageController::class, 'showArmadaImage']);