<?php

use Illuminate\Support\Facades\Route;

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

Route::get('test', function(){
    return view('text');
});

// Ajax
Route::controller(LiveSearchController::class)->group(function(){
    Route::get('/search/portfolio', 'public_portfolio')->name('search.portfolio');
});
Route::post('analitics_dashboard', [AnaliticsDashboardController::class, 'index']);
// End

// Public
Route::get('/', [App\Http\Controllers\Public\SplashPageController::class, 'index']);
Route::get('/leaderboard', [LeaderBoardController::class, 'index']);
Route::controller(PublicProfileController::class)->group(function () {
    Route::get('public_profile', 'index')->name('public_profile.index');
    Route::get('/public_profile/{user}', 'show')->name('public_profile.show');
});

// End

Route::controller(LoginValidationController::class)->group(function () {
    Route::get('/login', 'index');
    Route::post('/login_validation', 'validate_user');
    Route::get('/profile', 'profile');
    Route::post('/profile/{user}', 'profile_update');
    Route::post('/logout', 'logout');
});

Route::get('/dashboard', function () {
    return view('superadmin.dashboard');
});

Route::get('play', function(){
    return view('layouts.play');
});