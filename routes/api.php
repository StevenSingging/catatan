<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\NoteController;

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

Route::post('login',[AuthController::class,'userLogin']);
Route::post('register',[AuthController::class,'userRegister']);
Route::get('profile-details',[AuthController::class,'userDetails'])->middleware('auth:sanctum');
Route::get('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');


Route::apiResource('notes',NoteController::class)->middleware('auth:sanctum');


