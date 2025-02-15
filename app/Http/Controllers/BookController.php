<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Availability Filter
        if ($request->has('availability')) {
            if ($request->availability === 'available') {
                $query->where('is_available', true);
            } elseif ($request->availability === 'borrowed') {
                $query->where('is_available', false);
            }
        }

        // Sorting
        switch ($request->sort) {
            case 'author':
                $query->orderBy('author');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->orderBy('title');
        }

        $books = $query->paginate(10)->withQueryString();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('operator')) {
            abort(403, 'Unauthorized action.');
        }

        return view('books.create');
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('operator')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:books',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string'
        ]);

        $book = Book::create($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book created successfully.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book)
    {
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('operator')) {
            abort(403, 'Unauthorized action.');
        }

        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Book $book)
    {
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('operator')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:books,isbn,' . $book->id,
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string'
        ]);

        $book->update($validated);

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book)
    {
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('operator')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Check if book has any active loans
            if ($book->bookLoans()->where('returned_date', null)->exists()) {
                return redirect()
                    ->route('books.show', $book)
                    ->with('error', 'Cannot delete book. There are active loans for this book.');
            }

            $title = $book->title; // Store title before deletion for success message
            $book->delete();

            return redirect()
                ->route('books.index')
                ->with('success', "Book '$title' has been successfully deleted.");

        } catch (\Exception $e) {
            return redirect()
                ->route('books.show', $book)
                ->with('error', 'An error occurred while deleting the book. Please try again.');
        }
    }
}
