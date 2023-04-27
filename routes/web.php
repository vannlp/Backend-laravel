<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SessionController;
use App\Models\Permission;
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

    $api->get('/role/list-admin', [RoleController::class, 'listAdmin'])->middleware('permission');
    $api->post('/role/add', [RoleController::class, 'addRole'])->middleware('permission');

    // permission
    $api->get('/permission/list-admin', [PermissionController::class, 'getPermission'])->middleware('permission');
    $api->post('/permission/add', [PermissionController::class, 'createPermission'])->middleware('permission');
    $api->get('/permission/list-permission-by-role', [PermissionController::class, 'listRolePermission'])->middleware('permission');
});

require __DIR__.'/auth.php';
