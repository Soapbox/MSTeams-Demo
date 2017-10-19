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

Route::group(['prefix' => 'teams'], function () {
    Route::get('/signup', 'TeamsController@signup');
    Route::get('/login', 'TeamsController@login');
    Route::get('/', 'TeamsController@index');
    Route::get('/auth', 'TeamsController@auth');
});

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
    Route::post('/channels', 'Channels@store');
    Route::get('/channels', 'Channels@get');
    Route::post('/users/invite', 'Users@invite');
});
