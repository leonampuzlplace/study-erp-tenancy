<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/**
 * Auth
 */
Route::group([
    'middleware' => [
        'api', 
        InitializeTenancyByDomain::class, 
        PreventAccessFromCentralDomains::class,
        'cors',
        'X-Locale'
    ],
    'namespace' => 'App\Http\Controllers\Tenant\Auth',
    'prefix' => 'auth',
], function () {
    Route::post('/login', 'AuthController@login');
    Route::middleware('jwt')->post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('/me', 'AuthController@me');    
});