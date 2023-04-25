<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MatKulController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('get-all-dosen', 'App\Http\Controllers\DosenController@index');
// Route::post('create-dosen', 'App\Http\Controllers\DosenController@store');
// Route::put('update-dosen/{id}', 'App\Http\Controllers\DosenController@update');

Route::resource('/dosen', DosenController::class)->only(['index', 'store', 'update', 'show']);
Route::resource('/matkul', MatKulController::class)->only(['index', 'store', 'update', 'show']);
Route::resource('/mahasiswa', MahasiswaController::class)->only(['index', 'store', 'update', 'show']);
Route::resource('/kelas', KelasController::class)->only(['index', 'store', 'update', 'show']);
