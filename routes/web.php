<?php

use App\Http\Controllers\AlkitabController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return view('auth.login');
})->name('login');

Route::post('login', [LoginController::class, '_invoke'])->name('login.attempt');

Route::get('register', function (){
    return view('auth.registration');
})->name('register');

Route::post('register', [App\Http\Controllers\RegisterController::class, '__invoke'])->name('register.attempt');

Route::view('dashboard', 'dashboard')->name('dashboard');

Route::get('alkitab', [AlkitabController::class, 'index'])->name('alkitab');

// Internal API untuk Alkitab
Route::get('/api/alkitab/{version}/{book}/{chapter}', [AlkitabController::class, 'getChapter']);
Route::get('/api/alkitab/search/{version}', [AlkitabController::class, 'search']);