<?php

use App\Http\Controllers\AreaPartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModelPartController;
use App\Http\Controllers\PartController;
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


Route::get('/', [LoginController::class,'dashboard'])->name('limitSample.dashboard');
Route::get('/limit-sample', [LoginController::class,'dashboard'])->name('limitSample.dashboard');


// Model


Route::get('/limit-sample/model',[ModelPartController::class, 'index'])->name('model.index');
Route::get('/limit-sample/model/create',[ModelPartController::class, 'create'])->name('model.create');
Route::post('/limit-sample/model/create',[ModelPartController::class, 'store'])->name('model.store');
Route::get('/limit-sample/model/edit/{id}',[ModelPartController::class, 'edit'])->name('model.edit');
Route::post('/limit-sample/model/edit/{id}',[ModelPartController::class, 'update'])->name('model.update');
Route::get('/limit-sample/model/search/',[ModelPartController::class, 'search'])->name('model.search');






// Part

Route::get('/limit-sample/model/{id}/part',[PartController::class, 'index'])->name('part.index');
Route::get('limit-sample/model/{id}/part/create',[PartController::class, 'create'])->name('part.create');
Route::post('limit-sample/model/{id}/part/create',[PartController::class, 'store'])->name('part.store');
Route::get('limit-sample/part/edit/{id}',[PartController::class, 'edit'])->name('part.edit');
Route::post('limit-sample/part/edit/{id}',[PartController::class, 'update'])->name('part.update');
Route::get('/limit-sample/model/{id}/part/search/',[PartController::class, 'search'])->name('part.search');


//area Part

Route::get('/limit-sample/part/{id}',[AreaPartController::class, 'index'])->name('areaPart.index');
Route::get('/limit-sample/area-part/create/{id}',[AreaPartController::class, 'create'])->name('areaPart.create');
Route::post('/limit-sample/area-part/create/{id}',[AreaPartController::class, 'store'])->name('areaPart.store');
Route::get('/limit-sample/area-part/edit/{id}',[AreaPartController::class, 'edit'])->name('areaPart.edit');
Route::post('/limit-sample/area-part/edit/{id}',[AreaPartController::class, 'update'])->name('areaPart.update');
Route::get('/limit-sample/areaPart/{id}',[AreaPartController::class, 'detail'])->name('areaPart.edit');


