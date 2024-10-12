@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Buku</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('admin.book.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Tambah Buku
            </a>

            {{-- <form action="{{ route('admin.book.search') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" placeholder="Cari buku..." value="{{ request()->input('search') }}"
                        class="form-control" aria-label="Cari buku">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary ms-2">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form> --}}

            <form action="{{ route('admin.book.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari buku atau pengarang..."
                        value="{{ request('search') }}">
                    <button class="btn btn-primary ms-2" type="submit">Cari</button>
                </div>
            </form>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($books->isEmpty())
            <div class="alert alert-warning">
                @if (request()->input('search'))
                    Tidak ada buku yang ditemukan untuk kata kunci "<strong>{{ request()->input('search') }}</strong>".
                @else
                    Tidak ada buku yang tersedia.
                @endif
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="thead-light table-primary">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Gambar</th>
                            <th style="width: 20%">Judul</th>
                            <th style="width: 15%">Pengarang</th>
                            <th style="width: 15%;">Penerbit</th>
                            <th style="width: 10%">Tahun</th>
                            <th style="width: 5%">Stok</th>
                            <th style="width: 10%">Kategori</th>
                            <th style="width: 10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $key => $book)
                            <tr>
                                <td>{{ ($books->currentPage() - 1) * $books->perPage() + ($key + 1) }}</td>
                                <td>
                                    {{-- <?php dd($book->image); ?> --}}
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                        style="width: 100px; height: 125px;">
                                </td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->publisher }}</td>
                                <td>{{ $book->year }}</td>
                                <td>{{ $book->stock }}</td>
                                <td>{{ $book->category->name ?? 'Tanpa Kategori' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.book.edit', $book->slug) }}"
                                            class="btn btn-warning btn-sm mx-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.book.destroy', $book->slug) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mx-1" title="Hapus">
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
            <div class="d-flex justify-content-center">
                {{ $books->links() }}
            </div>
        @endif
    </div>
@endsection
