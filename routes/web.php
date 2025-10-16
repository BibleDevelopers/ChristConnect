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
    return view('auth.register');
})->name('register');

Route::view('dashboard', 'dashboard')->name('dashboard');

Route::get('alkitab', [AlkitabController::class, 'index'])->name('alkitab');

// Internal API for Alkitab
Route::get('/api/alkitab/{version}/{book}/{chapter}', [AlkitabController::class, 'getChapter']);
Route::get('/api/alkitab/search/{version}', [AlkitabController::class, 'search']);