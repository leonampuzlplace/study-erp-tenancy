<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/**
 * Stock (Estoque)
 */
Route::group([
  'middleware' => [
    'api', 
    InitializeTenancyByDomain::class, 
    PreventAccessFromCentralDomains::class,
    'cors',
    'jwt',
    'acl',
    'X-Locale'
  ],
  'namespace' => 'App\Http\Controllers\Tenant\Stock',
  'prefix' => '',
], function () {
  Route::get("/stock",         "StockController@index")->name("stock.index");
  Route::post("/stock",        "StockController@store")->name("stock.store");
  Route::get("/stock/{id}",    "StockController@show")->name("stock.show");
  Route::put("/stock/{id}",    "StockController@update")->name("stock.update");
  Route::delete("/stock/{id}", "StockController@destroy")->name("stock.destroy");
});