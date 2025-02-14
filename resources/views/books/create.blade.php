@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Book</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Book Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Author</label>
            <input type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') }}">
            @error('author')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Upload File</label>
            <input type="file" class="form-control @error('file') is-invalid @enderror" name="file">
            @error('file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror">
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Available</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Not available</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Add Book</button>
    </form>
</div>
@endsection
