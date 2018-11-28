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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/rubrieken', 'RubriekenController@index')->name('rubrieken');
Route::get('/product/{product}/{name}', 'ProductController@product_specific')->name('product');
Route::get('/product/', 'ProductController@index')->name('product');
