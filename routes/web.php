<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/login/action', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register/action', [RegisterController::class, 'actionregister'])->name('actionregister');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::post('/actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

Route::get('/user', [UserController::class, 'index'])->name('user')->middleware('auth');
Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete')->middleware('auth');

Route::get('/soal', [SoalController::class, 'index'])->name('soal')->middleware('auth');
Route::get('/soal/delete/{id}', [SoalController::class, 'delete'])->name('deleteSoal')->middleware('auth');
Route::post('/soal/storeinput', [SoalController::class, 'storeinput'])->name('storeInputSoal')->middleware('auth');
Route::get('/soal/update/{id}', [SoalController::class, 'update'])->name('updateSoal')->middleware('auth');
Route::post('/soal/storeupdate', [SoalController::class, 'storeupdate'])->name('storeUpdateSoal')->middleware('auth');

Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai')->middleware('auth');
Route::post('/nilai/storeupdate', [NilaiController::class, 'storeupdate'])->name('storeUpdateNilai')->middleware('auth');
Route::post('/nilai/storeinput', [NilaiController::class, 'storeinput'])->name('storeInputSoal')->middleware('auth');
