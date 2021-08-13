<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'landing');

//static website
Route::view('/about', 'about');
Route::view('/contact', 'contactus');
Route::view('/bru', 'bru');
Route::view('/terms-and-conditions', 'terms_and_condition');
Route::view('/privacy-policy', 'privacy_policy');

Auth::routes();

Route::get('/please-input-aan', 'InputAanController')->name('input.aan');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

//email verifications
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    auth()->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//pennames store
Route::post('/profile/penname', 'PenController@store')->name('penname.store');
Route::post('/profile/penname-picture', 'PenController@updatePicture')->name('penname.update.picture');
Route::delete('/profile/pename/{id}', 'PenController@destroy')->name('penname.destroy');

//admin

Route::prefix('admin')->name('admin.')->group(function () {

    //home
    Route::get('home', 'Admin\HomeController@index')->name('home');
    //auth
    Route::get('login', 'Admin\Auth\LoginController@showLoginForm');
    Route::post('login', 'Admin\Auth\LoginController@login')->name('login');

    //profiles
    Route::get('/profile', 'Admin\ProfileController@index')->name('profile');
    Route::put('/profile', 'Admin\ProfileController@update')->name('profile.update');

    //bin
    Route::get('/bin', 'Admin\BinController@index')->name('bin.index');
    Route::put('/bin/{id}', 'Admin\BinController@restore')->name('bin.restore');

    //merch store
    Route::post('/store', 'Admin\ProductController@store')->name('product.store');
    Route::get('/store', 'Admin\ProductController@index')->name('product.index');
    Route::get('/store/create', 'Admin\ProductController@create')->name('product.add');

    //AAN
    Route::post('/aan', 'Admin\AANController@store')->name('aan.store');
    Route::get('/aan', 'Admin\AANController@index')->name('aan.index');
    Route::delete('/aan/{id}', 'Admin\AANController@destroy')->name('aan.destroy');

    //books
    Route::get('/books/list', 'Admin\BookController@list')->name('books.list');
    Route::put('/books/{book}', 'Admin\BookController@update')->name('books.update');
    Route::get('/books/{book}', 'Admin\BookController@show')->name('books.show');

    //genres
    Route::get('/genres/list', 'Admin\GenreController@list')->name('genres.list');
    Route::post('/genres', 'Admin\GenreController@store')->name('genres.store');
    Route::get('/genres/{genre}', 'Admin\GenreController@show')->name('genres.show');
    Route::put('/genres/{genre}', 'Admin\GenreController@update')->name('genres.update');
    Route::delete('/genres/{genre}', 'Admin\GenreController@destroy')->name('genres.delete');
    Route::get('/tags', 'TagController@index')->name('tags.index');

    //thrailers
    Route::get('/film', 'Admin\ThrailerController@index')->name('thrailers.index');

    //events
    Route::resource('/events', 'Admin\EventController');
    //setting the event day away
    Route::put('/event-day-away/setting', 'Admin\EventSetDayAwayUpdate')->name('event_set_day_away');

    //characters management
    Route::resource('/characters', 'Admin\\CharacterController');
    //pasword generator
    Route::get('/password-generates', 'Admin\\PasswordGeneratorController')->name('password.generate');
    //admins
    Route::resource('/admins', 'Admin\\AdminController');

    //roles
    Route::resource('/roles', 'Admin\\RoleController');

    //admin role
    Route::post('/admin-roles/{admin}', 'Admin\\AdminRoleController@update')->name('toggle-role');

    //arts
    Route::resource('/arts', 'Admin\\ArtController');

    //static
    Route::resource('/about', 'Admin\\AboutPageController');

    //recommendation list page
    Route::resource('/recommendation', 'Admin\\RecommendationController');

    //recommendation remarks
    Route::get('/recommendation-remarks', 'Admin\\RecomRemarksController@index')->name('recom.remarks');

    //music
    Route::resource('/songsgenre', 'Admin\\MusicGenreController');

    //about link account
    Route::resource('/aboutaccount', 'Admin\\AboutAccountController');

    //group approval,
    Route::resource('/group', 'Admin\\GroupController');
    Route::put('/group-disapprove/{id}', 'Admin\\GroupController@updateReason')->name('group.disapprove');

    //create type of group
    Route::resource('/grouptypes', 'Admin\\GroupTypeController');

    //users
    Route::resource('/users', 'Admin\\UserController');

    //ticket for edinting works
    Route::resource('/tickets', 'Admin\\TicketController');

    //messages
    Route::resource('/messages', 'AdminMessageController');

    //message delete all
    Route::post('/messages-delete', 'AdminMessageDeleteController')->name('messages.delete.all');

});

//checkers
Route::post('/aan/checker', 'CheckerController@aanChecker')->name('aan.check');
Route::post('/pen/checker', 'CheckerController@penChecker')->name('pen.check');
Route::post('/email/checker', 'CheckerController@emailChecker')->name('email.check');
Route::post('/genre/checker', 'CheckerController@genreChecker')->name('genre.check');

