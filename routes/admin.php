<?php

use App\Http\Controllers\Admin\AdminToUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\User\ChangeUserPasswordController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function(){
     Route::get('/dashboard', DashboardController::class)->name('dashboard');
     Route::get('/to-user', AdminToUserController::class)->name('to.user');

     Route::group(['prefix' => 'users', 'as' => 'user.'], function(){
          Route::get('/', [UserController::class, 'index'])->name('index');
          Route::get('/{user:username}/edit', [UserController::class, 'edit'])->name('edit');
          Route::patch('/{user:username}/edit', [UserController::class, 'update'])->name('update');

          // Password Change
          Route::get('/{user:username}/password', [ChangeUserPasswordController::class, 'edit'])->name('password.edit');
          Route::patch('/{user:username}/password', [ChangeUserPasswordController::class, 'update'])->name('password.update');
     });
});

require __DIR__ . '/auth.php';