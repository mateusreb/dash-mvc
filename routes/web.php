<?php

use App\Framework\Routing\Route;

//Config
Route::setNamespace('\App\Controllers');
Route::set404('PageErrorController@error404');

//Index
Route::get('/home', 'HomeController@index');

//Login
//Route::get('/login/{redirect}', 'LoginController@index');
Route::get('/login', 'LoginController@index');
Route::post('/auth', 'LoginController@auth');
Route::get('/logout', 'LoginController@logout');

//Manage users
Route::get('/manage-users', 'UsersController@manageUsers');
Route::get('/manage-users/edit/{id}', 'UsersController@editUser');
Route::get('/manage-users/details/{id}', 'UsersController@userDetails');
Route::post('/manage-users/delete', 'UsersController@reqDeleteUser');
Route::get('/manage-users', 'UsersController@manageUsers');

//Manage subscriptions
Route::get('/manage-licenses', 'LicensesController@manageLicenses');
Route::get('/manage-licenses/{id}', 'LicensesController@manageLicenses');
Route::get('/edit-license/{id}', 'LicensesController@editLicense');
Route::get('/create-license', 'LicensesController@createLicense');
Route::get('/search-license', 'LicensesController@searchLicense');

Route::post('/create-license', 'LicensesController@postCreateLicense');
Route::post('/update-license', 'LicensesController@postEditLicense');

Route::post('/update-all-license', 'LicensesController@postEditAllLicense');
Route::post('/delete-license', 'LicensesController@postDeleteLicense');

//Manage products
Route::get('/manage-products', 'ProductController@manageProducts');
Route::get('/manage-products/edit/{id}', 'ProductController@editProduct');
Route::get('/manage-products/create', 'ProductController@createProduct');
Route::post('/manage-products/create', 'ProductController@postCreateProduct');
Route::post('/manage-products/update', 'ProductController@postEditProduct');
Route::post('/manage-products/detete', 'ProductController@postDeleteProduct');

//Products
Route::get('/purchase', 'UserController@purchase');
Route::get('/purchase/select/{id}', 'UserController@purchaseSelect');
Route::get('/purchase/finish', 'UserController@postPurchaseFinish');
Route::post('/purchase/finish', 'UserController@postPurchaseFinish');
Route::get('/payssion', 'UserController@payssion');

Route::get('/download', 'UserController@download');
Route::post('/download', 'UserController@postDownload');
//Hwid
Route::get('/reset-token', 'UserController@token');
Route::post('/reset-token', 'UserController@postResetToken');

//Account
Route::get('/user-transactions', 'UserController@transactions');
Route::get('/connection-log', 'UserController@connections');
Route::get('/user-licenses', 'UserController@licenses');

//Api payment
Route::get('/api/v1/pingback/paymentwall', 'PingbackController@paymentwall');
Route::post('/api/v1/pingback/payssion', 'PingbackController@payssion');

Route::get('/api/v1/users/downgrade', 'SystemController@downgradeUsers');

//Loader
Route::post('/api/v1/launcher/auth', 'LoaderController@auth');
Route::post('/api/v1/launcher/check', 'LoaderController@check');

Route::get('/stripe-checkout', 'BuyController@checkout');
Route::get('/stripe-success', 'BuyController@success');

Route::get('/stripe-checkout-session', 'BuyController@checkoutSession');

Route::get('/debug', 'DebugController@debug');