//books
Route::prefix('books')->name('books.')->middleware(['auth'])->group(function () {
    Route::get('/', 'BookController@index')->name('index');
    Route::get('/list', 'BookController@list')->name('list');
    Route::post('/', 'BookController@store')->name('store');
    Route::put('/front/update/{book}', 'BookController@updateFront')->name('update.front');
    Route::get('/create', 'BookController@create')->name('create');
    Route::get('/{book}', 'BookController@show')->name('show');
    Route::put('/{book}', 'BookController@update')->name('update');
    Route::delete('/{book}', 'BookController@destroy')->name('destroy');

    //chapters preview
    Route::prefix('/{book}/previews-chapters')->name('previews.')->group(function () {
        Route::get('/', 'BookViewerController')->name('show');
    });

    //chapters
    Route::prefix('/{book}/chapters')->name('chapters.')->group(function () {
        Route::get('/', 'ChapterController@index')->name('index');
        Route::post('/', 'ChapterController@store')->name('store');
        Route::get('/create', 'ChapterController@create')->name('create');
        Route::delete('/{chapter}', 'ChapterController@destroy')->name('remove');
        Route::post('/series', 'ChapterController@storeSeries')->name('store.series');
        Route::post('/novel', 'ChapterController@storeNovel')->name('store.novel');
        Route::delete('/series/{b1}', 'ChapterController@removeSeries')->name('remove.series');
        Route::delete('/novel/{chapter}', 'ChapterController@removeNovel')->name('remove.novel');
        Route::get('/{chapter}', 'ChapterController@show')->name('show');
        Route::put('/{chapter}', 'ChapterController@update')->name('update');
    });

    Route::prefix('tags/{book}')->name('tags.')->group(function () {
        Route::post('/', 'TagController@store')->name('store');
    });

    route::get('/update-front/{id}', function ($id) {
        return view('books.update-front', compact('id'));
    })->name('update-front');

});

//arts
Route::prefix('arts')->name('arts.')->middleware(['auth'])->group(function () {
    Route::get('/create', 'ArtSceneController@create')->name('create');
    Route::get('/list', 'ArtSceneController@list')->name('list');
    Route::post('/', 'ArtSceneController@store')->name('store');
    Route::get('/{art}', 'ArtSceneController@show')->name('show');
    Route::put('/{art}', 'ArtSceneController@update')->name('update');
    Route::delete('/{art}', 'ArtSceneController@destroy')->name('destroy');
});

//trailer
Route::prefix('trailers')->name('thrailers.')->middleware(['auth'])->group(function () {
    Route::get('/', 'ThrailerController@index')->name('index');
    Route::post('/{thrailer}/cover', 'ThrailerController@updateCover')->name('cover.update');
    Route::get('/create', 'ThrailerController@create')->name('create');
    Route::get('/{thrailer}', 'ThrailerController@show')->name('show');
    Route::post('/', 'ThrailerController@store')->name('store');
    // Route::get('/{thrailer}/edit', 'ThrailerController@edit')->name('edit');
    Route::put('/{thrailer}', 'ThrailerController@update')->name('update');
    Route::delete('/{thrailer}', 'ThrailerController@destroy')->name('destroy');

});

Route::prefix('marketing')->name('marketing.')->middleware('auth')->group(function () {
    //marketing here
    Route::get('/create', 'MarketingController@createMarketing')->name('create');
    Route::get('/createPdf/{id}', 'MarketingController@createPDF')->name('createPdf');
    Route::get('/{id}', 'MarketingController@show')->name('show');
    Route::get('/', 'MarketingController@index')->name('index');
    Route::post('/', 'MarketingController@store')->name('store');

});

//large video files handler
Route::post('/large-video-uploader', 'VideoUploader')->name('video.uploader');
Route::post('/large-audio-uploader', 'VideoUploader')->name('audio.uploader');

Route::prefix('events')->name('events.')->middleware(['auth'])->group(function () {
    Route::get('/create', 'EventController@create')->name('create');
    Route::post('/', 'EventController@store')->name('store');
    Route::get('/', 'EventController@index')->name('index');
    Route::get('/{event}', 'EventController@show')->name('show');
    Route::put('/update-price/{event}', 'EventController@updatePrizes')->name('update.prizes');
    Route::put('/update-banner/{event}', 'EventController@updateBanner')->name('update.banner');
    Route::put('/update-game-slot/{event}', 'EventController@updateSlot')->name('update.slot');
});

Route::post('questions', 'QuestionController@create')->name('question.create');

Route::resource('audio', 'AudioController');
//update content such as: languages, male, college, blurb etc..,
Route::put('audio/update-some/{audio}', 'AudioController@updateSome')->name('audio.updatesome');

Route::resource('songs', 'SongController')->middleware('auth');
Route::resource('group', 'GroupController')->middleware('auth');
Route::resource('group-member', 'GroupMemberController')->middleware('auth');
Route::resource('inbox', 'InboxController')->middleware('auth');
Route::resource('podcast', 'PodcastController')->middleware('auth');
Route::resource('series', 'SeriesController')->middleware('auth');
Route::resource('collections', 'CollectionController')->middleware('auth');
Route::resource('albums', 'AlbumController')->middleware('auth');

