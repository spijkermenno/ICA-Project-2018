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

Route::get('/rubrieken/', 'RubriekenController@index')->name('rubrieken');
Route::get('/rubriek/{product_id}', 'RubriekenController@rubriek_no_name')->name('rubriek_without_name');
Route::get('/rubriek/{product_id}/{product_name}', 'RubriekenController@rubriek')->name('rubriek_with_name');

Route::get('/product/{product}', 'ProductController@product_no_name')->name('product_no_name');
Route::get('/product/{product}/{name}', 'ProductController@product_specific')->name('product_specific');
Route::get('/product/', 'ProductController@index')->name('product');

Route::get('/zoek', 'SearchController')->name('search');

Route::post('/bied/toevoegen', 'BidsController@create_bid')->name('bid.create');

Route::get('/account/veilingen', 'AuctionController@myAuctions')->name('account.auctions');

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
                Route::post('/product/toevoegen/checken/', 'AuctionController@newProduct')->name('auction.add.check');

                Route::get('/product/toevoegen/', 'AuctionController@index')->name('auction.add');
            });

        Route::middleware('admin')
            ->group(function () {
                Route::get('/rubrieken/bekijken/{id}', 'RubriekenController@view_rubriek')->name('view_rubriek');
                Route::get('/rubrieken/toevoegen/{parent_id}', 'RubriekenController@new_rubriek')->name('new_rubriek');
                Route::post('/rubrieken/toevoegen/{parent_id}', 'RubriekenController@add_rubriek')->name('add_rubriek');
                Route::get('/rubrieken/bewerken/{id}', 'RubriekenController@edit_rubriek')->name('edit_rubriek');
                Route::post('/rubrieken/bewerken/{id}', 'RubriekenController@update_rubriek')->name('update_rubriek');
                Route::get('/rubrieken/uitfaseren/{id}', 'RubriekenController@show_disable_rubriek')->name('show_disable_rubriek');
                Route::post('/rubrieken/uitfaseren/{id}', 'RubriekenController@disable_rubriek')->name('disable_rubriek');
            });

        Route::get('/admin/verifications/sellers', 'User\Admin\Verifications\Seller\MailController@showVerificationLetter')->name('admin.verifications.seller.letter');
        Route::post('/admin/verifications/sellers/sent', 'User\Admin\Verifications\Seller\MailController@markLetterSent')->name('admin.verifications.seller.letter.sent');
    });
