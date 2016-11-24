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
Route::get('weighting/alternative/{id}','WeightingController@alternative')->name('weighting.alternative');
Route::get('weighting/eigen/criteria','WeightingController@eigen')->name('weighting.eigen');
Route::get('weighting/process','WeightingController@process')->name('weighting.process');
Route::resource('weighting','WeightingController');
