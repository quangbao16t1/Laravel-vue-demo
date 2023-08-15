<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CompanyController;
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

// Route::post('/auth/register', [AuthController::class, 'createUser']);
// Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->group(function () {
  Route::prefix('/companies')->group((function () {
    Route::get('/all', [CompanyController::class, 'getAll']);
    Route::post('/store', [CompanyController::class, 'store']);
    Route::get('/show/{id}', [CompanyController::class, 'show']);
  }));

  Route::prefix('/categories')->group((function () {
    Route::get('/all', [CategoryController::class, 'getAll']);
    Route::post('/store', [CategoryController::class, 'store']);
    Route::get('/show/{id}', [CategoryController::class, 'show']);
    Route::post('/update/{id}', [CategoryController::class, 'update']);
    // Route::get('/all', 'Api\CategoryController@getAll');
    // Route::post('/store', 'Api\CategoryController@store');
    // Route::get('/{id}', 'Api\CategoryController@show');
  }));
});
