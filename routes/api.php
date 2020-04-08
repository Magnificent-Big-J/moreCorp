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

Route::group(['middleware'=> ['api']], function (){
    Route::post('/login', 'AuthController@login')->name('api.login');
    Route::post('/register', 'AuthController@register')->name('api.register');
});

Route::group(['middleware'=> ['api','auth:api']], function (){
    Route::get('/projects','ProjectController@index')->name('project.index');
    Route::get('/tasks', 'TaskController@index')->name('tasks');
    Route::get('/task/project/{id}', 'TaskController@getProject')->name('task.project');
    Route::post('/tasks', 'TaskController@store')->name('task.store');
    Route::get('/task/edit/{id}', 'TaskController@edit')->name('task.edit');
    Route::post('/task/delete/{id}', 'TaskController@destroy')->name('task.delete');
    Route::post('/task/update/{id}', 'TaskController@update')->name('task.update');

});
