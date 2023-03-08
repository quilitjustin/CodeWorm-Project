<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginValidationController;
use App\Http\Controllers\AnaliticsDashboardController;
use App\Http\Controllers\LeaderBoardController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\SplashPageController;

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

Route::get('/', function () {
    return view('public.index');
});
// Public
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

Route::resource('users', App\Http\Controllers\UsersController::class);

Route::controller(SplashPageController::class)->group(function () {
    Route::get('/splash', 'index')->name('splash.index');
    Route::get('/splash/show', 'show')->name('splash.show');
});