<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $this->authorize('create', Book::class);
        return view('books.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Book::class);

        $validated = $request->validate([
            'title' => 'required|max::255',
            'author' => 'required|max::255',
            'isbn' => 'required|unique:books',
            'description' => 'nullable',
            'quantity' => 'required|integer|min:0',
        ]);

        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }
}
