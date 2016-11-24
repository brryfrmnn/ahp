<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return str_plural('criteria_weight');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('weighting/eigen','WeightingController@eigen')->name('weighting.eigen');
Route::resource('weighting','WeightingController');
