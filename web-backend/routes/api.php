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
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
});
//authorized routes
Route::group(['middleware' => ['auth:api']], function(){
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
        Route::get('/', 'App\Http\Controllers\FieldsController@index')->middleware('can:viewAny,App\Models\Fields');
        Route::get('/create', 'App\Http\Controllers\FieldsController@create')->middleware('can:create,App\Models\Fields');
        Route::post('/', 'App\Http\Controllers\FieldsController@store')->middleware('can:create,App\Models\Fields');
        Route::get('{field}', 'App\Http\Controllers\FieldsController@show');//->middleware('can:view,field');
        Route::get('{field}/edit', 'App\Http\Controllers\FieldsController@edit');//->middleware('can:view,field');
        Route::put('{field}', 'App\Http\Controllers\FieldsController@update');//->middleware('can:update,field');
        Route::delete('{field}', 'App\Http\Controllers\FieldsController@delete');//->middleware('can:delete,field');
    });

    Route::prefix('fieldactions')->group(function () {
        Route::get('/', 'App\Http\Controllers\FieldActionsController@index')->middleware('can:viewAny,App\Models\FieldActions');
        Route::get('/create', 'App\Http\Controllers\FieldActionsController@create')->middleware('can:create,App\Models\FieldActions');
        Route::post('/', 'App\Http\Controllers\FieldActionsController@store')->middleware('can:create,App\Models\FieldActions');
        Route::get('{fieldactions}', 'App\Http\Controllers\FieldActionsController@show');// ->middleware('can:view,fieldactions');
        Route::get('{fieldactions}/edit', 'App\Http\Controllers\FieldActionsController@edit');// ->middleware('can:view,fieldactions');
        Route::put('{fieldactions}', 'App\Http\Controllers\FieldActionsController@update');//->middleware('can:update,fieldactions');
        Route::delete('{fieldactions}', 'App\Http\Controllers\FieldActionsController@delete');//->middleware('can:delete,fieldactions');
    });

    Route::prefix('sowing')->group(function () {
        Route::get('/', 'App\Http\Controllers\SowingController@index');
        Route::get('/create', 'App\Http\Controllers\SowingController@create');
        Route::post('/', 'App\Http\Controllers\SowingController@store');
        Route::get('{sowing}', 'App\Http\Controllers\SowingController@show');
        Route::get('{sowing}/edit', 'App\Http\Controllers\SowingController@edit');
        Route::put('{sowing}', 'App\Http\Controllers\SowingController@update');
        Route::delete('{sowing}', 'App\Http\Controllers\SowingController@delete');
    });

    Route::prefix('harvest')->group(function () {
        Route::get('/', 'App\Http\Controllers\HarvestController@index');
        Route::get('/create', 'App\Http\Controllers\HarvestController@create');
        Route::post('/', 'App\Http\Controllers\HarvestController@store');
        Route::get('{harvest}', 'App\Http\Controllers\HarvestController@show');
        Route::get('{harvest}/edit', 'App\Http\Controllers\HarvestController@edit');
        Route::put('{harvest}', 'App\Http\Controllers\HarvestController@update');
        Route::delete('{harvest}', 'App\Http\Controllers\HarvestController@delete');
    });

    Route::prefix('fieldAddOns')->group(function () {
        Route::get('/', 'App\Http\Controllers\FieldAddOnsController@index');
        Route::get('/create', 'App\Http\Controllers\FieldAddOnsController@create');
        Route::post('/', 'App\Http\Controllers\FieldAddOnsController@store');
        Route::get('{fieldAddOns}', 'App\Http\Controllers\FieldAddOnsController@show');
        Route::get('{fieldAddOns}/edit', 'App\Http\Controllers\FieldAddOnsController@edit');
        Route::put('{fieldAddOns}', 'App\Http\Controllers\FieldAddOnsController@update');
        Route::delete('{fieldAddOns}', 'App\Http\Controllers\FieldAddOnsController@delete');
    });
});
