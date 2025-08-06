<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\AuthNew\LoginController;
use App\Http\Controllers\AuthNew\RegisterController;
use App\Http\Controllers\AuthNew\ProfileController;
use App\Http\Controllers\Chapter\ChapterController;

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

Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/books/export/excel', [BookController::class, 'download_excel'])->name('books.export.excel');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{id}/chapters', [ChapterController::class, 'index'])->name('books.chapters');
Route::get('/books/{id}/chapters/create', [ChapterController::class, 'create'])->name('chapters.create');
// Route::get('/books/{id}/chapters/edit', [ChapterController::class, 'edit'])->name('chapters.edit');
Route::delete('/books/{id}/chapters/{chapterId}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
Route::post('/books/{id}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
Route::get('/books/{bookId}/chapters/{chapterId}/download-pdf', [ChapterController::class, 'download_pdf'])->name('chapters.download_pdf');
// Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/update-profile', [ProfileController::class, 'update'])->name('profile.update');
// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
