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
Route::controller(PasswordResetController::class)
    ->group(function () {
        Route::get('/password/forgot', 'index')->name('super.password.forgot');
        Route::post('/password/request', 'request')->name('super.password.request');
        Route::get('/password/reset/{token}', 'reset')->name('super.password.reset');
        Route::post('/password/update', 'update')->name('super.password.update');
    })
    ->middleware('guest');

Route::middleware([SuperIsLoggedIn::class])->group(function () {
    //ajax
    Route::controller(FetchController::class)->group(function () {
        Route::get('/fetch/languages', 'languages')->name('super.fetch.languages');
        Route::post('/fetch/tasks', 'tasks')->name('super.fetch.tasks');
    });

    Route::controller(AnaliticsDashboardController::class)->group(function(){
        Route::get('/analitics_dashboard', 'index')->name('super.analytics.index');
        Route::get('/analytics/user_reg_count', 'user_reg_count')->name('super.analytics.user_reg_count');
    });
    // End ajax

    Route::controller(EnvEditorController::class)->group(function () {
        Route::get('/env/code_executor', 'code_executor')->name('super.env.executor');
        Route::post('/env/code_executor/update', 'update_code_executor')->name('super.env.executor.update');
    });

    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')
            ->name('super.login')
            ->withoutMiddleware([SuperIsLoggedIn::class]);
        Route::post('/authenticate', 'authenticate')
            ->name('super.authenticate')
            ->withoutMiddleware([SuperIsLoggedIn::class]);
        Route::get('/profile/edit', 'profile')->name('super.profile');
        Route::put('/profile/{user}', 'profile_update')->name('super.profile_update');
        Route::get('/profile/upload_picture', 'upload_picture')->name('super.profile.upload_picture');
        Route::post('/logout', 'logout')->name('super.logout');
    });

    Route::controller(InquiriesController::class)->group(function () {
        Route::get('/inquiries', 'index')->name('super.inquiries.index');
        Route::get('/inquiries/{inquiries}', 'show')->name('super.inquiries.show');
    });

    Route::controller(DBController::class)->group(function () {
        Route::get('/db', 'index')->name('super.db.index');
        Route::get('/db/export', 'export')->name('super.db.export');
        Route::post('/db/import', 'import')->name('super.db.import');
    });

    Route::get('/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('super.dashboard');

    Route::put('/users/ban/{user}', 'UsersController@suspend_user')->name('super.users.suspend');
    Route::put('/users/activate/{user}', 'UsersController@activate_user')->name('super.users.activate');
    Route::resource('/users', UsersController::class)->names('super.users');

    Route::put('/announcements/pin/{announcement}', 'AnnouncementsController@pin')->name('super.announcements.pin');
    Route::resource('/announcements', AnnouncementsController::class)->names('super.announcements');
    Route::resource('/stories', StoryController::class)->names('super.stories');
    // Game Routes
    Route::resource('/game/programming/proglangs', ProgrammingLanguageController::class)->names('super.proglangs');
    Route::resource('/game/programming/stages', StagesController::class)->names('super.stages');
    Route::resource('/game/programming/tasks', TasksController::class)->names('super.tasks');
    Route::resource('/game/reward/badges', BadgesController::class)->names('super.badges');
    Route::resource('/game/bgms', BGMController::class)->names('super.bgms');
    Route::resource('/game/bgims', BGImgController::class)->names('super.bgims');
    // Route::resource('/game/effects/sfxs', SoundEffectController::class)->names('super.sfxs');
    // Route::resource('/game/effects/vfxs', VisualEffectController::class)->names('super.vfxs');
    // End game

    // Cms Routes
    // Route::resource('cms/bgim/cmsleaderboards', CmsLeaderboardController::class);
    Route::controller(CMSController::class)->group(function () {
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
        Route::get('/cms/splash', 'index')->name('super.cms.splash.index');
        Route::get('/cms/splash/show/{id}', 'show')->name('super.cms.splash.show');
        Route::post('/cms/splash/store', 'store')->name('super.cms.splash.store');
        Route::delete('/cms/splash/destroy/{id}', 'destroy')->name('super.cms.splash.destroy');
    });

    Route::controller(RequestRegistrationController::class)->group(function () {
        Route::get('/reqregs', 'index')->name('super.request_registration.index');
        Route::get('/reqregs/show/{id}', 'show')->name('super.request_registration.show');
        Route::put('/reqregs/update/{id}', 'update')->name('super.request_registration.update');
    });
});
