<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('limitSample.dashboard');
});


// Model

Route::get('/limit-sample', function () {
    return view('model.index');
});

Route::get('/limit-sample/model/create', function () {
    return view('model.create');
});

Route::get('/limit-sample/model/edit/id', function () {
    return view('model.edit');
});





// Part

Route::get('limit-sample/model/id/part/create', function () {
    return view('part.create');
});
Route::get('limit-sample/part/edit/id', function () {
    return view('part.edit');
});
Route::get('/limit-sample/model/id/part', function () {
    return view('part.index');
});


//area Part

Route::get('/limit-sample/part/id', function () {
    return view('areaPart.index');
});

Route::get('/limit-sample/areaPart/id', function () {
    return view('areaPart.detail');
});

Route::get('/limit-sample/area-part/edit/id', function () {
    return view('areaPart.edit');
});


