<?php

use App\Http\Controllers\ActivationPluginController;
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

Route::get('activate', [ActivationPluginController::class, 'activate']);

Route::get('verify/{envato_user_id}', function () {
    return view('welcome');
});
