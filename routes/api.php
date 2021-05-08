<?php

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

// Route::middleware('auth:api')->group('/user', function (Request $request) {
//     return $request->user();
// });
Route::namespace('API')->group(function(){
    Route::group(['namespace' => 'V1', 'prefix' => 'v1'], function () {
        Route::apiResource('icons', 'IconsController');
    });
});
