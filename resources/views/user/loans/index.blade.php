@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4 fw-bold text-primary">Daftar Peminjaman Aktif</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Search Form -->
        <form action="{{ route('user.loans.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari judul atau pengarang..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary ms-2" type="submit">Cari</button>
            </div>
        </form>

        @if ($loans->isEmpty())
            <div class="alert alert-warning">
                @if (request()->input('search'))
                    Tidak ada peminjaman yang ditemukan untuk kata kunci
                    "<strong>{{ request()->input('search') }}</strong>".
                @else
                    Tidak ada peminjaman yang tersedia.
                @endif
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Dipinjam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $key => $loan)
                            <tr class="text-center">
                                <td>{{ ($loans->currentPage() - 1) * $loans->perPage() + ($key + 1) }}</td>
                                <td class="text-start">{{ $loan->book->title }}</td>
                                <td>{{ $loan->borrowed_at->format('d-m-Y') }}</td>
                                <td>
                                    <form action="{{ route('user.loans.return', $loan->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                                            <i class="fas fa-arrow-left"></i> Kembalikan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $loans->links() }}
            </div>
        @endif
    </div>
@endsection
