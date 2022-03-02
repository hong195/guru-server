<?php

use App\Http\Controllers\ActivationPluginController;
use App\Http\Controllers\DomainRegistrationController;
use App\Http\Controllers\OAuthController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/redirect', [OAuthController::class, 'redirect'])->name('auth/redirect');


Route::prefix('domain')->group(function() {
    Route::get('/request/{domain}/{product}', [DomainRegistrationController::class, 'createRequest'])->name('domain/register');
    Route::get('/register', [DomainRegistrationController::class, 'register'])->name('domain/register');
    Route::get('/deregister', [DomainRegistrationController::class, 'deregister'])->name('domain/deregister');
    Route::get('/check/{domain}', function () {
        return view('welcome');
    })
        ->name('domain/check');
});
