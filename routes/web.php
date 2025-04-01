<?php

use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('users')->name('users.')->group(function () {
    Route::get('create', [UserController::class, 'create'])->name('create');
    Route::get('{id}', [UserController::class, 'show'])->name('show');
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('store', [UserController::class, 'store'])->name('store');
});

Route::get('/token', [TokenController::class, 'generateToken'])->name('web.token.generate');
