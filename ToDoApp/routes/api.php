<?php

use App\Http\Controllers\ToDoController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('todos', [ToDoController::class, 'index']);

Route::get('todo/{id}', [ToDoController::class, 'show']);

Route::post('todo', [ToDoController::class, 'store']);

// Update item
Route::put('todo', [ToDoController::class, 'store']);

Route::delete('todo/{id}', [ToDoController::class, 'destroy']);
