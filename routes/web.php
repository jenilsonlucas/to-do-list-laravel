<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;



Route::get('/', [CategoryController::class, 'index']);

Route::get('/categoria/criar', [CategoryController::class, 'create']);

Route::post('/', [CategoryController::class, 'store'])->name('category.store');

Route::get('/categoria/{category}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/categoria/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');

Route::put('/categoria/{category}', [CategoryController::class, 'update'])->name('category.update');

Route::delete('/categoria/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');


// Task Routes

Route::get('/tarefas', [TaskController::class, 'index'])->name('tasks.index');

Route::get('/tarefas/criar', [TaskController::class, 'create'])->name('tasks.create');

Route::post('/tarefas', [TaskController::class, 'store'])->name('tasks.store');

Route::get('/tarefas/{task}', [TaskController::class, 'show'])->name('tasks.show');

Route::get('/tarefas/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

Route::put('/tarefas/{task}', [TaskController::class, 'update'])->name('tasks.update');

Route::delete('/tarefas/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');


//Auth route

Route::get('/entrar', [LoginController::class, 'index'])->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/registrar', [RegisterController::class, 'showRegisterForm'])->name('register');

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout']);