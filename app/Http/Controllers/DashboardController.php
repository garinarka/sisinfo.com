<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalBooks' => Book::count(),
            'borrowedBooks' => BookLoan::where('status', 'borrowed')->count(),
            'availableBooks' => Book::where('is_available', true)->count(),
            'dueReturns' => BookLoan::where('status', 'borrowed')
                ->where('due_date', '<=', now())
                ->count(),
            'recentActivity' => BookLoan::with(['book', 'user'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('dashboard', $data);
    }
}
