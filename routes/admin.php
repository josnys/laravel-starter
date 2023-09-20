<?php

use App\Http\Controllers\Admin\AdminToUserController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function(){
     Route::get('/dashboard', DashboardController::class)->name('dashboard');
     Route::get('/user', AdminToUserController::class)->name('to.user');
});

require __DIR__ . '/auth.php';