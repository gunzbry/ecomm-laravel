<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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

Route::get('/login', function () {
    return view('login');
});

Route::get('/logout', function () {
    Session::forget('user');
    return redirect('login');
});
Route::view('register', 'register');
Route::post('/register', [UserController::class, 'register']);

Route::post('/login', [UserController::class, 'login']);
Route::get('/', [ProductController::class, 'index']);

Route::get('/detail/{id}', [ProductController::class, 'detail']);
Route::get('/search', [ProductController::class, 'search']);

Route::post('add_to_cart', [ProductController::class, 'add_to_cart']);
Route::get('cart_list', [ProductController::class, 'cart_list']);

Route::get('/removecart/{id}', [ProductController::class, 'remove_from_cart']);

Route::get('/ordernow/', [ProductController::class, 'orderNow']);
Route::post('/orderplace/', [ProductController::class, 'orderPlace']);

Route::get('/myorders', [ProductController::class, 'myOrders']);

// Route::get()