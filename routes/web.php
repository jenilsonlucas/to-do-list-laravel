<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {


    Route::middleware('verified')->group(function () {
        Route::get('/app', [CategoryController::class, 'index'])->name('category.index');

        Route::post('/app', [CategoryController::class, 'store'])->name('category.store');

        Route::put('/categoria/{category}', [CategoryController::class, 'update'])->name('category.update');

        Route::delete('/categoria/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

        Route::delete('/categoria/{category}/tasks/done', [CategoryController::class, 'destroyDoneTasks'])->name('category.tasks.done.destroy');


        // Task Routes

        Route::post('/tarefas', [TaskController::class, 'store'])->name('tasks.store');
        Route::put('/tarefas/{task}', [TaskController::class, 'update'])->name('tasks.update');

        Route::delete('/tarefas/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

        // Profile user
        Route::get('/perfil', [UserController::class, 'edit'])->name('user.edit');    
        Route::put('/perfil/{user}', [UserController::class, 'update'])->name('user.update');    
        
        //loggout
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

//social Auth
Route::get('/login/{provider}/redirect', [LoginController::class, 'redirect']);
 
Route::get('/login/{provider}/callback', [LoginController::class, 'callback']);

