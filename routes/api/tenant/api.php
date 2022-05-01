<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/**
 * Who am i?
 */
Route::group([
    'middleware' => [
        'api', 
        InitializeTenancyByDomain::class, 
        PreventAccessFromCentralDomains::class,
        'cors',
        'X-Locale'
    ],
], function () {
    Route::get('/whoami', function () {
        return responseSuccess([
            "iam" => [
                "id" => tenant('id'),
                "email" => tenant('email'),
                "domain" => tenant('domain'),
                "company" => tenant('company'),
                "tenancy_db_name" => tenant('tenancy_db_name'),
                "created_at" => tenant('created_at'),
            ]
        ]);
    });
});