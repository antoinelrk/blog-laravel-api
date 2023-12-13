<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('articles.')->prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'list']);
    Route::get('/{slug}', [ArticleController::class, 'get'])->where('slug', '^[0-9]+(?:-[a-zA-Z0-9]+)*$');
    Route::post('/', [ArticleController::class, 'create']);
    Route::patch('/{slug}', [ArticleController::class, 'update'])->where('slug', '^[0-9]+(?:-[a-zA-Z0-9]+)*$');
    Route::delete('/{slug}', [ArticleController::class, 'delete'])->where('slug', '^[0-9]+(?:-[a-zA-Z0-9]+)*$');
});

Route::name('categories.')->prefix('categories')->group(function () {
    Route::get('/{excludedId?}', [CategoryController::class, 'list'])->where('excludedId', '^[0-9]+$');
});
