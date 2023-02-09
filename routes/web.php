<?php

use App\Http\Controllers\ActivationPluginController;
use App\Http\Controllers\DomainController;
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


Route::prefix('domain')->middleware('throttle:30,1')->group(function() {
    Route::get('activate', [DomainController::class, 'activate'])->name('domain/activate');
    Route::get('re-activate', [DomainController::class, 'reActivate'])->name('domain/re-activate');
    Route::post('verify', [DomainController::class, 'verify'])->name('domain/verify');
});
