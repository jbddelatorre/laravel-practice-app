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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'host'], function() {

	Route::get('/host', 'HostDashboardController@getTournaments');
	Route::post('/host/registertournament', 'HostDashboardController@registerTournament');

});

Route::group(['middleware' => 'participant'], function() {

	Route::get('/participant', 'ParticipantDashboardController@getTournaments');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');