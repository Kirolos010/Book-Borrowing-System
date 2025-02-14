<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowRecordController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//user website
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('user.index');
    Route::post('/borrow/{book_id}', [BorrowRecordController::class, 'borrow'])->name('borrow.book');
    Route::get('/export/book/{book_id}', [BookController::class, 'exportPdf'])->name('export.book.pdf');
});

//ADMIN DASHBOARD
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');

    Route::middleware('permission:create books')->group(function () {
        Route::get('/bookss/createe', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
    });

    Route::middleware('permission:update books')->group(function () {
        Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
    });

    Route::middleware('permission:delete books')->group(function () {
        Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    });
    Route::post('/admin/{id}/permissions', [AdminController::class, 'assignPermissions']);
});
