<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowRecordController extends Controller
{
    /**
     * Borrow a book.
     */
    public function borrow(Request $request, $book_id)
    {
        $book = Book::findOrFail($book_id);
        if ($book->status == 0) {
            return response()->json(['success' => false, 'message' => 'This book is already borrowed.'], 400);
        }
        BorrowRecord::create([
            'borrowable_id' => $book->id,
            'borrowable_type' => Book::class,
            'user_id' => Auth::id(),
        ]);
        //dd($book->id);
        $book->update(['status' => 0]);
        return response()->json([
            'success' => true,
            'message' => 'Book borrowed successfully!',
            'book_id' => $book->id
        ]);
    }

}
