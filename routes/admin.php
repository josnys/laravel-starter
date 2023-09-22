<?php

use App\Http\Controllers\Admin\AdminToUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\User\ChangeUserPasswordController;
use App\Http\Controllers\Admin\User\PermissionController;
use App\Http\Controllers\Admin\User\RoleController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function(){
     Route::get('/dashboard', DashboardController::class)->name('dashboard');
     Route::get('/to-user', AdminToUserController::class)->name('to.user');

     Route::group(['prefix' => 'permission', 'as' => 'permission.'], function(){
          Route::get('/', [PermissionController::class, 'index'])->name('index');
          Route::post('/create', [PermissionController::class, 'store'])->name('store');
          Route::patch('/{permission:slug}/edit', [PermissionController::class, 'update'])->name('update');
     });

     Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
          Route::get('/', [RoleController::class, 'index'])->name('index');
          Route::post('/create', [RoleController::class, 'store'])->name('store');
          Route::patch('/{role:slug}/edit', [RoleController::class, 'update'])->name('update');
     });

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