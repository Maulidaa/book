<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\AuthNew\LoginController;
use App\Http\Controllers\AuthNew\RegisterController;
use App\Http\Controllers\AuthNew\ProfileController;
use App\Http\Controllers\Chapter\ChapterController;
use App\Http\Controllers\AuthNew\LogoutController;
use App\Http\Controllers\Chapter\CommentController;


// Auth routes
Route::prefix('auth')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/update-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// Route default /dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/books-data', [DashboardController::class, 'booksData'])->name('dashboard.booksData');

// Book routes
Route::prefix('books')->group(function () {
    Route::get('data', [BookController::class, 'yourBook'])->name('books.data');
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/', [BookController::class, 'store'])->name('books.store');
    Route::get('/{id}', [BookController::class, 'show'])->name('books.show');
    Route::get('/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::get('/export/excel', [BookController::class, 'download_excel'])->name('books.export.excel');
    Route::prefix('{id}/chapters')->group(function () {
        Route::get('/', [ChapterController::class, 'index'])->name('books.chapters');
        Route::get('/create', [ChapterController::class, 'create'])->name('chapters.create');
        Route::post('/', [ChapterController::class, 'store'])->name('chapters.store');
        Route::prefix('/{chapterId}')->group(function () {
            Route::get('/edit', [ChapterController::class, 'edit'])->name('chapters.edit');
            Route::put('/', [ChapterController::class, 'update'])->name('chapters.update');
            Route::delete('/', [ChapterController::class, 'destroy'])->name('chapters.destroy');
            Route::get('/download-pdf', [ChapterController::class, 'download_pdf'])->name('chapters.download_pdf');
            Route::get('/show', [ChapterController::class, 'show'])->name('chapters.show');
            Route::post('/comments', [CommentController::class, 'store'])->name('chapters.comments.store'); 
            Route::get('/show', [ChapterController::class, 'show'])->name('chapters.show');
        });
        
        Route::get('/download_all_chapters', [ChapterController::class, 'download_all_chapters'])->name('chapters.download_all');
    });
    Route::get('/books/{id}/chapters/data', [ChapterController::class, 'chapterData'])->name('chapters.data');
});

// Redirect from root to dashboard
Route::get('/', [DashboardController::class, 'redirectToDashboard'])->name('home');