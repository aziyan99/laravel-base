<?php

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
    return response()->json(['msg' => 'hello']);
    //return auth()->user()->allPermissions;
});

Route::any('/backoffice/{slug}', function () {
    return view('layouts.backend');
})->middleware('auth:sanctum');

Route::any('/auth/{slug}', function () {
    return view('layouts.auth');
});
