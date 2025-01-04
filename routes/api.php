<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
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

Route::get('/', function(){
    return response()->json([
        'status'  => false,
        'message' => 'Akses tidak diperbolehkan'
    ], 401);
})->name('login');

Route::post('registerUser', [AuthController::class, 'registerUser']);
Route::post('loginUser', [AuthController::class, 'loginUser']);
Route::prefix('product')->group(function(){
    Route::get('/', [ProductController::class, 'index'])->middleware('auth:sanctum');
});