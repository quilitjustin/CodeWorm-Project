<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\WebIsLoggedIn;

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

Route::get('test', function () {
    return view('text');
});

// Ajax
Route::controller(LiveSearchController::class)->group(function () {
    Route::get('/search/portfolio', 'public_portfolio')->name('search.portfolio');
});
Route::post('analitics_dashboard', [AnaliticsDashboardController::class, 'index']);
Route::post('/inquiries', 'InquiriesController@store')->name('web.inquiries.store');
// End

// Public
Route::get('/', 'SplashPageController@index');
Route::get('/leaderboard', 'LeaderBoardController@index');
Route::controller(PublicProfileController::class)->group(function () {
    Route::get('/public_profile', 'index')->name('public_profile.index');
    Route::get('/public_profile/{user}', 'show')->name('public_profile.show');
});

// End

Route::middleware([WebIsLoggedIn::class])->group(function () {
    // Ajax
    Route::controller(FetchController::class)->group(function(){
        Route::get('/fetch/php', 'fetch_task_php')->name('fetch.php');
        Route::get('/fetch/js', 'fetch_task_js')->name('fetch.js');
    });
    // End Ajax

    Route::get('announcements', 'AnnouncementsController@index')->name('web.announcements.index');

    Route::controller(LoginValidationController::class)->group(function () {
        Route::get('/login', 'index')
            ->name('web.login')
            ->withoutMiddleware([WebIsLoggedIn::class]);
        Route::post('/authenticate', 'authenticate')
            ->name('web.authenticate')
            ->withoutMiddleware([WebIsLoggedIn::class]);
        Route::get('/profile/edit', 'profile')->name('web.profile');
        Route::post('/profile/{user}', 'profile_update')->name('web.profile_update');
        Route::post('/logout', 'logout')->name('web.logout');
    });

    Route::controller(PlayController::class)->group(function(){
        Route::get('/play', 'index')->name('web.play.index');
        Route::get('/play/{id}/stages', 'stages')->name('web.play.stages');
        Route::post('/play/save_record', 'save_record')->name('web.play.store');
        Route::get('/play/start/{id}', 'game_start')->name('web.play.start');
    });

    Route::get('/forums', function(){
        return view('web.construction');
    });

    // Route::get('play', function () {
    //     return view('layouts.play');
    // });
    Route::get('play/js', function () {
        return view('layouts.play_js');
    })->name('web.play.js');
    Route::get('play/php', function () {
        return view('layouts.play_php');
    })->name('web.play.php');
});
