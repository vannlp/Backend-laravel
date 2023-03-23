<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SessionController;
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
    return ['Laravel' => app()->version()];
})->middleware();

$api = app('Dingo\Api\Routing\Router');

$api->version(['v1'], function ($api) {
    $api->get('/get-session', [SessionController::class, 'getSession']);
    $api->get('/get-permission', [PermissionController::class, 'getPermissionByUser'])
        ->middleware('permission');
});

require __DIR__.'/auth.php';
