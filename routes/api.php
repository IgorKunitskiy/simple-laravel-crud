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

Route::post('/client-create', 'ClientController@createClient')->name('client.create');
Route::get('/client', 'ClientController@getClient')->name('client.show');
Route::get('/clients-all', 'ClientController@getClients')->name('client.show_all');
Route::post('/client-remove', 'ClientController@removeClient')->name('client.remove');

Route::post('/project-create', 'ProjectController@createProject')->name('project.create');
Route::get('/project', 'ProjectController@getProject')->name('project.show');
Route::get('/project-all', 'ProjectController@getProjects')->name('project.show_all');
Route::post('/project-update', 'ProjectController@updateProject')->name('project.update');
Route::post('/project-remove', 'ProjectController@removeProject')->name('project.remove');
