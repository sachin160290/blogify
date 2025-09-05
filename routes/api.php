<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\AuthController;
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



// Public endpoints
Route::get('get_blogs', [BlogApiController::class, 'index']); // public read
Route::get('get_categories', [BlogApiController::class, 'categories']); // public categories

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('add_new_blog', [BlogApiController::class, 'store']);
    Route::put('update_blog/{id}', [BlogApiController::class, 'update']);
    Route::delete('delete_blog/{id}', [BlogApiController::class, 'destroy']);
});
