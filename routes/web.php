<?php

use Illuminate\Support\Facades\Route;

// routes/web.php

use App\Http\Controllers\TodoController;

// Route::get('/', [TodoController::class, 'showTodos']);
Route::post('/todos/add', [TodoController::class, 'addTodo'])->name('todos.add');
Route::get('/todos/delete/{id}', [TodoController::class, 'deleteTodo'])->name('todos.delete');


Route::get('/', [TodoController::class, 'showTodos']);
