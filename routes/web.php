<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;



Route::get('/', [CategoryController::class, 'index']);

Route::get('/category/create', [CategoryController::class, 'create']);

Route::post('/', [CategoryController::class, 'store'])->name('category.store');

Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');

Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');

Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');