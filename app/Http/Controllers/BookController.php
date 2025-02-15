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
}
