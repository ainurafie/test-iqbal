<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\TargetController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['guest'])->group(function () {

    Route::get('/', [AuthController::class, 'loginIndex'])->name('login.index');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('admin.index');

    Route::resource('rekening', RekeningController::class)->except('update');

    Route::patch('rekening/{rekening}', [RekeningController::class, 'update'])->name('rekening.update');

    Route::resource('target', TargetController::class)->except('update');

    Route::patch('target/{target}', [TargetController::class, 'update'])->name('target.update');
});

// Route::get('/target', function () {
//     return view('target.index');
// });
// Route::get('/target-create', function () {
//     return view('target.create');
// });
// Route::get('/target-edit', function () {
//     return view('target.edit');
// });
Route::get('/transaksi', function () {
    return view('transaksi.index');
});
Route::get('/transaksi-create', function () {
    return view('transaksi.create');
});
Route::get('/transaksi-edit', function () {
    return view('transaksi.edit');
});

