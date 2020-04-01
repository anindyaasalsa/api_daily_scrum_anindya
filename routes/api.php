<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

Route::middleware(['jwt.verify'])->group(function(){
    Route::get('daily_scrum/{id}', "DailyScrumController@index"); //read detail
	Route::get('daily_scrum/{limit}/{offset}', "DailyScrumController@getAll"); //read detail
	Route::post('daily_scrum', 'DailyScrumController@store'); //create detail
	Route::delete('daily_scrum/{id}', "DailyScrumController@delete"); //delete detail
});
