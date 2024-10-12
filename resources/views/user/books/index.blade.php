@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4 fw-bold text-primary">Daftar Buku</h1>

        <form action="{{ route('user.book.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari buku atau pengarang..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary ms-2" type="submit">Cari</button>
            </div>
        </form>

        <div class="row justify-content-center">
            @forelse ($books as $book)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="card-img-top"
                            style="height: 250px; object-fit: cover;">
                        <div class="card-body d-flex flex-column p-3" style="min-height: 250px;">
                            <h5 class="card-title fw-bold text-primary text-truncate">{{ $book->title }}</h5>
                            <div class="">
                                <span class="text-muted">Pengarang:</span>
                                <span class="mb-2 d-block text-truncate" style="max-width: 150px;">{{ $book->author }}</span>
                            </div>
                            <div class="">
                                <span class="text-muted">Penerbit:</span>
                                <span class="mb-2 d-block text-truncate" style="max-width: 150px;">{{ $book->publisher }}</span>
                            </div>
                            <div class="">
                                <span class="text-muted mb-2">Tahun:</span>
                                <span class="mb-2">{{ $book->year }}</span>
                            </div>
                            <div class="">
                                <span class="text-muted">Stok:</span>
                                <span>
                                    @if ($book->stock > 0)
                                        <span class="text-success mb-2">{{ $book->stock }} tersedia</span>
                                    @else
                                        <span class="text-danger mb-2">Tidak tersedia</span>
                                    @endif
                                </span>
                            </div>
                            <div class="mt-auto text-center">
                                @if ($book->stock > 0)
                                    <form action="{{ route('user.book.borrow', $book->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-block rounded-pill mt-2">
                                            <i class="bi bi-book me-1"></i> Pinjam Buku
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-block rounded-pill mt-2" disabled>
                                        <i class="bi bi-x-circle me-1"></i> Buku Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning">
                    @if (request()->input('search'))
                        Tidak ada buku yang ditemukan untuk kata kunci
                        "<strong>{{ request()->input('search') }}</strong>".
                    @else
                        Tidak ada buku yang tersedia.
                    @endif
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $books->links() }}
        </div>
    </div>
@endsection
