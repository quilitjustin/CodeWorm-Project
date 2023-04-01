<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsLoggedIn;

/*
|--------------------------------------------------------------------------
| SuperAdmin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your superadmin user. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return redirect()->route('dashboard');
});

Route::middleware([IsLoggedIn::class])->group(function () {
    Route::controller(LoginValidationController::class)->group(function () {
        Route::get('/login', 'index')->name('login')->withoutMiddleware([IsLoggedIn::class]);
        Route::post('/login_validation', 'validate_user')->name('login_validation')->withoutMiddleware([IsLoggedIn::class]);
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile/{user}', 'profile_update')->name('profile_update');
        Route::post('/logout', 'logout')->name('logout');
    });
    
    Route::get('/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('dashboard');
    
    Route::resource('/users', UsersController::class);
    Route::resource('/badges', BadgesController::class);
    Route::resource('/announcements', AnnouncementsController::class);  
    // Game Routes
    Route::resource('/game/proglangs', ProgLang::class);
    Route::resource('/game/bgms', BGMController::class);
    Route::resource('/game/bgims', BGImgController::class);
    Route::resource('/game/effects/sfxs', SoundEffectController::class);
    Route::resource('/game/effects/vfxs', VisualEffectController::class);
    // End game
    
    Route::controller(SplashPageController::class)->group(function () {
        Route::get('/splash', 'index')->name('splash.index');
        Route::get('/splash/show/{id}', 'show')->name('splash.show');
        Route::post('/splash/store', 'store')->name('splash.store');
        Route::delete('/splash/destroy/{id}', 'destroy')->name('splash.destroy');
    });
});
