<?php

use App\Http\Controllers\AreaPartController;
use App\Http\Controllers\ExcelImportController;
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

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('limitSample.loginProsses');
Route::get('/login-guest', [LoginController::class, 'loginGuest'])->name('loginGuest');
Route::post('/login-guest', [LoginController::class, 'authenticateGuest'])->name('limitSample.loginGuestProsses');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [LoginController::class, 'dashboard'])->name('limitSample.dashboard');
    Route::get('/limit-sample', [LoginController::class, 'dashboard'])->name('limitSample.dashboard');

    // Model

    Route::get('/limit-sample/model', [ModelPartController::class, 'index'])->name('model.index');
    Route::middleware('role:Admin')->group(function () {
        Route::get('/limit-sample/model/create', [ModelPartController::class, 'create'])->name('model.create');
        Route::post('/limit-sample/model/create', [ModelPartController::class, 'store'])->name('model.store');
        Route::get('/limit-sample/model/edit/{id}', [ModelPartController::class, 'edit'])->name('model.edit');
        Route::post('/limit-sample/model/edit/{id}', [ModelPartController::class, 'update'])->name('model.update');
        Route::delete('/limit-sample/model/delete/{id}', [ModelPartController::class, 'destroy'])->name('model.delete');
    });
    Route::get('/limit-sample/model/search/', [ModelPartController::class, 'search'])->name('model.search');

    // Part

    Route::get('/limit-sample/model/{id}/part', [PartController::class, 'index'])->name('part.index');
    Route::middleware('role:Admin')->group(function () {
        Route::get('limit-sample/model/{id}/part/create', [PartController::class, 'create'])->name('part.create');
        Route::post('limit-sample/model/{id}/part/create', [PartController::class, 'store'])->name('part.store');
        Route::get('limit-sample/part/edit/{id}', [PartController::class, 'edit'])->name('part.edit');
        Route::post('limit-sample/part/edit/{id}', [PartController::class, 'update'])->name('part.update');
        Route::delete('/limit-sample/model/part/delete/{id}', [PartController::class, 'destroy'])->name('areaPart.delete');
        Route::get('/limit-sample/part-area/kelola/{id}', [PartController::class, 'kelola'])->name('part.kelola');
        Route::post('/limit-sample/part-area/kelola/{id}', [PartController::class, 'kelolaStore'])->name('part.kelolaStore');
    });
    Route::get('/limit-sample/model/{id}/part/search/', [PartController::class, 'search'])->name('part.search');

    //area Part

    Route::get('/limit-sample/part/{id}', [AreaPartController::class, 'index'])->name('areaPart.index');
    Route::get('/limit-sample/area-part/{id}', [AreaPartController::class, 'katalog'])->name('areaPart.katalog');
    Route::get('/limit-sample/area-part/search/{id}', [AreaPartController::class, 'katalogSearch'])->name('katalog.search');
    Route::get('/limit-sample/areaPart/{id}', [AreaPartController::class, 'detail'])->name('areaPart.edit');

    Route::middleware('role:Admin')->group(function () {
        Route::get('/limit-sample/area-part/create/{id}', [AreaPartController::class, 'create'])->name('areaPart.create');
        Route::post('/limit-sample/area-part/create/{id}', [AreaPartController::class, 'store'])->name('areaPart.store');
        Route::get('/limit-sample/area-part/edit/{id}', [AreaPartController::class, 'edit'])->name('areaPart.edit');
        Route::post('/limit-sample/area-part/edit/{id}', [AreaPartController::class, 'update'])->name('areaPart.update');
        Route::delete('/limit-sample/areaPart/delete/{id}', [AreaPartController::class, 'destroy'])->name('katalog.delete');
        Route::post('excel/import/{id}', [ExcelImportController::class, 'import'])->name('excel.import');
    });

    //approval
    Route::middleware('role:Section Head')->group(function () {
        Route::get('/limit-sample/area-part/approve/sechead/{id}', [AreaPartController::class, 'approvalSecHead'])->name('katalog.approve.secHead');
        Route::get('/limit-sample/area-part/tolak/sechead/{id}', [AreaPartController::class, 'tolakSecHead'])->name('katalog.tolak.secHead');
        Route::post('/limit-sample/area-part/tolak/sechead/{id}', [AreaPartController::class, 'tolakSecHeadProsses'])->name('katalog.tolak.secHead');
    });
    Route::middleware('role:Departement Head')->group(function () {
        Route::get('/limit-sample/area-part/approve/depthead/{id}', [AreaPartController::class, 'approvalDeptHead'])->name('katalog.approve.deptHead');
        Route::get('/limit-sample/area-part/tolak/depthead/{id}', [AreaPartController::class, 'tolakDeptHead'])->name('katalog.tolak.deptHead');
        Route::post('/limit-sample/area-part/tolak/depthead/{id}', [AreaPartController::class, 'tolakDeptHeadProsses'])->name('katalog.tolak.deptHead');
    });
});
