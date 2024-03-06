<?php

use App\Http\Controllers\BayarKas;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Dev;
use App\Http\Controllers\Login;
use App\Http\Controllers\Logout;
use App\Http\Controllers\PemasukanLain;
use App\Http\Controllers\Pengaturan;
use App\Http\Controllers\Pengeluaran;
use App\Http\Controllers\Piket;
use App\Http\Controllers\Talangan;
use Illuminate\Support\Facades\Hash;
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

Route::get('/passwd', function () {
    // return view('welcome');
    return Hash::make(config('password.salt_front') . 'password' . config('password.salt_back'));
});

Route::group(['prefix' => 'login', 'middleware' => 'guest'], function () {
    Route::get('/', [Login::class, 'form'])->name('Login');
    Route::post('/', [Login::class, 'process']);
});

Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    Route::get('/logout', [Logout::class, 'process'])->name('Logout');

    Route::get('', [Dashboard::class, 'index'])->name('Dashboard');

    Route::get('/piket', [Piket::class, 'index'])->name('Piket');
    Route::post('/piket', [Piket::class, 'upload']);

    Route::get('/bayar-kas', [BayarKas::class, 'index'])->name('BayarKas');
    Route::post('/bayar-kas', [BayarKas::class, 'upload']);

    Route::get('/pengaturan', [Pengaturan::class, 'form'])->name('Pengaturan');
    Route::post('/pengaturan/password', [Pengaturan::class, 'password'])->name('Pengaturan.Password');
    Route::post('/pengaturan/akun', [Pengaturan::class, 'akun'])->name('Pengaturan.Akun');

    Route::get('/talangan', [Talangan::class, 'index'])->name('Talangan');
    Route::post('/talangan/personal', [Talangan::class, 'personal'])->name('Talangan.Personal');
    Route::get('/talangan/{code_id}', [Talangan::class, 'kembali'])->name('Talangan.Kembalikan');
});

Route::group(['middleware' => ['auth', 'isDev'], 'prefix' => 'dev'], function () {
    Route::get('/', [Dev::class, 'index'])->name('Developer');
    Route::post('/', [Dev::class, 'save']);
});

Route::group(['middleware' => ['auth', 'isBen'], 'prefix' => 'pengeluaran'], function () {
    Route::get('/', [Pengeluaran::class, 'index'])->name('Bendahara');
    Route::post('/', [Pengeluaran::class, 'save']);
});

Route::group(['middleware' => ['auth', 'isBen'], 'prefix' => 'pemasukan-lain'], function () {
    Route::get('/', [PemasukanLain::class, 'index'])->name('Bendahara.Lain');
    Route::post('/', [PemasukanLain::class, 'save']);
});
