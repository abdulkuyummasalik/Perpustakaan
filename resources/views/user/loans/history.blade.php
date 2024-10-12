@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4 fw-bold text-primary">Riwayat Peminjaman</h1>

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

        <form action="{{ route('user.loans.history') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari judul atau pengarang..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary ms-2" type="submit">Cari</button>
            </div>
        </form>

        @if ($history->isEmpty())
            <div class="alert alert-warning">
                @if (request()->input('search'))
                    Tidak ada riwayat peminjaman yang ditemukan untuk kata kunci
                    "<strong>{{ request()->input('search') }}</strong>".
                @else
                    Tidak ada riwayat peminjaman yang tersedia.
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
                            <th>Tanggal Dikembalikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($history as $key => $loan)
                            <tr class="text-center">
                                <td>{{ ($history->currentPage() - 1) * $history->perPage() + ($key + 1) }}</td>
                                <td class="text-start">{{ $loan->book->title }}</td>
                                <td>{{ $loan->borrowed_at ? $loan->borrowed_at->format('d-m-Y') : 'Belum dipinjam' }}</td>
                                <td>{{ $loan->returned_at ? $loan->returned_at->format('d-m-Y') : 'Belum dikembalikan' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $history->links() }}
            </div>
        @endif
    </div>
@endsection
