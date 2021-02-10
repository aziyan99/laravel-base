<?php

use App\Http\Controllers\Api\V1\Backend\AssignPermissionController;
use App\Http\Controllers\Api\V1\Backend\AuthController;
use App\Http\Controllers\Api\V1\Backend\PermissionController;
use App\Http\Controllers\Api\V1\Backend\ProfileController;
use App\Http\Controllers\Api\V1\Backend\RoleController;
use App\Http\Controllers\Api\V1\Backend\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::post('/', [RoleController::class, 'store']);
        Route::put('/{id}', [RoleController::class, 'update']);
        Route::delete('/{id}', [RoleController::class, 'destroy']);
        Route::post('/bulkdelete', [RoleController::class, 'bulkDestroy']);
    });

    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', [PermissionController::class, 'index']);
        Route::post('/', [PermissionController::class, 'store']);
        Route::put('/{id}', [PermissionController::class, 'update']);
        Route::delete('/{id}', [PermissionController::class, 'destroy']);
        Route::post('/bulkdelete', [PermissionController::class, 'bulkDestroy']);
    });

    Route::group(['prefix' => 'assignpermission'], function () {
        Route::get('/roles', [AssignPermissionController::class, 'getRoles']);
        Route::get('/getroleandpermission/{id}', [AssignPermissionController::class, 'getRoleAndPermission']);
        Route::get('/getpermission', [AssignPermissionController::class, 'getPermissions']);
        Route::post('/assignpermission', [AssignPermissionController::class, 'assignPermission']);
        Route::post('/revokepermission', [AssignPermissionController::class, 'revokePermission']);
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
        Route::post('/bulkdelete', [UserController::class, 'bulkDestroy']);
        Route::post('/resetpassword', [UserController::class, 'resetPassword']);
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'getGeneralInformation']);
        Route::post('/updategeneralinformations', [ProfileController::class, 'updateGeneralInformation']);
        Route::post('/updatepassword', [ProfileController::class, 'updatePassword']);
        Route::post('/updateimage', [ProfileController::class, 'updateImage']);
    });
});
