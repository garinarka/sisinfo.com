<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\BookLoan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin') || $user->hasRole('operator')) {
            $data = [
                'totalBooks' => Book::count(),
                'borrowedBooks' => BookLoan::where('status', 'borrowed')->count(),
                'availableBooks' => Book::where('is_available', true)->count(),
                'dueReturns' => BookLoan::where('status', 'borrowed')
                    ->where('due_date', '<=', now())
                    ->count(),
                'recentActivity' => BookLoan::with(['book', 'user'])
                    ->orderByRaw('COALESCE(returned_date, borrowed_date) DESC')
                    ->paginate(10),
            ];
        } else {
            $data = [
                'borrowedBooks' => BookLoan::where('user_id', $user->id)
                    ->whereNull('returned_date')
                    ->count(),
                'returnedBooks' => BookLoan::where('user_id', $user->id)
                    ->whereNotNull('returned_date')
                    ->count(),
                'overdueBooks' => BookLoan::where('user_id', $user->id)
                    ->whereNull('returned_date')
                    ->where('due_date', '<', now())
                    ->count(),
                'recentActivity' => BookLoan::with(['book', 'user'])
                    ->where('user_id', $user->id)
                    ->orderByRaw('COALESCE(returned_date, borrowed_date) DESC')
                    ->paginate(10),
            ];
        }

        return view('dashboard', $data, compact('user'));
    }
}
