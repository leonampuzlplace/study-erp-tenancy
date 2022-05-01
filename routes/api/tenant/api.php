<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::group([
    'middleware' => [
        'api', 
        InitializeTenancyByDomain::class, 
        PreventAccessFromCentralDomains::class
    ],
    'namespace' => '',
    'prefix' => '',
], function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
    Route::get('/ping', function () {
        return 'pong #DOMAIN: ' . tenant('id');
    });
    Route::get('/login', function () {
        return 'Login. Id of the current tenant is ' . tenant('id');
    });
});