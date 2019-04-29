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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/client-create', 'ClientController@createClient');
Route::get('/client', 'ClientController@getClient');
Route::get('/clients-all', 'ClientController@getClients');
Route::post('/client-remove', 'ClientController@removeClient');

Route::post('/project-create', 'ProjectController@createProject');
Route::get('/project', 'ProjectController@getProject');
Route::get('/project-all', 'ProjectController@getProjects');
Route::post('/project-update', 'ProjectController@updateProject');
Route::post('/project-remove', 'ProjectController@removeProject');
