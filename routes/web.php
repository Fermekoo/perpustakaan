<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'author', 'middleware' => ['auth']], function(){
    Route::get('/',[AuthorController::class, 'index'])->name('author.index');
    Route::post('/',[AuthorController::class, 'create'])->middleware('admin')->name('author.create');
    Route::get('/data',[AuthorController::class, 'dataAuthor'])->name('author.data');
    Route::put('/{id}',[AuthorController::class, 'update'])->middleware('admin')->name('author.update');
    Route::delete('/{id}',[AuthorController::class, 'delete'])->middleware('admin')->name('author.delete');
});
Route::group(['prefix' => 'user', 'middleware' => ['auth','admin']], function(){
    Route::get('/',[UserController::class, 'index'])->name('user.index');
    Route::post('/',[UserController::class, 'create'])->name('user.create');
    Route::get('/data',[UserController::class, 'dataUser'])->name('user.data');
    Route::put('/{id}',[UserController::class, 'update'])->name('user.update');
    Route::delete('/{id}',[UserController::class, 'delete'])->name('user.delete');
});

Route::group(['prefix' => 'book', 'middleware' => ['auth']], function(){
    Route::get('/',[BookController::class, 'index'])->name('book.index');
    Route::get('/data',[BookController::class, 'dataBook'])->name('book.data');
    Route::get('/create',[BookController::class, 'create'])->middleware('admin')->name('book.create');
    Route::post('/create',[BookController::class, 'store'])->middleware('admin')->name('book.store');
    Route::get('/{id}/detail',[BookController::class, 'detail'])->name('book.detail');
    Route::put('/{id}/detail',[BookController::class, 'update'])->middleware('admin')->name('book.update');
    Route::delete('/{id}/delete',[BookController::class, 'delete'])->middleware('admin')->name('book.delete');
});
