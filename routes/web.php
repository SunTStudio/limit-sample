<?php

use App\Http\Controllers\AreaPartController;
use App\Http\Controllers\DashboardController;
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

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('limitSample.loginProsses');
// Route::post('/login', [LoginController::class, 'login'])->name('limitSample.loginProsses');
Route::get('/limit-sample/login-external', [LoginController::class, 'externalLogin'])->name('limitSample.externalLogin');
Route::post('/loginPortalAJI', [LoginController::class, 'directToExternalSite'])->name('limitSample.directToExternalSite');
Route::get('/toPortal', [LoginController::class, 'toPortal'])->name('limitSample.toPortal');

// Route::post('/login', [LoginController::class, 'authenticate'])->name('limitSample.loginProsses');
Route::get('/login-guest', [LoginController::class, 'loginGuest'])->name('loginGuest');
Route::post('/login-guest', [LoginController::class, 'authenticate'])->name('limitSample.loginGuestProsses');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/visits-data', [DashboardController::class, 'getVisitsData']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('limitSample.dashboard');
    Route::get('/limit-sample', [LoginController::class, 'dashboard'])->name('limitSample.dashboards');
    Route::get('/all-limit-sample/search', [DashboardController::class, 'allLimitSampleSearch'])->name('limitSample.Allsearch');
    Route::get('/all-limit-sample/search/model', [DashboardController::class, 'allModelSearch'])->name('AllLimitSample.modelSearch');
    Route::get('/all-limit-sample/search/part', [DashboardController::class, 'allPartSearch'])->name('AllLimitSample.partSearch');
    Route::get('/all-limit-sample/search/area-part', [DashboardController::class, 'allAreaPartSearch'])->name('AllLimitSample.areaPartSearch');
    Route::get('/all-limit-sample/list', [DashboardController::class, 'allLimitSample'])->name('allLimitSample.allList');
    Route::get('/all-limit-sample', [DashboardController::class, 'allLimitSample'])->name('limitSample.all');
    Route::get('/all-limit-sample-modal', [DashboardController::class, 'allLimitSampleModal'])->name('limitSample.allLimitSampleModal');
    Route::get('/access-denied', [LoginController::class, 'accessDenied'])->name('access-denied');

    // Model

    Route::get('/limit-sample/model', [ModelPartController::class, 'index'])->name('model.index');
    Route::middleware('role:AdminLS')->group(function () {
        Route::get('/limit-sample/model/create', [ModelPartController::class, 'create'])->name('model.create');
        Route::post('/limit-sample/model/create', [ModelPartController::class, 'store'])->name('model.store');
        Route::get('/limit-sample/model/edit/{id}', [ModelPartController::class, 'edit'])->name('model.edit');
        Route::post('/limit-sample/model/edit/{id}', [ModelPartController::class, 'update'])->name('model.update');
        Route::delete('/limit-sample/model/delete/{id}', [ModelPartController::class, 'destroy'])->name('model.delete');
        Route::get('/manage-access', [DashboardController::class, 'manageAccess'])->name('dashboard.manage.access');
        Route::post('/manage-access/store', [DashboardController::class, 'manageAccessStore'])->name('manage.access.store');

    });
    Route::get('/limit-sample/model/search/', [ModelPartController::class, 'search'])->name('model.search');
    Route::get('/limit-sample/model/list/', [ModelPartController::class, 'listModel'])->name('limitSample.listModel');

    // Part

    Route::get('/limit-sample/model/{id}/part', [PartController::class, 'index'])->name('part.index');
    Route::get('/limit-sample/model/{id}/part/list', [PartController::class, 'listPart'])->name('part.listPart');
    Route::middleware('role:AdminLS')->group(function () {
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
    Route::get('/limit-sample/areaPart/{id}', [AreaPartController::class, 'detail'])->name('area.Part.edit');
    Route::get('/limit-sample/area-part/search/{id}', [AreaPartController::class, 'katalogSearch'])->name('katalog.search');
    Route::get('/limit-sample/area-part/{id}/getDataCharacteristic', [AreaPartController::class, 'getDataCharacteristic'])->name('katalog.getDataCharacteristic');
    Route::get('/limit-sample/area-part/{id}/count', [AreaPartController::class, 'katalogCount'])->name('katalog.count');
    Route::get('/limit-sample/area-part/{id}/list', [AreaPartController::class, 'listKatalog'])->name('areaPart.listKatalog');

    Route::middleware('role:AdminLS')->group(function () {
        Route::get('/limit-sample/area-part/create/{id}', [AreaPartController::class, 'create'])->name('areaPart.create');
        Route::post('/limit-sample/area-part/create/{id}', [AreaPartController::class, 'store'])->name('areaPart.store');
        Route::get('/limit-sample/area-part/edit/{id}', [AreaPartController::class, 'edit'])->name('areaPart.edit');
        Route::post('/limit-sample/area-part/edit/{id}', [AreaPartController::class, 'update'])->name('areaPart.update');
        Route::post('excel/import/{id}', [ExcelImportController::class, 'import'])->name('excel.import');
        Route::get('/download-file/{filename}', [AreaPartController::class, 'download'])->name('file.download');
        Route::get('/limit-sample/area-part/{id}/addCharacteristic', [AreaPartController::class, 'addCharacteristic'])->name('katalog.addCharacteristic');
        Route::get('/limit-sample/area-part/{id}/delCharacteristic', [AreaPartController::class, 'delCharacteristic'])->name('katalog.delCharacteristic');
        Route::get('/area-part/export-pdf/{id}', [AreaPartController::class, 'exportPDF'])->name('areaPart.exportPDF');
    });

    Route::delete('/limit-sample/areaPart/delete/{id}', [AreaPartController::class, 'destroy'])->name('katalog.delete');
    Route::get('/activity', [DashboardController::class, 'activity'])->name('limitSample.activity');
    Route::get('/getDatatables', [DashboardController::class, 'getDatatables'])->name('guests.datatables');
    Route::get('/all-expired', [DashboardController::class, 'allExpired'])->name('limitSample.allExpired');
    Route::get('/will-expired', [DashboardController::class, 'willExpired'])->name('limitSample.willExpired');
    Route::get('/arsip', [DashboardController::class, 'arsip'])->name('limitSample.arsip');
    Route::get('/arsipModal', [DashboardController::class, 'arsipModal'])->name('limitSample.arsipModal');
    Route::get('/need-approve', [DashboardController::class, 'needApprovePage'])->name('limitSample.needApprovePage');
    Route::get('/ditolak', [DashboardController::class, 'ditolak'])->name('limitSample.ditolak');

    //approval
    Route::middleware('role:Supervisor')->group(function () {
        Route::get('/limit-sample/area-part/approve/sechead1/{id}', [AreaPartController::class, 'approvalSecHead1'])->name('katalog.approve.secHead1');
        Route::get('/limit-sample/area-part/approve/sechead2/{id}', [AreaPartController::class, 'approvalSecHead2'])->name('katalog.approve.secHead2');
        Route::get('/limit-sample/area-part/tolak/sechead/{id}', [AreaPartController::class, 'tolakSecHead'])->name('katalog.tolak.secHead');
        Route::post('/limit-sample/area-part/tolak/sechead/{id}', [AreaPartController::class, 'tolakSecHeadProsses'])->name('katalog.tolak.secHead.prosses');
    });
    Route::middleware('role:Department Head')->group(function () {
        Route::get('/limit-sample/area-part/approve/depthead/{id}', [AreaPartController::class, 'approvalDeptHead'])->name('katalog.approve.deptHead');
        Route::get('/limit-sample/area-part/tolak/depthead/{id}', [AreaPartController::class, 'tolakDeptHead'])->name('katalog.tolak.deptHead');
        Route::post('/limit-sample/area-part/tolak/depthead/{id}', [AreaPartController::class, 'tolakDeptHeadProsses'])->name('katalog.tolak.deptHead.prosses');
    });


});
