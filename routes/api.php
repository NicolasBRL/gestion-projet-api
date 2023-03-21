<?php

use App\Http\Controllers\API\ProjetController;
use App\Http\Controllers\API\TacheController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('projets', ProjetController::class);
Route::apiResource('taches', TacheController::class);
Route::apiResource('users', UserController::class);

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout'])->name('logout');
