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
        Route::get('/', [RoleController::class, 'index'])->middleware('permission:role.lihat');
        Route::post('/', [RoleController::class, 'store'])->middleware('permission:role.tambah');
        Route::put('/{id}', [RoleController::class, 'update'])->middleware('permission:role.ubah');
        Route::delete('/{id}', [RoleController::class, 'destroy'])->middleware('permission:role.hapus');
        Route::post('/bulkdelete', [RoleController::class, 'bulkDestroy'])->middleware('permission:role.hapus');
    });

    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', [PermissionController::class, 'index'])->middleware('permission:permission.lihat');
        Route::post('/', [PermissionController::class, 'store'])->middleware('permission:permission.tambah');
        Route::put('/{id}', [PermissionController::class, 'update'])->middleware('permission:permission.ubah');
        Route::delete('/{id}', [PermissionController::class, 'destroy'])->middleware('permission:permission.hapus');
        Route::post('/bulkdelete', [PermissionController::class, 'bulkDestroy'])->middleware('permission:permission.hapus');
    });

    Route::group(['prefix' => 'assignpermission'], function () {
        Route::get('/roles', [AssignPermissionController::class, 'getRoles'])->middleware('permission:assignpermission.lihat');
        Route::get('/getroleandpermission/{id}', [AssignPermissionController::class, 'getRoleAndPermission'])->middleware('permission:assignpermission.lihat');
        Route::get('/getpermission', [AssignPermissionController::class, 'getPermissions'])->middleware('permission:assignpermission.lihat');
        Route::post('/assignpermission', [AssignPermissionController::class, 'assignPermission'])->middleware('permission:assignpermission.ubah');
        Route::post('/revokepermission', [AssignPermissionController::class, 'revokePermission'])->middleware('permission:assignpermission.ubah');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->middleware('permission:pengguna.lihat');
        Route::post('/', [UserController::class, 'store'])->middleware('permission:pengguna.tambah');
        Route::put('/{user}', [UserController::class, 'update'])->middleware('permission:pengguna.ubah');
        Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('permission:pengguna.hapus');
        Route::post('/bulkdelete', [UserController::class, 'bulkDestroy'])->middleware('permission:pengguna.hapus');
        Route::post('/resetpassword', [UserController::class, 'resetPassword'])->middleware('permission:pengguna.ubah');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'getGeneralInformation']);
        Route::post('/updategeneralinformations', [ProfileController::class, 'updateGeneralInformation']);
        Route::post('/updatepassword', [ProfileController::class, 'updatePassword']);
        Route::post('/updateimage', [ProfileController::class, 'updateImage']);
    });
});
