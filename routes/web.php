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

Route::get('/', function () {
	return view('welcome');
});

Route::get('get-ip-addresses', [
	'as' => 'client.ips', 'uses' => 'IPAddressController@index'
]);

Route::post('get-ip-addresses', [
	'as' => 'fetch.client.ips', 'uses' => 'IPAddressController@store'
]);
