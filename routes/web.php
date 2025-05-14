<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {


    Route::middleware('verified')->group(function () {
        Route::get('/app', [CategoryController::class, 'index']);

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

        Route::get('/sair', [LoginController::class, 'logout']);
    });

    Route::get('/email/verificar', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verificar/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/app');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Link de verificação enviar');
    })->middleware('throttle:6,1')->name('verification.send');
});

//Auth route


Route::get('/', function () {
    $showRegister = old('form_type') === 'register';

    return view('auth.auth', compact('showRegister'));
})->name('auth');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/register', [RegisterController::class, 'register']);
