@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg rounded-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">Daftar Buku</h3>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <form action="{{ route('user.book.index') }}" method="GET" class="input-group">
                            <input type="text" name="search" class="form-control rounded-start"
                                placeholder="Cari buku atau pengarang..." value="{{ request('search') }}">
                            <button class="btn btn-primary rounded-end" type="submit">Cari</button>
                        </form>
                    </div>
                </div>

                <div class="row justify-content-center">
                    @forelse ($books as $book)
                        <div class="col-lg-4 col-md-6 mb-4 rounded-lg">
                            <div class="card shadow border-0 rounded-lg overflow-hidden h-100">
                                <div class="row g-0">
                                    <div class="col-md-5 d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                            class="img-fluid" style="height: 250px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body d-flex flex-column p-3">
                                            <h5 class="card-title fw-bold text-primary">{{ $book->title }}</h5>
                                            <div class="mb-1">
                                                <span class="text-muted">Pengarang:</span>
                                                <span class="fw-medium text-dark">{{ $book->author }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <span class="text-muted">Penerbit:</span>
                                                <span class="fw-medium text-dark">{{ $book->publisher }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <span class="text-muted">Tahun:</span>
                                                <span class="fw-medium text-dark">{{ $book->year }}</span>
                                            </div>
                                            <div class="mb-3">
                                                <span class="text-muted">Stok:</span>
                                                <span class="{{ $book->stock > 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $book->stock > 0 ? $book->stock . ' tersedia' : 'Tidak tersedia' }}
                                                </span>
                                            </div>
                                            <div class="mt-auto text-center">
                                                @if ($book->stock > 0)
                                                    <form action="{{ route('user.book.borrow', $book->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-primary btn-block rounded-lg mt-2">
                                                            <i class="bi bi-book me-1"></i> Pinjam Buku
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-secondary btn-block rounded-lg mt-2" disabled>
                                                        <i class="bi bi-x-circle me-1"></i> Buku Tidak Tersedia
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning text-center">
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
        </div>
    </div>
@endsection
