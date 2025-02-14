@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Books Management</h2>

    {{-- Search & Filter Form --}}
    <form action="{{ route('books.index') }}" method="GET" class="mb-3">
        <div class="row g-2">
            <!-- Search Input -->
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Search by Title or Author" value="{{ request('search') }}">
            </div>

            <!-- Status Filter -->
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Available</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Not Available</option>
                </select>
            </div>

            <!-- Filter & Reset Buttons -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('books.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    @can('create books')
        <a href="{{ route('books.create') }}" class="btn btn-success mb-3">Add New Book</a>
    @endcan

    <div class="table-responsive">
        <table class="table table-bordered" id="booksTable">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr id="book-{{ $book->id }}">
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>
                        @if ($book->file && Storage::disk('public')->exists($book->file))
                            <a href="{{ asset('storage/' . $book->file) }}" target="_blank" class="btn btn-sm btn-secondary">
                                View File
                            </a>
                        @else
                            <span class="text-danger">File Not Found</span>
                        @endif
                    </td>
                    <td>
                        <span id="status-{{ $book->id }}" class="badge {{ $book->status ? 'bg-success' : 'bg-danger' }}">
                            {{ $book->status ? 'Available' : 'Not Available' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('books.show', $book) }}" class="btn btn-info btn-sm">View</a>

                        @can('update books')
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan

                        @can('delete books')
                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Laravel Pagination --}}
    @if ($books->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $books->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>
@endsection
