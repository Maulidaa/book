<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthNew\LoginController;
use App\Http\Controllers\AuthNew\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Book\CategorieController;

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

Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('verification', [RegisterController::class, 'verification']);
});

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index']);      // List books (server-side datatable)
    Route::post('/', [BookController::class, 'store']);     // Create book
    Route::get('/{id}', [BookController::class, 'show']);   // Show detail book

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategorieController::class, 'index']); // List categories
        Route::post('/', [CategorieController::class, 'store']); // Create category
        Route::get('/{id}', [CategorieController::class, 'show']); // Show category detail
        Route::put('/{id}', [CategorieController::class, 'update']); // Update category
        Route::delete('/{id}', [CategorieController::class, 'destroy']); // Delete category
    });
});
