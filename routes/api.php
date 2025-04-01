<?php

use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\CheckDynamicToken;
use Illuminate\Support\Facades\Route;


Route::get('users', [UserController::class, 'index'])->name('api.users.index');
Route::get('users/{id}', [UserController::class, 'show'])->name('api.users.show');
Route::post('users', [UserController::class, 'store'])->middleware(CheckDynamicToken::class);
Route::get('/positions', [PositionController::class, 'index'])->name('api.positions.index');

Route::get('token', [TokenController::class, 'generateToken'])->name('api.token.generate');
Route::get('users/load-more', [UserController::class, 'loadMoreUsers']);
