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
Route::controller(PasswordResetController::class)->group(function(){
    Route::get('/password/forgot', 'index')->name('super.password.forgot');
    Route::post('/password/request', 'request')->name('super.password.request');
    Route::get('/password/reset/{token}', 'reset')->name('super.password.reset');
    Route::post('/password/update', 'update')->name('super.password.update');
})->middleware('guest');

Route::middleware([SuperIsLoggedIn::class])->group(function () {
    //ajax 
    Route::controller(FetchController::class)->group(function(){
        Route::get('/fetch/languages', 'languages')->name('super.fetch.languages');
        Route::post('/fetch/tasks', 'tasks')->name('super.fetch.tasks');
    });
    Route::get('analitics_dashboard', 'AnaliticsDashboardController@index')->name('super.analytics.index');
    // End ajax

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
    Route::resource('/users', UsersController::class)->names('super.users');

    Route::resource('/announcements', AnnouncementsController::class)->names('super.announcements');
    Route::resource('/stories', StoryController::class)->names('super.stories');
    // Game Routes
    Route::resource('/game/programming/proglangs', ProgrammingLanguageController::class)->names('super.proglangs');
    Route::resource('/game/programming/stages', StagesController::class)->names('super.stages');
    Route::resource('/game/programming/tasks', TasksController::class)->names('super.tasks');
    Route::resource('/badges', BadgesController::class)->names('super.badges');
    Route::resource('/game/bgms', BGMController::class)->names('super.bgms');
    Route::resource('/game/bgims', BGImgController::class)->names('super.bgims');
    // Route::resource('/game/effects/sfxs', SoundEffectController::class)->names('super.sfxs');
    // Route::resource('/game/effects/vfxs', VisualEffectController::class)->names('super.vfxs');
    // End game

    // Cms Routes
    // Route::resource('cms/bgim/cmsleaderboards', CmsLeaderboardController::class);
    Route::controller(CMSController::class)->group(function(){
        Route::get('cms/bgim/create', 'create')->name('super.cms.bgim.create');
        Route::get('cms/logo/create', 'create_logo')->name('super.cms.logo.create');
        Route::post('cms/bgim/store', 'store')->name('super.cms.bgim.store');
        Route::post('cms/logo/store', 'store_logo')->name('super.cms.logo.store');
        Route::delete('cms/bgim/destroy/{id}', 'destroy')->name('super.cms.bgim.destroy');
        Route::delete('cms/logo/{id}', 'destroy_logo')->name('super.cms.logo.destroy');
        Route::post('set_leaderboard_background', 'set_leaderboard_background')->name('super.cms.bgim.leaderboard.set');
        Route::post('set_play_background', 'set_play_background')->name('super.cms.bgim.play.set');
        Route::post('set_splash_background', 'set_splash_background')->name('super.cms.bgim.splash.set');
        Route::post('set_announcements_background', 'set_announcement_background')->name('super.cms.bgim.announcement.set');
        Route::post('set_stalk_background', 'set_stalk_background')->name('super.cms.bgim.stalk.set');
        Route::post('set_login_background', 'set_login_background')->name('super.cms.bgim.login.set');
        Route::post('set_logo', 'set_logo')->name('super.cms.logo.set');
        Route::get('cms/bgim/leaderboards', 'leaderboard_index')->name('super.cms.bgim.leaderboards.index');
        Route::get('cms/bgim/play', 'play_index')->name('super.cms.bgim.play.index');
        Route::get('cms/bgim/announcement', 'announcement_index')->name('super.cms.bgim.announcement.index');
        Route::get('cms/bgim/stalk', 'stalk_index')->name('super.cms.bgim.stalk.index');
        Route::get('cms/bgim/splash', 'splash_index')->name('super.cms.bgim.splash.index');
        Route::get('cms/bgim/login', 'login_index')->name('super.cms.bgim.login.index');
        Route::get('cms/logo', 'logo_index')->name('super.cms.logo.index');
    });
    // End Cms

    Route::controller(SplashPageController::class)->group(function () {
        Route::get('/splash', 'index')->name('super.splash.index');
        Route::get('/splash/show/{id}', 'show')->name('super.splash.show');
        Route::post('/splash/store', 'store')->name('super.splash.store');
        Route::delete('/splash/destroy/{id}', 'destroy')->name('super.splash.destroy');
    });
});
