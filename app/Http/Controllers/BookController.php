<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display all books.
     */
    public function index(Request $request)
    {
        $query = Book::query();
        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%$search%")
                  ->orWhere('author', 'like', "%$search%");
        }
        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        $books = $query->latest()->paginate(10);
        return view('books.index', compact('books'));
    }


    /**
     * Show the form for adding a new book.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a new book.
     */
    public function store(StoreBookRequest $request)
    {
        // Validate request
        $validatedData = $request->validated();
        // Handle file upload (Check if file exists)
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . strtolower(str_replace(' ', '_', $file->getClientOriginalName()));
            $filePath = $file->storeAs('uploads/books', $filename, 'public');
            $validatedData['file'] = $filePath;
        }
        Book::create([
            'title' => $validatedData['title'],
            'author' => $validatedData['author'],
            'file' => $validatedData['file'] ?? null,
            'status' => $validatedData['status'],
        ]);
        return redirect()->route('books.index')->with('success', 'Book added successfully');
    }
    /**
     * Display a single book.
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    /**
     * Update a book.
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $validatedData = $request->validated();
        $book = Book::findOrFail($id);
        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if it exists
            if ($book->file && Storage::disk('public')->exists($book->file)) {
                Storage::disk('public')->delete($book->file);
            }
            $file = $request->file('file');
            $filename = time() . '_' . strtolower(str_replace(' ', '_', $file->getClientOriginalName()));
            $filePath = $file->storeAs('uploads/books', $filename, 'public');
            $validatedData['file'] = $filePath;
        } else {
            // Keep the old file path if no new file is uploaded
            $validatedData['file'] = $book->file;
        }
        // Update
        $book->update($validatedData);
        return redirect()->route('books.index')->with('success', 'Book updated successfully');
    }

    /**
     * Delete a book.
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully');
    }
    public function exportPdf($book_id)
    {
        $book = Book::findOrFail($book_id);
        // Load view with book data
        $pdf = Pdf::loadView('books.pdf', compact('book'));
        return $pdf->download("book_{$book->id}.pdf");
    }
}
