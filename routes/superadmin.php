<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SuperIsLoggedIn;

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
    return redirect()->route('super.dashboard');
});

Route::middleware([SuperIsLoggedIn::class])->group(function () {
    Route::controller(LoginValidationController::class)->group(function () {
        Route::get('/login', 'index')->name('super.login')->withoutMiddleware([SuperIsLoggedIn::class]);
        Route::post('/authenticate', 'authenticate')->name('super.authenticate')->withoutMiddleware([SuperIsLoggedIn::class]);
        Route::get('/profile/edit', 'profile')->name('super.profile');
        Route::put('/profile/{user}', 'profile_update')->name('super.profile_update');
        Route::post('/logout', 'logout')->name('super.logout');
    });
    
    Route::get('/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('super.dashboard');
    
    Route::resource('/users', UsersController::class);
    Route::resource('/badges', BadgesController::class);
    Route::resource('/announcements', AnnouncementsController::class);  
    // Game Routes
    Route::resource('/game/proglangs', ProgrammingLanguageController::class);
    Route::get('/game/stages/create/{proglang}', 'StagesController@create')->name('stages.create');
    Route::get('/game/stages/redirect', 'StagesController@redirect')->name('stages.redirect');
    Route::resource('/game/stages', StagesController::class)->except(['create']);
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
