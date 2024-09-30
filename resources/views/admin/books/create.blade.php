@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mb-4">Tambah Buku</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.book.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="author" class="form-label">Pengarang</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author') }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="publisher" class="form-label">Penerbit</label>
                    <input type="text" name="publisher" class="form-control" value="{{ old('publisher') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="year" class="form-label">Tahun</label>
                    <input type="number" name="year" class="form-control" value="{{ old('year') }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="stock" class="form-label">Stok</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id" class="form-select">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Upload Gambar</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.book.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
