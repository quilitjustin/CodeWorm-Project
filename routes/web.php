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

// Ajax
Route::controller(LiveSearchController::class)->group(function () {
    Route::get('/search/portfolio', 'public_portfolio')->name('search.portfolio');
});
Route::post('/inquiries', 'InquiriesController@store')->name('web.inquiries.store');
// End

// Public
Route::controller(PasswordResetController::class)->group(function(){
    Route::get('/password/forgot', 'index')->name('password.forgot');
    Route::post('/password/request', 'request')->name('password.request');
    Route::get('/password/reset/{token}', 'reset')->name('password.reset');
    Route::post('/password/update', 'update')->name('password.update');
})->middleware('guest');
Route::get('/', 'SplashPageController@index');
Route::controller(LeaderBoardController::class)->group(function () {
    Route::get('/leaderboard', 'index')->name('web.leaderboard.index');
    Route::post('/leaderboard/entry', 'entry')->name('web.leaderboards.entry');
});
Route::controller(PublicProfileController::class)->group(function () {
    Route::get('/public_profile', 'index')->name('public_profile.index');
    Route::get('/public_profile/{user}', 'show')->name('public_profile.show');
});

// End

Route::middleware([WebIsLoggedIn::class])->group(function () {
    Route::get('announcements', 'AnnouncementsController@index')->name('web.announcements.index');

    Route::controller(LoginValidationController::class)->group(function () {
        Route::get('/login', 'index')
            ->name('web.login')
            ->withoutMiddleware([WebIsLoggedIn::class]);
        Route::post('/authenticate', 'authenticate')
            ->name('web.authenticate')
            ->withoutMiddleware([WebIsLoggedIn::class]);
        Route::get('/profile/edit', 'profile')->name('web.profile');
        Route::put('/profile/{user}', 'profile_update')->name('web.profile_update');
        Route::post('/logout', 'logout')->name('web.logout');
    });

    Route::controller(PlayController::class)->group(function(){
        Route::get('/play', 'index')->name('web.play.index');
        Route::get('/play/{id}/stages', 'stages')->name('web.play.stages');
        Route::post('/play/save_record', 'save_record')->name('web.play.store');
        Route::get('/play/start/{id}', 'game_start')->name('web.play.start');
    });

    Route::controller(StoryController::class)->group(function(){
        Route::get('/stories', 'index')->name('web.stories.index');
        Route::get('/stories/{id}', 'show')->name('web.stories.show');
    });

    Route::get('/forums', function(){
        return view('web.construction');
    });

    // Route::get('play', function () {
    //     return view('layouts.play');
    // });
    // Route::get('play/js', function () {
    //     return view('layouts.play_js');
    // })->name('web.play.js');
    // Route::get('play/php', function () {
    //     return view('layouts.play_php');
    // })->name('web.play.php');
});
