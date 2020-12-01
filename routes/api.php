<?php

use App\Http\Controllers\API\TodoController;
use App\Http\Controllers\TodosController;
use App\Http\Resources\Todo;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::get('/todos', function () {
//    return new \App\Http\Resources\TodoCollection(\App\Models\Todos::all());
//});
Route::apiResource('todos', 'API\TodosController' );
Route::delete('todos/deleteAll', 'API\TodosController@deleteAll');