//tickets
Route::prefix('tickets')->name('tickets.')->middleware('auth')->group(function () {
    //delete ticket
    Route::post('delete/book/{book}', 'TicketController@bookDestroy')->name('book.delete');
    Route::post('delete/art/{art}', 'TicketController@artDestroy')->name('art.delete');
    Route::post('delete/chapter/{chapter}', 'TicketController@chapterDestroy')->name('chapter.delete');
    Route::post('delete/trailer/{thrailer}', 'TicketController@thrailerDestroy')->name('thrailer.delete');
    Route::post('delete/audio/{audio}', 'TicketController@audioDestroy')->name('audio.delete');
    Route::post('delete/song/{song}', 'TicketController@songDestroy')->name('song.delete');
    Route::post('delete/podcast/{podcast}', 'TicketController@podcastDestroy')->name('podcast.delete');

    //edit ticket
    Route::post('edit/book/{book}', 'TicketController@bookUpdate')->name('book.update');
    Route::post('edit/art/{art}', 'TicketController@artUpdate')->name('art.update');
    Route::post('edit/chapter/{chapter}', 'TicketController@chapterUpdate')->name('chapter.update');
    Route::post('edit/trailer/{thrailer}', 'TicketController@thrailerUpdate')->name('thrailer.update');
    Route::post('edit/audio/{audio}', 'TicketController@audioUpdate')->name('audio.update');
    Route::post('edit/song/{song}', 'TicketController@songUpdate')->name('song.update');
    Route::post('edit/podcast/{podcast}', 'TicketController@podcastUpdate')->name('podcast.update');

});

// images
Route::prefix('admin/images')->name('admin.images.')->middleware('auth:admin')->group(function () {
    Route::get('/', 'Admin\ImageManagementController@index')->name('menu');

    Route::delete('/marquee-announcement/{id}', 'Admin\ImageManagementController@removeAnnouncement')->name('announcement.remove');
    Route::get('/marquee-announcement', 'Admin\ImageManagementController@announcementInMarquee')->name('announcement');
    Route::post('/marquee-announcement', 'Admin\ImageManagementController@storeAnnouncementInMarquee')->name('announcement.store');

    Route::delete('/banners/{id}', 'Admin\ImageManagementController@removeBanner')->name('banner.remove');
    Route::get('/banners', 'Admin\ImageManagementController@banner')->name('banner');
    Route::post('/banners', 'Admin\ImageManagementController@storeBanner');

    Route::delete('/preloaders/{id}', 'Admin\ImageManagementController@removePreloader')->name('preloader.remove');
    Route::get('/preloaders', 'Admin\ImageManagementController@preloaders')->name('preloader');
    Route::post('/preloaders', 'Admin\ImageManagementController@storePreloader');

    Route::delete('/bulletin/{id}', 'Admin\ImageManagementController@removeBulletin')->name('bulletin.remove');
    Route::get('/bulletin', 'Admin\ImageManagementController@bulletin')->name('bulletin');
    Route::post('/bulletin', 'Admin\ImageManagementController@storeBulletin');

    Route::delete('/newspaper/{id}/page', 'Admin\ImageManagementController@removePageNewspaper')->name('newspaper.page.remove');
    Route::delete('/newspaper/{id}', 'Admin\ImageManagementController@removeNewspaper')->name('newspaper.remove');
    Route::get('/newspaper/{id}', 'Admin\ImageManagementController@showNewspaper')->name('newspaper.show');
    Route::post('/newspaper/{id}', 'Admin\ImageManagementController@storePageNewspaper')->name('newspaper.page');
    Route::get('/newspaper', 'Admin\ImageManagementController@newspaper')->name('newspaper');
    Route::post('/newspaper', 'Admin\ImageManagementController@storeNewspaper');
});
// end of images

//please contact route
Route::get('please-contact', 'PleaseContactController')->name('please-contact');
//please download route
Route::get('reader-please-download', 'PleaseDownloadController')->name('please-download');

// ajax
Route::post('password-confirm', function () { //to check the password
    $ipassword = request()->password;
    return Hash::check($ipassword, auth()->guard('admin')->user()->password);
})->name('password-confirm');

//
Route::post('autofill-aduio-book', 'autoFillController')->name('auto.fill');

//support chat //customer support
Route::view('support-chat', 'support_chat');

//payment
Route::get('payment-pay', 'PaymentController@pay')->name('payment.pay');
Route::get('payment-success', 'PaymentController@success')->name('payment.success');
Route::get('payment-failed', 'PaymentController@success')->name('payment.failed');

// banner
Route::view('/banner-for-mobile', 'banner');

Route::view('/users', 'users-contact');

Route::view('/banner-maker', 'banner_editor')->middleware('auth');

Route::get('/test', function () {
    return 'hello world 1';
});
