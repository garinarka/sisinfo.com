<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\BookBorrowed;
use App\Notifications\BookReturned;

class BookLoanController extends Controller
{
    public function store(Request $request)
    {
        $book = Book::findOrFail($request->book_id);

        // Check if book is available
        if (!$book->is_available) {
            return back()->with('error', 'This book is currently not available for borrowing.');
        }

        // Check if user has reached maximum allowed loans
        $activeLoans = BookLoan::where('user_id', auth()->id())
            ->whereNull('returned_date')
            ->count();

        if ($activeLoans >= 3) { // Maximum 3 books at a time
            return back()->with('error', 'You have reached the maximum number of allowed loans.');
        }

        try {
            DB::transaction(function () use ($book) {
                // Create loan record
                $loan = BookLoan::create([
                    'user_id' => auth()->id(),
                    'book_id' => $book->id,
                    'borrowed_date' => now(),
                    'due_date' => now()->addDays(14),
                ]);

                // Update book availability
                $book->update(['is_available' => false]);

                // Send notification immediately
                auth()->user()->notify(new BookBorrowed($book, $loan));
            });

            return back()->with('success', 'Book borrowed successfully. Due date is ' . now()->addDays(14)->format('Y-m-d'));
        } catch (\Exception $e) {
            \Log::error('Loan creation failed: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while processing your request.');
        }
    }

    public function return(BookLoan $loan)
    {
        if ($loan->user_id !== auth()->id() && !auth()->user()->hasRole(['admin', 'operator'])) {
            abort(403, 'Unauthorized action.');
        }

        if ($loan->returned_date) {
            return back()->with('error', 'This book has already been returned.');
        }

        try {
            DB::transaction(function () use ($loan) {
                // Mark loan as returned
                $loan->update([
                    'returned_date' => now(),
                ]);

                // Make book available again
                $loan->book->update(['is_available' => true]);

                // Send notification
                $loan->user->notify(new BookReturned($loan->book, $loan));
            });

            return back()->with('success', 'Book returned successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while processing your request.');
        }
    }
}
