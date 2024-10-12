@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Daftar Peminjaman Aktif</h1>

        <form action="{{ route('admin.loans.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari pengguna atau buku..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary ms-2">Cari</button>
            </div>
        </form>

        @if ($loans->isEmpty())
            <div class="alert alert-warning">
                @if (request()->input('search'))
                    Tidak ada peminjaman yang ditemukan untuk kata kunci "<strong>{{ request()->input('search') }}</strong>".
                @else
                    Tidak ada peminjaman yang tersedia.
                @endif
            </div>
        @else
            <table class="table table-striped table-hover align-middle">
                <thead class="thead-light table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Dipinjam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $key => $loan)
                        <tr>
                            <td>{{ ($loans->currentPage() - 1) * $loans->perPage() + ($key + 1) }}</td>
                            <td>{{ $loan->user->name }}</td>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ $loan->borrowed_at->format('d-m-Y') }}</td>
                            <td>
                                <span class="text-danger">Belum Dikembalikan</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <div class="d-flex justify-content-center mt-4">
            {{ $loans->links() }}
        </div>
    </div>
@endsection
