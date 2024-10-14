@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg rounded-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-0">
                <h3 class="mb-0">Daftar Peminjaman Aktif</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form action="{{ route('admin.loans.index') }}" method="GET" class="w-100">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-0"
                                placeholder="Cari pengguna atau buku..." value="{{ request('search') }}">
                            <button class="btn btn-primary rounded-0" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
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
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-primary">
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
                                            <button class="btn btn-danger btn-sm rounded-0">
                                                <i class="fas fa-check-circle"></i> Belum Dikembalikan
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $loans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
