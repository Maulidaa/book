<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\AuthNew\LoginController;
use App\Http\Controllers\AuthNew\RegisterController;
use App\Http\Controllers\AuthNew\ProfileController;
use App\Http\Controllers\Chapter\ChapterController;

// Auth routes
Route::prefix('auth')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/update-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});

// Home redirect
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/books-data', [DashboardController::class, 'booksData'])->name('dashboard.booksData');

// Book routes
Route::prefix('book')->group(function () {
    Route::get('/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/{id}', [BookController::class, 'destroy'])->name('books.destroy');
});
Route::get('/books/export/excel', [BookController::class, 'download_excel'])->name('books.export.excel');
Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');

// Chapter routes
Route::prefix('books/{id}/chapters')->group(function () {
    Route::get('/', [ChapterController::class, 'index'])->name('books.chapters');
    Route::get('/create', [ChapterController::class, 'create'])->name('chapters.create');
    Route::post('/', [ChapterController::class, 'store'])->name('chapters.store');
    Route::get('/{chapterId}/edit', [ChapterController::class, 'edit'])->name('chapters.edit');
    Route::put('/{chapterId}', [ChapterController::class, 'update'])->name('chapters.update');
    Route::delete('/{chapterId}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
    Route::get('/download_all_chapters', [ChapterController::class, 'download_all_chapters'])->name('chapters.download_all');
    Route::get('/{chapterId}/download-pdf', [ChapterController::class, 'download_pdf'])->name('chapters.download_pdf');
    Route::get('/show', [ChapterController::class, 'show'])->name('chapters.show');
    Route::get('/{chapterId}/show', [ChapterController::class, 'show'])->name('chapters.show');
    Route::post('/{chapterId}/comments', [\App\Http\Controllers\Chapter\CommentController::class, 'store'])->name('chapters.comments.store');   
});
Route::get('/books/{id}/chapters/data', [ChapterController::class, 'chapterData'])->name('chapters.data');