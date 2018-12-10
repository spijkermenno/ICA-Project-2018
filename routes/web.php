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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/rubrieken/', 'RubriekenController@index')->name('rubrieken');
Route::get('/rubriek/{product_id}', 'RubriekenController@rubriek_no_name')->name('rubriek_without_name');
Route::get('/rubriek/{product_id}/{product_name}', 'RubriekenController@rubriek')->name('rubriek_with_name');

Route::get('/product/{product}/{name}', 'ProductController@product_specific')->name('product');
Route::get('/product/', 'ProductController@index')->name('product');
