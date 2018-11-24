<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/current-user', 'API\ShowCurrentUser')->name('current-user.show');
Route::middleware('auth:api')->patch('/current-user', 'API\UpdateCurrentUser')->name('current-user.update');

Route::middleware(['auth:api'])->delete('comments/{comment}', 'API\DeleteComment')->name('comments.destroy');
Route::middleware(['auth:api'])->match(['PUT', 'PATCH'], 'comments/{comment}', 'API\UpdateComment')->name('comments.update');

Route::middleware(['auth:api'])->get('game-accounts', 'API\ListGameAccounts')->name('game-accounts.index');
