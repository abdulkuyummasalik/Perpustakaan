@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Buku</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.book.update', $book->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="author" class="form-label">Pengarang</label>
                        <input type="text" name="author" class="form-control" value="{{ $book->author }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="publisher" class="form-label">Penerbit</label>
                        <input type="text" name="publisher" class="form-control" value="{{ $book->publisher }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="year" class="form-label">Tahun</label>
                        <input type="number" name="year" class="form-control" value="{{ $book->year }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" name="stock" class="form-control" value="{{ $book->stock }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Ganti Gambar</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.book.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
    </div>
@endsection
