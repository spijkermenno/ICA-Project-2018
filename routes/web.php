<?php

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

Auth::routes();

Route::get('/register-email', 'Auth\EmailController@showEmailForm')->name('email.verification');
Route::post('/register-email', 'Auth\EmailController@sendVerificationEmail')->name('email.verification.send');

Route::get('/verify-email/{token?}', 'Auth\EmailController@showVerifyForm')->name('email.verify');
Route::post('/verify-email', 'Auth\EmailController@verifyEmail')->name('email.verify.check');

Route::get('/seller', 'User\Seller\VerificationController@showVerificationForm')->name('seller.verify');
Route::post('/seller', 'User\Seller\VerificationController@sendVerification')->name('seller.verify');

Route::get('/seller/creditcard', 'User\Seller\Verification\CreditCardController@showVerificationForm')->name('seller.verify.creditcard');
Route::post('/seller/creditcard', 'User\Seller\Verification\CreditCardController@sendVerification')->name('seller.verify.creditcard');


Route::get('/', 'HomeController@index')->name('home');

Route::get('/rubrieken/', 'RubriekenController@index')->name('rubrieken');
Route::get('/rubriek/{product_id}', 'RubriekenController@rubriek_no_name')->name('rubriek_without_name');
Route::get('/rubriek/{product_id}/{product_name}', 'RubriekenController@rubriek')->name('rubriek_with_name');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/rubrieken/bekijken/{id}', 'RubriekenController@view_rubriek')->name('view_rubriek');
    Route::get('/rubrieken/toevoegen/{parent_id}', 'RubriekenController@new_rubriek')->name('new_rubriek');
    Route::post('/rubrieken/toevoegen/{parent_id}', 'RubriekenController@add_rubriek')->name('add_rubriek');
    Route::get('/rubrieken/bewerken/{id}', 'RubriekenController@edit_rubriek')->name('edit_rubriek');
    Route::post('/rubrieken/bewerken/{id}', 'RubriekenController@update_rubriek')->name('update_rubriek');
    Route::get('/rubrieken/uitfaseren/{id}', 'RubriekenController@show_disable_rubriek')->name('show_disable_rubriek');
    Route::post('/rubrieken/uitfaseren/{id}', 'RubriekenController@disable_rubriek')->name('disable_rubriek');
});

Route::get('/product/{product}', 'ProductController@product_no_name')->name('product_no_name');
Route::get('/product/{product}/{name}', 'ProductController@product_specific')->name('product_specific');
Route::get('/product/', 'ProductController@index')->name('product');

Route::get('/product/toevoegen/', 'AuctionController@index')->name('auction.add');
