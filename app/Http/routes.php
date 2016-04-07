<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::group(['middleware' => 'auth'], function () {
	Route::get('topics', 'TopicsController@index');
	Route::get('topic/{topic}', 'TopicsController@showTopicMessages');
	Route::get('topic', 'TopicsController@showTopicForm');
	Route::post('topic', 'TopicsController@store');
	Route::delete('topic/{topic}', 'TopicsController@destroy');
	Route::post('topic/{topic}/message', 'MessagesController@store');
	Route::delete('topic/{topic}/message/{message}', 'MessagesController@destroy');
});

Route::get('testes', 'TestesController@index');

