<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', [TaskController::class, 'login'])->name('login');
Route::get('/task', [TaskController::class, 'getTask'])->name('get.task');
Route::get('/create-task', [TaskController::class, 'createTask'])->name('create.task');
Route::post('/save-task', [TaskController::class, 'saveTask'])->name('save.task');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('edit.task');
Route::put('/tasks/{task}', [TaskController::class, 'saveTask'])->name('update.task');
Route::delete('/delete-task/{task}', [TaskController::class, 'deleteTask'])->name('delete.task');