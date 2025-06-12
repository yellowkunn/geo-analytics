<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrasaranaJalanController;
use App\Http\Controllers\GrafikController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PrasaranaJalanController::class, 'index']);
Route::get('prasarana-jalan/export', [PrasaranaJalanController::class, 'export'])->name('prasarana-jalan.export');
Route::post('prasarana-jalan/import', [PrasaranaJalanController::class, 'import'])->name('prasarana-jalan.import');

Route::get('/grafik', [GrafikController::class, 'index'])->name('grafik.index');
