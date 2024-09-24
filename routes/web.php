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

Route::get('/limit-sample', function () {
    return view('limitSample.index');
});

Route::get('/limit-sample/part/1', function () {
    return view('limitSample.allPart');
});
