<?php

use App\Http\Controllers\DompetController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;


// Home Route
Route::get('/', function () {
    return view('login');
});

Auth::routes(); // Rute autentikasi otomatis

// Rute untuk dashboard
Route::get('/home', [HomeController::class, 'index'])->middleware('auth');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// CRUD User    
Route::resource('user', UserController::class);

// Rute untuk wallet
Route::post('/topUp', [DompetController::class, 'topup'])->name('topUp');
Route::post('/acceptRequest', [DompetController::class, 'acceptRequest'])->name('acceptRequest');
Route::post('/withdraw', [DompetController::class, 'withdraw'])->name('withdraw');
Route::post('/transfer', [DompetController::class, 'transfer'])->name('transfer');

// Rute untuk admin
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::post('/add-user', [UserController::class, 'store'])->name('add-user');
    Route::get('add-user', [UserController::class, 'create'])->name('add-user');
    Route::post('store-user', [UserController::class, 'store'])->name('store-user');
    Route::get('edit-user/{user}', [UserController::class, 'edit'])->name('edit-user');
    Route::put('update-user/{user}', [UserController::class, 'update'])->name('update-user');
    Route::delete('delete-user/{user}', [UserController::class, 'destroy'])->name('delete-user');
});

Route::post('/approve/{dompet}', [DompetController::class, 'acceptRequest'])
    ->name('approve')
    ->middleware('role:bank'); // Middleware role untuk pengguna 'bank'

Route::post('/reject/{dompet}', [DompetController::class, 'rejectRequest'])
    ->name('reject')
    ->middleware('role:bank'); // Middleware role untuk pengguna 'bank'

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/mutasi', [DompetController::class, 'allMutasi'])->name('mutasi.index')->middleware('auth');
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/mutasi', [DompetController::class, 'mutasi'])->name('siswa.mutasi');
});

Route::get('/all-transaction', [DompetController::class, 'all'])->name('wallet.all');
Route::get('/get-user-info/{id}', [App\Http\Controllers\UserController::class, 'getUserInfo']);

Route::post('/bank/topup', [DompetController::class, 'bankTopupToSiswa'])->name('bank.topup');
Route::post('/bank/withdraw', [DompetController::class, 'bankWithdrawFromSiswa'])->name('bank.withdraw');

Route::get('/wallet/export-pdf{userId?}', [DompetController::class, 'exportPDF'])->name('export.pdf');
