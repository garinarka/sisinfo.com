<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [Controllers\DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Books
    Route::resource('books', Controllers\BookController::class);

    // Book Loans
    Route::post('/loans', [Controllers\BookLoanController::class, 'store'])->name('loans.store');
    Route::patch('/loans/{bookLoan}/return', [Controllers\BookLoanController::class, 'return'])
        ->name('loans.return')
        ->middleware('can:return,bookLoan');

    // Notifications
    Route::get('/notifications', function () {
        return view('notifications.index');
    })->name('notifications.index');
});

require __DIR__ . '/auth.php';
