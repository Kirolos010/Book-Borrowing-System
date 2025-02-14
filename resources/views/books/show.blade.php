@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Book Details</h2>
    <p><strong>Title:</strong> {{ $book->title }}</p>
    <p><strong>Author:</strong> {{ $book->author }}</p>
    <p><strong>Status:</strong> {{ $book->status ? 'Available' : 'Not available' }}</p>
    <p><strong>File:</strong> <a href="{{ asset('storage/' . $book->file) }}" target="_blank">View</a></p>

    <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
