<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\AuthNew\LoginController;
use App\Http\Controllers\AuthNew\RegisterController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/books/export/excel', [BookController::class, 'download_excel'])->name('books.export.excel');

Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

Route::get('/register', [RegisterController::class, 'index'])->name('register');

