<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/**
 * Person (Pessoas)
 */
Route::group([
  'middleware' => [
    'api', 
    InitializeTenancyByDomain::class, 
    PreventAccessFromCentralDomains::class,
    'cors',
    // 'jwt',
    // 'acl',
    'X-Locale'
  ],
  'namespace' => 'App\Http\Controllers\Tenant\Person',
  'prefix' => '',
], function () {
  Route::get("/person",         "PersonController@index")->name("person.index");
  Route::post("/person",        "PersonController@store")->name("person.store");
  Route::get("/person/{id}",    "PersonController@show")->name("person.show");
  Route::put("/person/{id}",    "PersonController@update")->name("person.update");
  Route::delete("/person/{id}", "PersonController@destroy")->name("person.destroy");
});