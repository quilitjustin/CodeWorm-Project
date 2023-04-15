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

Route::get('/', function () {
    return redirect()->route('super.dashboard');
});

Route::middleware([SuperIsLoggedIn::class])->group(function () {
    //ajax 
    Route::controller(FetchController::class)->group(function(){
        Route::get('/fetch/languages', 'languages')->name('super.fetch.languages');
        Route::post('/fetch/tasks', 'tasks')->name('super.fetch.tasks');
    });
    
    Route::controller(LoginValidationController::class)->group(function () {
        Route::get('/login', 'index')
            ->name('super.login')
            ->withoutMiddleware([SuperIsLoggedIn::class]);
        Route::post('/authenticate', 'authenticate')
            ->name('super.authenticate')
            ->withoutMiddleware([SuperIsLoggedIn::class]);
        Route::get('/profile/edit', 'profile')->name('super.profile');
        Route::put('/profile/{user}', 'profile_update')->name('super.profile_update');
        Route::post('/logout', 'logout')->name('super.logout');
    });

    Route::controller(InquiriesController::class)->group(function () {
        Route::get('/inquiries', 'index')->name('super.inquiries.index');
        Route::get('/inquiries/{inquiries}', 'show')->name('super.inquiries.show');
    });

    Route::controller(ExportController::class)->group(function () {
        Route::get('/export', 'index')->name('super.export.index');
        Route::get('/export/export_db', 'export_db')->name('super.export.export_db');
    });

    Route::get('/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('super.dashboard');

    Route::put('/users/ban/{user}', 'UsersController@ban_user')->name('super.user.ban');
    Route::resource('/users', UsersController::class);
    Route::resource('/badges', BadgesController::class);
    Route::resource('/announcements', AnnouncementsController::class);
    // Game Routes
    Route::resource('/game/programming/proglangs', ProgrammingLanguageController::class);
    Route::resource('/game/programming/stages', StagesController::class);
    Route::resource('/game/programming/tasks', TasksController::class);
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
