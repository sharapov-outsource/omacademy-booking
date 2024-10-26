<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/bookings', [App\Http\Controllers\HomeController::class, 'storeBooking'])->name('bookings.store');

});

Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('bookings.index');
    Route::patch('/admin/status', [App\Http\Controllers\AdminController::class, 'updateStatus'])->name('bookings.updateStatus');
});
