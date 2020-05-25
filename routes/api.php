<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sliceUpload','UploadController@sliceUpload');

Route::post('/test','DianMengController@test');
Route::post('/testDecrypt','DianMengController@testDecrypt');

Route::get('/testf','TestController@testf');
Route::get('/testc','TestController@testc');
Route::get('/testfib','TestController@testfib');

Route::get('/minzhan','DataStructureController@testMinimumZhan');