<?php

use App\Http\Controllers\AlkitabController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\RenunganController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;


//Landing Page
Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

//Login Page
Route::get('login', function () {
    return view('auth.login');
})->name('login');

Route::post('login', [LoginController::class, 'login'])
->name('login.attempt')
->middleware('throttle:5,1');

//Register Page
Route::get('register', function (){
    return view('auth.registration');
})->name('register');

Route::post('register', [App\Http\Controllers\RegisterController::class, '__invoke'])
->name('register.attempt')
->middleware('throttle:5,1');

//Logout
Route::post('logout', function () {
    Auth::guard('web')->logout();

    Session::invalidate();
    Session::regenerateToken();

    return redirect('/');
})->name('logout');
//Dashboard
//Route::view('dashboard', 'dashboard')->name('dashboard')->middleware(['auth', 'verified']);
// Dashboard (Protected) - Jep
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/renungan', [RenunganController::class, 'index'])
    ->middleware(['auth'])
    ->name('renungan');

    Route::get('/renungan/{renungan}/edit', [RenunganController::class, 'edit'])->middleware(['auth'])->name('renungan.edit');
    Route::put('/renungan/{renungan}', [RenunganController::class, 'update'])->middleware(['auth'])->name('renungan.update');

// show single renungan
Route::get('/renungan-harian/{renungan}', [RenunganController::class, 'show'])
    ->middleware(['auth'])
    ->name('renungan.show');

// store new renungan (post) — batasi rate untuk mencegah spam
Route::post('/renungan-harian', [RenunganController::class, 'store'])
    ->middleware(['auth', 'throttle:10,1']) // max 10 requests per minute per user/ip
    ->name('renungan.store');

// add comment to renungan — batasi juga
Route::post('/renungan-harian/{renungan}/comment', [RenunganController::class, 'comment'])
    ->middleware(['auth', 'throttle:20,1']) // max 20 comments per minute
    ->name('renungan.comment');

Route::delete('/renungan-harian/{renungan}', [RenunganController::class, 'destroy'])
    ->middleware('auth')
    ->name('renungan.destroy');

Route::delete('/renungan-harian/{renungan}/comment/{comment}', [RenunganController::class, 'destroyComment'])
    ->middleware('auth')
    ->name('renungan.comment.destroy');


//Donation

Route::middleware(['auth'])->group(function () {
    Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
    Route::get('/profile', function () {
        $user = Auth::user()->refresh()->load('badges', 'wallet');
        return view('profile.show', compact('user'));
    })->name('profile');

    Route::post('/profile/update-name', [App\Http\Controllers\ProfileController::class, 'updateName'])->middleware(['auth'])->name('profile.updateName');
    Route::post('/profile/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->middleware(['auth'])->name('profile.changePassword');

    Route::get('/donations/create', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/{donation}/edit', [DonationController::class, 'edit'])->name('donations.edit');
    Route::put('/donations/{donation}', [DonationController::class, 'update'])->name('donations.update');
});

// Clicking on donate button
Route::post('/donations/{donation}/donate', [DonationController::class, 'donate'])
    ->name('donations.donate')
    ->middleware('auth');


// Email verification
Route::get('/email/verify', function () {
    return view('auth.verification-notice');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('alkitab', [AlkitabController::class, 'index'])->name('alkitab');


// Internal API untuk Alkitab
Route::get('/api/alkitab/{version}/{book}/{chapter}', [AlkitabController::class, 'getChapter']);
Route::get('/api/alkitab/search/{version}', [AlkitabController::class, 'search']);