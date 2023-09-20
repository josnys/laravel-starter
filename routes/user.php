<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserToAdminController;

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth', 'verified']], function () {
     Route::get('/dashboard', DashboardController::class)->name('dashboard');
     Route::get('admin', UserToAdminController::class)->name('to.admin');

     // Profile
     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';