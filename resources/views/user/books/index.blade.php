@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4 fw-bold text-primary">Daftar Buku</h1>
        <div class="row justify-content-center">
            @foreach ($books as $book)
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="card-img-top"
                            style="height: 300px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-primary text-truncate">{{ $book->title }}</h5>
                            <table class="table table-borderless table-sm mb-2">
                                <tr>
                                    <th class="text-muted" style="width: 40%;">Pengarang:</th>
                                    <td class="text-truncate">{{ $book->author }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Penerbit:</th>
                                    <td class="text-truncate">{{ $book->publisher }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Tahun:</th>
                                    <td>{{ $book->year }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Stok:</th>
                                    <td>
                                        @if ($book->stock > 0)
                                            <span class="text-success">{{ $book->stock }} tersedia</span>
                                        @else
                                            <span class="text-danger">Tidak tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            <div class="mt-auto">
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
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{-- {{ $books->links() }} --}}
        </div>
    </div>
@endsection
