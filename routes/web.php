<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer routes - Staff and Admin can view/add/edit, only Admin can delete
    Route::resource('customers', CustomerController::class)->except(['destroy']);
    Route::middleware('isAdmin')->group(function () {
        Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        Route::get('customers-export-csv', [CustomerController::class, 'exportCsv'])->name('customers.export.csv');
        Route::get('customers-export-pdf', [CustomerController::class, 'exportPdf'])->name('customers.export.pdf');
    });

    // Order routes - Staff and Admin can view/add/edit, only Admin can delete
    Route::resource('orders', OrderController::class)->except(['destroy']);
    Route::middleware('isAdmin')->group(function () {
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('orders-export-csv', [OrderController::class, 'exportCsv'])->name('orders.export.csv');
        Route::get('orders-export-pdf', [OrderController::class, 'exportPdf'])->name('orders.export.pdf');
    });

    // User management routes (Admin only)
    Route::middleware('isAdmin')->group(function () {
        Route::resource('users', UserController::class);
    });
});

require __DIR__.'/auth.php';