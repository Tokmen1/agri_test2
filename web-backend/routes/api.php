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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/testdb', 'App\Http\Controllers\DBController@getAllData');

Route::prefix('user')->group(function () {
    Route::get('/', 'App\Http\Controllers\UserController@index');
    Route::get('/create', 'App\Http\Controllers\UserController@create');
    Route::post('/', 'App\Http\Controllers\UserController@store');
    Route::get('{user}', 'App\Http\Controllers\UserController@show');
    Route::get('{user}/edit', 'App\Http\Controllers\UserController@edit');
    Route::put('{user}', 'App\Http\Controllers\UserController@update');
    Route::delete('{user}', 'App\Http\Controllers\UserController@delete');
});

Route::prefix('fields')->group(function () {
    Route::get('/', 'App\Http\Controllers\FieldsController@index');
    Route::get('/create', 'App\Http\Controllers\FieldsController@create');
    Route::post('/', 'App\Http\Controllers\FieldsController@store');
    Route::get('{field}', 'App\Http\Controllers\FieldsController@show');
    Route::get('{field}/edit', 'App\Http\Controllers\FieldsController@edit');
    Route::put('{field}', 'App\Http\Controllers\FieldsController@update');
    Route::delete('{field}', 'App\Http\Controllers\FieldsController@delete');
});

Route::prefix('fieldactions')->group(function () {
    Route::get('/', 'App\Http\Controllers\FieldActionsController@index');
    Route::get('/create', 'App\Http\Controllers\FieldActionsController@create');
    Route::post('/', 'App\Http\Controllers\FieldActionsController@store');
    Route::get('{fieldactions}', 'App\Http\Controllers\FieldActionsController@show');
    Route::get('{fieldactions}/edit', 'App\Http\Controllers\FieldActionsController@edit');
    Route::put('{fieldactions}', 'App\Http\Controllers\FieldActionsController@update');
    Route::delete('{fieldactions}', 'App\Http\Controllers\FieldActionsController@delete');
});

