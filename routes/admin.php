<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminIsLoggedIn;

/*
|--------------------------------------------------------------------------
| SuperAdmin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your admin user. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});
Route::controller(PasswordResetController::class)->group(function(){
    Route::get('/password/forgot', 'index')->name('admin.password.forgot');
    Route::post('/password/request', 'request')->name('admin.password.request');
    Route::get('/password/reset/{token}', 'reset')->name('admin.password.reset');
    Route::post('/password/update', 'update')->name('admin.password.update');
})->middleware('guest');

Route::middleware([AdminIsLoggedIn::class])->group(function () {
    //ajax 
    Route::controller(FetchController::class)->group(function(){
        Route::get('/fetch/languages', 'languages')->name('admin.fetch.languages');
        Route::post('/fetch/tasks', 'tasks')->name('admin.fetch.tasks');
    });
    Route::get('/analitics_dashboard', 'AnaliticsDashboardController@index')->name('admin.analytics.index');
    // End ajax

    Route::controller(EnvEditorController::class)->group(function(){
        Route::get('/env/code_executor', 'code_executor')->name('admin.env.executor');
        Route::post('/env/code_executor/update', 'update_code_executor')->name('admin.env.executor.update');
    });

    Route::controller(LoginValidationController::class)->group(function () {
        Route::get('/login', 'index')
            ->name('admin.login')
            ->withoutMiddleware([AdminIsLoggedIn::class]);
        Route::post('/authenticate', 'authenticate')
            ->name('admin.authenticate')
            ->withoutMiddleware([AdminIsLoggedIn::class]);
        Route::get('/profile/edit', 'profile')->name('admin.profile');
        Route::put('/profile/{user}', 'profile_update')->name('admin.profile_update');
        Route::post('/logout', 'logout')->name('admin.logout');
    });

    Route::controller(InquiriesController::class)->group(function () {
        Route::get('/inquiries', 'index')->name('admin.inquiries.index');
        Route::get('/inquiries/{inquiries}', 'show')->name('admin.inquiries.show');
    });

    Route::controller(ExportController::class)->group(function () {
        Route::get('/export', 'index')->name('admin.export.index');
        Route::get('/export/export_db', 'export_db')->name('admin.export.export_db');
    });

    Route::get('/dashboard', function () {
        return view('admin..dashboard');
    })->name('admin.dashboard');

    Route::put('/users/ban/{user}', 'UsersController@ban_user')->name('admin.user.ban');
    Route::resource('/users', UsersController::class)->names('admin.users');

    Route::resource('/announcements', AnnouncementsController::class)->names('admin.announcements');
    Route::resource('/stories', StoryController::class)->names('admin.stories');
    // Game Routes
    Route::resource('/game/programming/proglangs', ProgrammingLanguageController::class)->names('admin.proglangs');
    Route::resource('/game/programming/stages', StagesController::class)->names('admin.stages');
    Route::resource('/game/programming/tasks', TasksController::class)->names('admin.tasks');
    Route::resource('/badges', BadgesController::class)->names('admin.badges');
    Route::resource('/game/bgms', BGMController::class)->names('admin.bgms');
    Route::resource('/game/bgims', BGImgController::class)->names('admin.bgims');
    // Route::resource('/game/effects/sfxs', SoundEffectController::class)->names('admin.sfxs');
    // Route::resource('/game/effects/vfxs', VisualEffectController::class)->names('admin.vfxs');
    // End game

    // Cms Routes
    // Route::resource('cms/bgim/cmsleaderboards', CmsLeaderboardController::class);
    Route::controller(CMSController::class)->group(function(){
        Route::get('cms/bgim/create', 'create')->name('admin.cms.bgim.create');
        Route::get('cms/logo/create', 'create_logo')->name('admin.cms.logo.create');
        Route::post('cms/bgim/store', 'store')->name('admin.cms.bgim.store');
        Route::post('cms/logo/store', 'store_logo')->name('admin.cms.logo.store');
        Route::delete('cms/bgim/destroy/{id}', 'destroy')->name('admin.cms.bgim.destroy');
        Route::delete('cms/logo/{id}', 'destroy_logo')->name('admin.cms.logo.destroy');
        Route::post('set_leaderboard_background', 'set_leaderboard_background')->name('admin.cms.bgim.leaderboard.set');
        Route::post('set_play_background', 'set_play_background')->name('admin.cms.bgim.play.set');
        Route::post('set_splash_background', 'set_splash_background')->name('admin.cms.bgim.splash.set');
        Route::post('set_announcements_background', 'set_announcement_background')->name('admin.cms.bgim.announcement.set');
        Route::post('set_stalk_background', 'set_stalk_background')->name('admin.cms.bgim.stalk.set');
        Route::post('set_login_background', 'set_login_background')->name('admin.cms.bgim.login.set');
        Route::post('set_logo', 'set_logo')->name('admin.cms.logo.set');
        Route::get('cms/bgim/leaderboards', 'leaderboard_index')->name('admin.cms.bgim.leaderboards.index');
        Route::get('cms/bgim/play', 'play_index')->name('admin.cms.bgim.play.index');
        Route::get('cms/bgim/announcement', 'announcement_index')->name('admin.cms.bgim.announcement.index');
        Route::get('cms/bgim/stalk', 'stalk_index')->name('admin.cms.bgim.stalk.index');
        Route::get('cms/bgim/splash', 'splash_index')->name('admin.cms.bgim.splash.index');
        Route::get('cms/bgim/login', 'login_index')->name('admin.cms.bgim.login.index');
        Route::get('cms/logo', 'logo_index')->name('admin.cms.logo.index');
    });
    // End Cms

    Route::controller(SplashPageController::class)->group(function () {
        Route::get('/splash', 'index')->name('admin.splash.index');
        Route::get('/splash/show/{id}', 'show')->name('admin.splash.show');
        Route::post('/splash/store', 'store')->name('admin.splash.store');
        Route::delete('/splash/destroy/{id}', 'destroy')->name('admin.splash.destroy');
    });
});
