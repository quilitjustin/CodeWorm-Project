<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginValidationController;
use App\Http\Controllers\AnaliticsDashboardController;
use App\Http\Controllers\LeaderBoardController;
use App\Http\Controllers\PublicProfileController;

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

// Ajax
Route::post('analitics_dashboard', [AnaliticsDashboardController::class, 'index']);
// End

// Route::get('/', function () {
//     return view('public.index');
// });
// Public
Route::get('/leaderboard', [LeaderBoardController::class, 'index']);
Route::get('/public_profile/{user}', [PublicProfileController::class, 'index'])->name('public_profile');
// End

Route::get('/login', [LoginValidationController::class, 'index'])->name('login');
Route::post('/login_validation', [LoginValidationController::class, 'validate_user'])->name('login_validation');
Route::get('/profile', [LoginValidationController::class, 'profile'])->name('profile');

Route::post('/profile/{user}', [LoginValidationController::class, 'profile_update'])->name('profile_update');
Route::post('/logout', [LoginValidationController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    if(!Auth::check()){
        return redirect()->route('login');
    }
    return view('superadmin.dashboard');
})->name('dashboard');

Route::resource('users', App\Http\Controllers\UsersController::class);

