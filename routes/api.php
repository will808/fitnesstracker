<?php

use Illuminate\Http\Request;

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







// Authentication
Route::post('signIn', 'AuthenticationController@signIn');
Route::post('register', 'AuthenticationController@register');
Route::middleware('auth:api')->post('signOut', 'AuthenticationController@signOut');

// User Functions
//       Authorisation         HTTP    URL          Controller   Function    
Route::middleware('auth:api')->get('dailyintake', 'UserController@index');
Route::middleware('auth:api')->get('meals', 'UserController@getMeals');
Route::middleware('auth:api')->get('activities', 'UserController@getActivities');
Route::middleware('auth:api')->put('updateUser', 'UserController@updateUser');
Route::middleware('auth:api')->post('addMeal', 'UserController@createMeal');
Route::middleware('auth:api')->post('addActivity', 'UserController@createActivity');
Route::middleware('auth:api')->get('getJournal', 'UserController@getJournal');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



