<?php

use App\Http\Controllers\UserArticleController;
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

Route::prefix('user/articles')
    ->group(function () {
        Route::get('/', [UserArticleController::class, 'index']);
        Route::post('/actualize', [UserArticleController::class, 'actualizeSeoSlugs']);
        Route::get('/{$id}', [UserArticleController::class, 'read']);
        Route::post('/{$id}', [UserArticleController::class, 'create']);
        Route::patch('/{$id}', [UserArticleController::class, 'update']);
        Route::delete('/{$id}', [UserArticleController::class, 'delete']);
    });

