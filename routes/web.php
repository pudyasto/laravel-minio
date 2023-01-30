<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadFileController;
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

Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::group([
    'prefix' => 'upload-file',
], function () {
    Route::get('/', [UploadFileController::class, 'index'])->name('upload-file');
    Route::get('/index', [UploadFileController::class, 'index']);
    Route::get('/preview/{filename}', [UploadFileController::class, 'preview']);
    
    Route::post('/tableMain', [UploadFileController::class, 'tableMain']);

    Route::get('/create', [UploadFileController::class, 'create']);
    Route::get('/edit', [UploadFileController::class, 'edit']);

    Route::post('/store', [UploadFileController::class, 'store']);
    Route::put('/update', [UploadFileController::class, 'update']);
    Route::delete('/destroy', [UploadFileController::class, 'destroy']);
});
