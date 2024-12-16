<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

use App\Http\Controllers\BerandaProdiController;
use App\Http\Controllers\AuthController;



// Route::get('/page/login/Index', [LoginController::class, 'showLogin'])->name('login.show'); // Menampilkan halaman login

// Route::post('/login', [LoginController::class, 'handleLogin'])->name('login.handle'); // Menangani form login

// Route::post('/logout', function () {
//     Auth::logout(); // Melakukan logout
//     return redirect('/login'); // Redirect ke halaman login
// })->name('logout');

// Route::get('/login', [LoginController::class, 'showLoginForm']);
// Route::post('/login', [LoginController::class, 'handleLogin']);
Route::get('/', function(){
    return view('page/login/index');
});

Route::post('/select-role', [LoginController::class, 'handleRoleSelection']);

Route::get('/login', function () {
    return view('page/login/index'); // This returns the login form view
});

Route::post('/login', [LoginController::class, 'login'])->name('login');

// ----------------------------------------------------  Return View  ----------------------------------------------------
// ----------- Beranda View -----------  
Route::get('/beranda_utama', function () {
    return view('Backbone.BerandaUtama');
})->name('beranda_utama');


Route::get('/beranda_pengguna', function () {
    return view('Backbone/BerandaPengguna');
});


// Route::get('/beranda_prodi', [BerandaProdiController::class, 'index']);

Route::get('/daftar_pustaka', function () {
    return view('page/DaftarPustaka/index');
});

// Route::get('/daftar_pustaka/store', function () {
//     return view('page/DaftarPustaka/KelolaDaftarPustaka/TambahDaftarPustaka');
// });


Route::get('/pickk', function () {
    return view('page/master-pic-kk/index');
});

Route::get('/tenaga_kependidikan', function () {
    return view('page/master-tenaga-kependidikan/index');
});