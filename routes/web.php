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

// Login and register
Auth::routes();

Route::get('/register-email', 'Auth\EmailController@showEmailForm')->name('email.verification');
Route::post('/register-email', 'Auth\EmailController@sendVerificationEmail')->name('email.verification.send');

Route::get('/verify-email/{token?}', 'Auth\EmailController@showVerifyForm')->name('email.verify');
Route::post('/verify-email', 'Auth\EmailController@verifyEmail')->name('email.verify.check');

// Application
Route::get('/', 'HomeController@index')->name('home');

Route::get('/categories', 'CategoryController@index')->name('rubrieken');
Route::get('/categories/{category_id}', 'CategoryController@rubriek_no_name')->name('rubriek_without_name');
Route::get('/categories/{category_id}/{category_name}', 'CategoryController@rubriek')->name('rubriek_with_name');

Route::get('/products/{product}', 'ProductController@productNoName')->name('product_no_name');
Route::get('/products/{product}/{name}', 'ProductController@productSpecific')->name('product_specific');
Route::get('/products', 'ProductController@index')->name('product');

Route::get('/search', 'SearchController')->name('search');

Route::post('/bids/add', 'BidsController@create_bid')->name('bid.create');

// Login protection
Route::middleware('auth:web')
    ->group(function () {
        // Becoming a seller
        Route::middleware([
            'not.seller'
        ])
            ->prefix('seller')
            ->namespace('User\Seller')
            ->group(function () {
                Route::middleware('not.verified.seller')->group(function () {
                    Route::get('/', 'VerificationController@showVerificationForm')->name('seller.verify');
                    Route::post('/', 'VerificationController@sendVerification')->name('seller.verify');
                });

                Route::namespace('Verification')
                    ->group(function () {
                        Route::middleware('not.verified.seller:creditcard')
                            ->group(function () {
                                Route::get('/creditcard', 'CreditCardController@showVerificationForm')->name('seller.verify.creditcard');
                                Route::post('/creditcard', 'CreditCardController@sendVerification')->name('seller.verify.creditcard');
                            });

                        Route::middleware('not.verified.seller:mail')
                            ->group(function () {
                                Route::get('/mail', 'MailController@showVerificationForm')->name('seller.verify.mail');
                                Route::post('/mail', 'MailController@sendVerification')->name('seller.verify.mail');
                            });
                    });

                Route::middleware('verified.seller')
                    ->group(function () {
                        Route::get('/register', 'RegisterController@showRegisterForm')->name('seller.register');
                        Route::post('/register', 'RegisterController@create')->name('seller.register');
                    });
            });
        Route::middleware('seller')
            ->group(function () {
                Route::get('/account/auctions', 'AuctionController@myAuctions')->name('account.auctions');
            });
        Route::middleware('seller')
            ->prefix('seller')
            ->group(function () {
                Route::get('/products/create', 'AuctionController@index')->name('auction.add');

                Route::post('/products/create', 'AuctionController@newProduct')->name('auction.add.check');
            });

        Route::middleware('admin')
            ->prefix('admin')
            ->group(function () {
                Route::get('/verifications/sellers', 'User\Admin\Verifications\Seller\MailController@showVerificationLetter')->name('admin.verifications.seller.letter');
                Route::post('/verifications/sellers/sent', 'User\Admin\Verifications\Seller\MailController@markLetterSent')->name('admin.verifications.seller.letter.sent');

                Route::get('/categories/add/{parent_id}', 'CategoryController@new_rubriek')->name('new_rubriek');
                Route::post('/categories/add/{parent_id}', 'CategoryController@add_rubriek')->name('add_rubriek');
                Route::get('/categories/edit/{id}', 'CategoryController@edit_rubriek')->name('edit_rubriek');
                Route::post('/categories/edit/{id}', 'CategoryController@update_rubriek')->name('update_rubriek');
                Route::get('/categories/remove/{id}', 'CategoryController@show_disable_rubriek')->name('show_disable_rubriek');
                Route::post('/categories/remove/{id}', 'CategoryController@disable_rubriek')->name('disable_rubriek');

                Route::get('/categories/{id}', 'CategoryController@view_rubriek')->name('view_rubriek');
            });
    });

Route::get('/account/biedingen', 'MyBidsController')->name('account.my_bids');
