<?php

use App\Http\Controllers\BelimobilController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderSuccessController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebHomePageController;
use App\Livewire\HomePageComponent;
use App\Livewire\TransaksiComponent;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Route;
use Symfony\Component\CssSelector\Node\FunctionNode;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

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

Route::get('/admin', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'store'])->name('register.store');

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'proses'])->name('login.proses');
Route::get('login/keluar', [LoginController::class, 'keluar'])->name('login.keluar');

Route::get('users', function () {
    return view('users.index');
})->name('users')->middleware('auth');

Route::get('mobil', function () {
    return view('mobil.index');
})->name('mobil')->middleware('auth');

Route::get('transaksi', function () {
    return view('transaksi.index');
})->name('transaksi')->middleware('auth');

Route::get('laporan', function () {
    return view('laporan.index');
})->name('laporan')->middleware('auth');

Route::get('/', [WebHomePageController::class, 'webhomepage']);
Route::get('/get-car-by-type/{jenis}', [WebHomePageController::class, 'getCarByType']);
Route::get('/get-car-details/{id}', [WebHomePageController::class, 'getCarDetails']);
Route::post('/store', [WebHomePageController::class, 'store'])->name('store');
// Route di web.php
Route::get('/order-success', [WebHomePageController::class, 'orderSuccess'])->name('order.success');

