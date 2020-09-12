<?php

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

//Static Pages
Route::get('/', function () {
    $payment_options = collect(range(1, 20))->mapWithKeys(function ($item) {
        $amount = $item*50;
        return [$amount => $amount];
    });
    return view('welcome', compact('payment_options'));
});
Route::get('/faq', function () {
    return view('/pages/faq');
});
Route::get('/articles', function () {
    return view('/pages/articles');
});

Route::get('/contact', 'ContactController@index')->name('contact.index');
Route::post('/contact', 'ContactController@mail')->name('contact.mail');

Auth::routes();
Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
Route::get('/callback/{provider}', 'SocialController@callback');

Route::get('lang/{locale}', 'LangController@lang')->name('lang');

Route::get('/my-account', 'HomeController@index')->name('home');
Route::get('/my-account/edit', 'HomeController@edit')->name('home.edit');
Route::post('/my-account/edit', 'HomeController@update')->name('home.update');
Route::post('/action/invite', 'HomeController@invite')->name('home.invite');

Route::get('/wishlists', 'WishlistController@index')->name('wishlists');
Route::post('/wishlists/{classified_ad_id}', 'WishlistController@create')->name('wishlists.create');
Route::delete('/wishlists/{classified_ad_id}', 'WishlistController@delete')->name('wishlists.create');

Route::get('ads', 'AdController@index')->name('ads.index');
Route::post('ads', 'AdController@store')->name('ads.store')->middleware('auth');
Route::get('ads/create', 'AdController@create')->name('ads.create')->middleware('auth');
Route::get('ads/{id}', 'AdController@show')->name('ads.show');
Route::get('ads/{id}/review', 'AdController@review')->name('ads.review');
Route::put('ads/{id}', 'AdController@update')->name('ads.update')->middleware('auth');
Route::get('ads/{id}/edit', 'AdController@edit')->name('ads.edit')->middleware('auth');

Route::post('ads/next', 'AdController@next')->name('ads.next');
Route::put('ads/nextupdate/{id}', 'AdController@nextUpdate')->name('ads.nextupdate');

Route::delete('files/{id}', 'AdController@deleteFile')->name('ads.files.delete');

Route::middleware(['auth'])->group(function () {
    Route::get('/payment/{id?}', 'PaymentController@plans')->name('payment.plans');
    Route::post('/payment/{id?}', 'PaymentController@charge')->name('payment.charge');
    Route::post('/payment/action/applyvoucher/{voucher}', 'PaymentController@voucher')->name('payment.voucher');

    Route::get('/partners/create', 'PartnerController@create')->name('partners.create');
    Route::post('/partners/store', 'PartnerController@store')->name('partners.store');
    Route::get('/partners/promocode', 'PartnerController@promocode')->name('partners.promocode');
    Route::post('/partners/action/reject/{id}', 'PartnerController@reject')->name('partners.reject');
    Route::post('/partners/action/approve', 'PartnerController@approve')->name('partners.approve');

    /** ads section**/
        Route::get('/classified_ads/create/{cat_id?}', 'ClassifiedAdController@create')->name('classified_ads.create');
        Route::post('/classified_ads/store/{cat_id}', 'ClassifiedAdController@store')->name('classified_ads.store');
        Route::resource('classified_ads', 'ClassifiedAdController')->except([
            'create', 'store', 'create'
        ]);

        Route::post('/feedback/create/{classified_ad}', 'FeedbackController@create')->name('feedbacks.create');
        Route::get('/messages', 'ChatRoomController@index')->name('chatrooms.index');
        Route::get('/messages/{chat_room_id}', 'FeedbackController@show')->name('feedbacks.show');
        Route::post('/feedback/reply/{chat_room_id}', 'FeedbackController@reply')->name('feedbacks.reply');
    /** end of ads section**/
});

Route::middleware(['auth','admin'])->prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index');
    Route::get('/partners', 'AdminController@partners')->name('admin.partners');
    Route::get('/partnersales', 'AdminController@partnerSales')->name('admin.partnersales');
    Route::get('/history', 'AdminController@history')->name('admin.history');

    /** Category and  formItems section**/
        Route::resource('categories', 'CategoryController');
        Route::get('/classified_ads/toggle/{classified_ad}', 'ClassifiedAdController@toggle')->name('classified_ads.toggle');

        // Route::get('/add_field_items_to_form/{id}', 'FormItemController@add')->name('form_items.add');
        // Route::post('/store_field_items_to_form/{id}', 'FormItemController@store')->name('form_items.store');
        // Route::get('/edit_field_items_to_form/{id}', 'FormItemController@edit')->name('form_items.edit');
        // Route::put('/update_field_items_to_form/{id}', 'FormItemController@update')->name('form_items.update');
    /** end of Category and  formItems  section**/
});


Route::get('/temp', function(){
    dd();
});


