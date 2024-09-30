<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;


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
    return view('home');
});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Route untuk admin
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::patch('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('book')->name('book.')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('index');
        Route::get('/create', [BookController::class, 'create'])->name('create');
        Route::post('/', [BookController::class, 'store'])->name('store');
        Route::get('/{slug}/edit', [BookController::class, 'edit'])->name('edit');
        Route::patch('/{slug}', [BookController::class, 'update'])->name('update');
        Route::delete('/{book:slug}', [BookController::class, 'destroy'])->name('destroy');
        Route::get('/search', [BookController::class, 'search'])->name('search');
    });

    Route::prefix('loans')->name('loans.')->group(function () {
        Route::get('/', [LoanController::class, 'adminIndex'])->name('index');
        Route::get('/history', [LoanController::class, 'adminHistory'])->name('history');
    });
});


// Route untuk user
Route::prefix('user')->name('user.')->middleware('user')->group(function () {
    Route::prefix('book')->name('book.')->group(function () {
        Route::get('/', [BookController::class, 'userIndex'])->name('index');
        Route::post('/borrow/{id}', [LoanController::class, 'borrow'])->name('borrow');
    });

    Route::prefix('loans')->name('loans.')->group(function () {
        Route::get('/', [LoanController::class, 'index'])->name('index');
        Route::get('/history', [LoanController::class, 'history'])->name('history');
        Route::post('/return/{id}', [LoanController::class, 'return'])->name('return');
        Route::delete('/history/{id}', [LoanController::class, 'deleteHistory'])->name('history.delete');
    });
});
