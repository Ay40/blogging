<?php

use App\Http\Controllers\ArticleController;
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

Route::get('/',  [ArticleController::class, 'index']);

Route::get('/articles',  [ArticleController::class, 'index']);
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');


Route::get('/articles/detail/{id}',  [ArticleController::class, 'detail']);



Route::get('/articles/add', [ArticleController::class, 'create']);
Route::post('/articles', [ArticleController::class, 'store']);



// Show edit form
Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
// Handle update
Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');



Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');


Route::get('/articles/delete/{id}',  [ArticleController::class, 'delete']);







Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
