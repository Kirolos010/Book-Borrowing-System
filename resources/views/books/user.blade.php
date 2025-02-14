@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">All Books</h2>

    <!-- Search & Filter Form -->
    <form method="GET" action="{{ route('user.index') }}" class="mb-3">
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
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
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
                    @if($book->status)
                        <button class="btn btn-primary btn-sm borrow-book" data-id="{{ $book->id }}">
                            Borrow
                        </button>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled>Not Available</button>
                    @endif
                    <!-- Export PDF Button -->
                    <a href="{{ route('export.book.pdf', $book->id) }}" class="btn btn-danger btn-sm">
                        Export PDF
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($books->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $books->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(".borrow-book").click(function() {
        let bookId = $(this).data("id");
        $.ajax({
            url: `/borrow/${bookId}`,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    // Update UI to show that book is borrowed
                    $("#status-" + bookId).removeClass("bg-success").addClass("bg-danger").text("Not Available");
                    $("#book-" + bookId + " .borrow-book").replaceWith('<button class="btn btn-secondary btn-sm" disabled>Not Available</button>');
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message);
            }
        });
    });
});
</script>
@endsection
