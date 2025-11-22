<?php

use App\Http\Controllers\AlkitabController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\RenunganController;
use App\Http\Controllers\Admin\UserManagementController;
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
})->name('login')->middleware('guest');

Route::post('login', [LoginController::class, 'login'])
    ->name('login.attempt')
    ->middleware(['guest', 'throttle:5,1']); // max 5 attempts per minute

//Register Page
Route::get('register', function (){
    return view('auth.registration');
})->name('register')->middleware('guest');

Route::post('register', [App\Http\Controllers\RegisterController::class, '__invoke'])
->name('register.attempt')
->middleware(['guest', 'throttle:5,1']);

// Verification by 6-digit code (after registration)
Route::get('verify-code', [App\Http\Controllers\VerificationController::class, 'show'])->name('verification.code.show');
Route::post('verify-code', [App\Http\Controllers\VerificationController::class, 'verify'])->name('verification.code.verify');

// Verification resend (rate-limited)
Route::post('verify-resend', [App\Http\Controllers\VerificationController::class, 'resend'])
    ->name('verification.code.resend')
    ->middleware(['throttle:3,10']);

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
    ->middleware(['auth', 'verified', 'prevent.back'])
    ->name('dashboard');

Route::get('/renungan', [RenunganController::class, 'index'])
    ->middleware(['auth', 'verified', 'prevent.back'])
    ->name('renungan');

    Route::get('/renungan/{renungan}/edit', [RenunganController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('renungan.edit');

    Route::put('/renungan/{renungan}', [RenunganController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('renungan.update');

// show single renungan
Route::get('/renungan-harian/{renungan}', [RenunganController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('renungan.show');

// store new renungan (post) — batasi rate untuk mencegah spam
Route::post('/renungan-harian', [RenunganController::class, 'store'])
    ->middleware(['auth', 'verified', 'throttle:10,1']) // max 10 requests per minute per user/ip
    ->name('renungan.store');

// add comment to renungan — batasi juga
Route::post('/renungan-harian/{renungan}/comment', [RenunganController::class, 'comment'])
    ->middleware(['auth', 'verified', 'throttle:20,1']) // max 20 comments per minute
    ->name('renungan.comment');

Route::delete('/renungan-harian/{renungan}', [RenunganController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('renungan.destroy');

Route::delete('/renungan-harian/{renungan}/comment/{comment}', [RenunganController::class, 'destroyComment'])
    ->middleware(['auth', 'verified'])
    ->name('renungan.comment.destroy');


Route::middleware(['auth', 'verified', 'prevent.back'])->group(function () {
    //Donation
    Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
    Route::get('/profile', function () {
        $user = Auth::user()->refresh()->load('badges', 'wallet');
        return view('profile.show', compact('user'));
    })->name('profile');

    Route::get('/wallet', [\App\Http\Controllers\WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/topup', [\App\Http\Controllers\WalletController::class, 'topup'])->name('wallet.topup');
    Route::post('/wallet/withdraw', [\App\Http\Controllers\WalletController::class, 'withdraw'])->name('wallet.withdraw');

    Route::post('/profile/update-name', [App\Http\Controllers\ProfileController::class, 'updateName'])->name('profile.updateName');
    Route::post('/profile/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.changePassword');

    Route::get('/donations/create', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/{donation}/detail', [DonationController::class, 'detail'])->name('donations.detail');
    Route::get('/donations/{donation}/edit', [DonationController::class, 'edit'])->name('donations.edit');
    Route::put('/donations/{donation}', [DonationController::class, 'update'])->name('donations.update');
    Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        Route::get('/transactions', [\App\Http\Controllers\Admin\TransactionManagementController::class, 'index'])->name('transactions.index');
    });
});

// Clicking on donate button
Route::post('/donations/{donation}/donate', [DonationController::class, 'donate'])
    ->name('donations.donate')
    ->middleware(['auth', 'verified']);


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


Route::get('alkitab', [AlkitabController::class, 'index'])
    ->name('alkitab');


// Internal API untuk Alkitab
Route::get('/api/alkitab/{version}/{book}/{chapter}', [AlkitabController::class, 'getChapter'])
    ->middleware('throttle:60,1'); // 60 requests per minute

Route::get('/api/alkitab/search/{version}', [AlkitabController::class, 'search'])
    ->middleware('throttle:60,1'); // 60 requests per minute