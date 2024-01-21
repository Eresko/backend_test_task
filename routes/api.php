<?php
use App\Http\Controllers\Nomenclature\UploadController;
use App\Http\Controllers\Nomenclature\FilesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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



Route::group([ 'prefix' => 'nomenclature'], function () {
    Route::post('upload-file', [UploadController::class, 'uploadFile']);
    Route::get('list', [FilesController::class, 'listFiles']);
    Route::get('get/{id}', [FilesController::class, 'getFile']);
});
