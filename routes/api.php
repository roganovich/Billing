<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => '/v1/',], function () {
    // Страницы WIKI
    Route::group(['prefix' => 'wikipages'], function () {
        // Список, поиск записей
        Route::post('', [\App\Http\Controllers\Api\V1\WikipagesController::class, 'index']);
        // Создание новой записи
        Route::post('store', [\App\Http\Controllers\Api\V1\WikipagesController::class, 'store']);
        // Получить данные записи
        Route::get('{id}/get', [\App\Http\Controllers\Api\V1\WikipagesController::class, 'get']);
        // Обновить запись
        Route::post('{id}/update', [\App\Http\Controllers\Api\V1\WikipagesController::class, 'update']);
        // Удалить запись
        Route::delete('{id}/destroy', [\App\Http\Controllers\Api\V1\WikipagesController::class, 'destroy']);
        // Пролучить категории
        Route::get('parentlist', [\App\Http\Controllers\Api\V1\WikipagesController::class, 'parentlist']);
        // Загрузить изображение
        Route::post('addimage', [\App\Http\Controllers\Api\V1\WikipagesController::class, 'addimage']);
    });

    // Страницы Users
    Route::group(['prefix' => 'users'], function () {
        // Список, поиск записей
        Route::post('', [\App\Http\Controllers\Api\V1\UsersController::class, 'index']);
        // Создание новой записи
        Route::post('store', [\App\Http\Controllers\Api\V1\UsersController::class, 'store']);
        // Получить данные записи
        Route::get('{id}/get', [\App\Http\Controllers\Api\V1\UsersController::class, 'get']);
        // Получить список ролей
        Route::get('rolelist', [\App\Http\Controllers\Api\V1\UsersController::class, 'rolelist']);
        // Получить данные текущего пользователя
        Route::get('current', [\App\Http\Controllers\Api\V1\UsersController::class, 'current'])->name('api.v1.users.current');
        // Обновить запись
        Route::post('{id}/update', [\App\Http\Controllers\Api\V1\UsersController::class, 'update']);
        // Удалить запись
        Route::delete('{id}/destroy', [\App\Http\Controllers\Api\V1\UsersController::class, 'destroy']);
    });
});
