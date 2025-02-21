<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Books
    Route::resource('books', Controllers\BookController::class);

    // Specific middleware for specific actions
    Route::middleware(['role:admin,operator'])->group(function () {
        Route::post('books', [Controllers\BookController::class, 'store'])->name('books.store');
        Route::put('books/{book}', [Controllers\BookController::class, 'update'])->name('books.update');
        Route::delete('books/{book}', [Controllers\BookController::class, 'destroy'])->name('books.destroy');
    });

    // Notification
    Route::get('/notifications', [Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-as-read', [Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // Loan
    Route::post('/loans', [Controllers\BookLoanController::class, 'store'])->name('loans.store');
    Route::post('/loans/{loan}/return', [Controllers\BookLoanController::class, 'return'])->name('loans.return');

    // Menambahkan rute untuk meminjam dan mengembalikan buku
    Route::post('books/{book}/borrow', [Controllers\BookLoanController::class, 'borrow'])->name('books.borrow');
    Route::post('books/{book}/return', [Controllers\BookLoanController::class, 'return'])->name('books.return');
});

require __DIR__ . '/auth.php';
