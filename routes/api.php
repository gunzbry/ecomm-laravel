<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dummyAPI;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductResourceController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Retrieval (Dummy API)
Route::get("data", [dummyAPI::class, 'getData']);

// Product Controller CRUD Operations
Route::get("list", [ProductController::class, 'getProducts']);
Route::post("saveproduct", [ProductController::class, 'setProducts']);
Route::put("updateproduct", [ProductController::class, 'updateProducts']);
Route::delete("deleteproduct/{id}", [ProductController::class, 'deleteProducts']);
Route::get("search/{query}", [ProductController::class, 'searchProducts']);

/**
 * Index : http://ecomm.test/api/products
 */
Route::apiResource("products", ProductResourceController::class);