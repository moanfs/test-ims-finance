<?php

use App\Http\Controllers\KontrakController;
use App\Http\Controllers\TempoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('kontrak.createKontrak');
})->name('/');

Route::resource('kontrak', KontrakController::class);
Route::get('tempo/{id}', [TempoController::class, 'edit'])->name('tempo');
Route::put('tempo/{id}', [TempoController::class, 'update'])->name('tempo');
