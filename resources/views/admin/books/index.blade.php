@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg rounded-0">
            <div class="card-header bg-primary text-white  rounded-0">
                <h3 class="mb-0">Manajemen Buku</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('admin.book.create') }}" class="btn btn-primary me-2 rounded-0">
                        <i class="fas fa-plus-circle"></i> Tambah Buku
                    </a>
                    <form action="{{ route('admin.book.index') }}" method="GET" class="flex-grow-1">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-0" placeholder="Cari buku atau pengarang..." value="{{ request('search') }}">
                            <button class="btn btn-primary rounded-0" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('deleted'))
                    <div class="alert alert-danger">{{ session('deleted') }}</div>
                @endif
                @if ($books->isEmpty())
                    <div class="alert alert-warning">
                        @if (request()->input('search'))
                            Tidak ada buku yang ditemukan untuk kata kunci
                            "<strong>{{ request()->input('search') }}</strong>".
                        @else
                            Tidak ada buku yang tersedia.
                        @endif
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Tahun</th>
                                    <th>Stok</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $key => $book)
                                    <tr>
                                        <td>{{ ($books->currentPage() - 1) * $books->perPage() + ($key + 1) }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                                class="img-thumbnail rounded-0" style="width: 5rem; height: 5.5rem;">
                                        </td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>{{ $book->publisher }}</td>
                                        <td>{{ $book->year }}</td>
                                        <td>{{ $book->stock }}</td>
                                        <td>{{ $book->category->name ?? 'Tanpa Kategori' }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Aksi Buku">
                                                <a href="{{ route('admin.book.edit', $book->slug) }}"
                                                    class="btn btn-warning btn-sm rounded-0 me-2" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.book.destroy', $book->slug) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-0" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $books->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
