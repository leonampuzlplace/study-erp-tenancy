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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => ['api', 'cors', 'X-Locale'],
    'namespace' => 'App\Http\Controllers\Central',
    'prefix' => '',
], function () {
    Route::get('/ping', function () {
        return 'pong #CENTRAL';
    });

    Route::get("/tenant",         "TenantController@index")->name("tenant.index");
    Route::post("/tenant",        "TenantController@store")->name("tenant.store");
    Route::get("/tenant/{id}",    "TenantController@show")->name("tenant.show");
    Route::put("/tenant/{id}",    "TenantController@update")->name("tenant.update");
    Route::delete("/tenant/{id}", "TenantController@destroy")->name("tenant.destroy");
});
