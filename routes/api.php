<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\AuthController;
use \App\Http\Controllers\TodoListController;
use \App\Http\Controllers\LabelController;
use \App\Http\Controllers\TaskController;

Route::post('/register', [AuthController::class, "register"])->name('user.register');
Route::post('/login', [AuthController::class, "login"])->name('user.login');

Route::group([
    "middleware" => ['auth:sanctum']
], function () {

    Route::apiResource("todo-list", TodoListController::class);
    Route::apiResource("label", LabelController::class);

    Route::get("todo-list/{list_id}/task",[TaskController::class, "index"])->name('task.index');
    Route::post("todo-list/{list_id}/task",[TaskController::class, "store"])->name('task.store');
    Route::put("todo-list/{list_id}/task/{task_id}",[TaskController::class, "update"])->name('task.update');
    Route::delete("todo-list/{list_id}/task/{task_id}",[TaskController::class, "destroy"])->name('task.destroy');

});
