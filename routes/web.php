<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginValidationController;
use App\Http\Controllers\AnaliticsDashboardController;
use App\Http\Controllers\LeaderBoardController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\SplashPageController;
// use App\Http\Controllers\ProgrammingLanguageController as ProgLang;
use App\Http\Controllers\BGMController;
use App\Http\Controllers\BGImgController;
use App\Http\Controllers\SoundEffectController;
use App\Http\Controllers\VisualEffectController;
use App\Http\Controllers\Public\SplashPageController as PublicSplash;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| 
| !important note:
| This route is for public and normal user only
|
| Route for superadmin
| routes/superadmin.php
|
| Route for admin
| routes/admin.php
|
| Check app/Providers/RouteServiceProvider.php for more details
*/

// Ajax
Route::post('analitics_dashboard', [AnaliticsDashboardController::class, 'index']);
// End

// Public
Route::get('/', [PublicSplash::class, 'index']);
Route::get('/leaderboard', [LeaderBoardController::class, 'index']);
Route::get('/public_profile/{user}', [PublicProfileController::class, 'index'])->name('public_profile');
// End

Route::controller(LoginValidationController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login_validation', 'validate_user')->name('login_validation');
    Route::get('/profile', 'profile')->name('profile');
    Route::post('/profile/{user}', 'profile_update')->name('profile_update');
    Route::post('/logout', 'logout')->name('logout');
});

Route::get('/dashboard', function () {
    if(!Auth::check()){
        return redirect()->route('login');
    }
    return view('superadmin.dashboard');
})->name('dashboard');

Route::resource('users', UsersController::class);
// Game Routes
// Route::resource('game/proglangs', App\Http\Controllers\ProgLang::class);
Route::resource('game/bgms', BGMController::class);
Route::resource('game/bgims', BGImgController::class);
Route::resource('game/effects/sfxs', SoundEffectController::class);
Route::resource('game/effects/vfxs', VisualEffectController::class);
// End game


Route::controller(SplashPageController::class)->group(function () {
    Route::get('/splash', 'index')->name('splash.index');
    Route::get('/splash/show/{id}', 'show')->name('splash.show');
    Route::post('/splash/store', 'store')->name('splash.store');
    Route::delete('/splash/destroy/{id}', 'destroy')->name('splash.destroy');
});