@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg rounded-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">Daftar Peminjaman Aktif & Riwayat Peminjaman</h3>
            </div>
            <div class="card-body">
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
                <div class="row mb-4">
                    <div class="col-md-12">
                        <form action="{{ route('user.loans.index') }}" method="GET" class="input-group">
                            <input type="text" name="search" class="form-control rounded-start"
                                placeholder="Cari buku atau pengarang..." value="{{ request('search') }}">
                            <button class="btn btn-primary rounded-end" type="submit">Cari</button>
                        </form>
                    </div>
                </div>

                {{-- Peminjaman Aktif --}}
                <div class="mb-4">
                    <h4 class="fw-bold text-center mb-3">Peminjaman Aktif</h4>
                    @if ($loans->isEmpty())
                        <div class="alert alert-warning text-center">
                            @if (request()->input('search'))
                                Tidak ada peminjaman aktif yang ditemukan untuk kata kunci
                                "<strong>{{ request()->input('search') }}</strong>".
                            @else
                                Tidak ada peminjaman aktif saat ini.
                            @endif
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover rounded-lg align-middle">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Dipinjam</th>
                                        <th>Batas Waktu</th>
                                        <th>Denda</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $key => $loan)
                                        <tr class="text-center">
                                            <td>{{ ($loans->currentPage() - 1) * $loans->perPage() + ($key + 1) }}</td>
                                            <td class="text-start">{{ $loan->book->title }}</td>
                                            <td>{{ $loan->borrowed_at->format('d-m-Y H:i') }}</td>
                                            <td>{{ $loan->due_date->format('d-m-Y H:i') }}</td>
                                            <td>Rp {{ number_format($loan->calculateFine()) }}</td>
                                            <td>
                                                <form action="{{ route('user.loans.return', $loan->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-lg">
                                                        <i class="fas fa-arrow-left"></i> Kembalikan
                                                    </button>
                                                </form>
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

                {{-- Riwayat Peminjaman --}}
                <div>
                    <h4 class="text-center fw-bold mb-3">Riwayat Peminjaman</h4>
                    @if ($history->isEmpty())
                        <div class="alert alert-warning text-center">
                            @if (request()->input('search'))
                                Tidak ada riwayat peminjaman yang ditemukan untuk kata kunci
                                "<strong>{{ request()->input('search') }}</strong>".
                            @else
                                Tidak ada riwayat peminjaman.
                            @endif
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover rounded-lg align-middle">
                                <thead class="table-secondary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Dipinjam</th>
                                        <th>Tanggal Dikembalikan</th>
                                        <th>Denda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($history as $key => $loan)
                                        <tr class="text-center">
                                            <td>{{ ($history->currentPage() - 1) * $history->perPage() + ($key + 1) }}</td>
                                            <td class="text-start">{{ $loan->book->title }}</td>
                                            <td>{{ $loan->borrowed_at->format('d-m-Y') }}</td>
                                            <td>{{ $loan->returned_at->format('d-m-Y') }}</td>
                                            <td>Rp {{ number_format($loan->final_fine) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $history->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
