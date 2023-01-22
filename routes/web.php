<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginValidationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('public.index');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login_validation', [LoginValidationController::class, 'validate_user'])->name('login_validation');

Route::get('/profile', function () {
    return view('public.profile');
});

Route::get('/leaderboard', function () {
    return view('public.leaderboard');
});

Route::get('/dashboard', function () {
    dd(Auth::user());
})->name('dashboard');

Route::resource('users', App\Http\Controllers\UsersController::class);

Route::post('/logout', [LoginValidationController::class, 'logout'])->name('logout');