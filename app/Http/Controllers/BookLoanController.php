<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\User;
use App\Notifications\BookBorrowed;
use App\Notifications\BookDueReminder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookLoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'due_date' => 'required|date|after:today'
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if (!$book->is_available || $book->quantity <= 0) {
            return back()->with('error', 'Book is not available for loan.');
        }

        $bookLoan = BookLoan::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'borrowed_date' => Carbon::now(),
            'due_date' => $validated['due_date'],
            'status' => 'borrowed'
        ]);

        $book->decrement('quantity');
        $book->update(['is_available' => $book->quantity > 0]);

        // Notify admins and operators
        $adminsAndOperators = User::whereHas('role', function ($query) {
            $query->whereIn('name', ['admin', 'operator']);
        })->get();

        foreach ($adminsAndOperators as $user) {
            $user->notify(new BookBorrowed($bookLoan));
        }

        return redirect()->route('books.index')
            ->with('success', 'Book borrowed successfully.');
    }

    public function return(BookLoan $bookLoan)
    {
        $this->authorize('return', $bookLoan);

        $bookLoan->update([
            'returned_date' => Carbon::now(),
            'status' => 'returned'
        ]);

        $bookLoan->book->increment('quantity');
        $bookLoan->book->update(['is_available' => true]);

        return redirect()->route('loans.index')
            ->with('success', 'Book returned successfully.');
    }

    public function checkDueBooks()
    {
        $dueSoonLoans = BookLoan::where('status', 'borrowed')
            ->whereDate('due_date', '=', Carbon::tomorrow())
            ->get();

        foreach ($dueSoonLoans as $loan) {
            // Notify borrower
            $loan->user->notify(new BookDueReminder($loan));

            // Notify admins and operators
            $adminsAndOperators = User::whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'operator']);
            })->get();

            foreach ($adminsAndOperators as $user) {
                $user->notify(new BookDueReminder($loan));
            }
        }
    }
}
