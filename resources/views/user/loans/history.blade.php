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
        @if ($history->isEmpty())
            <div class="alert alert-warning text-center">Tidak ada riwayat peminjaman.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Dipinjam</th>
                            <th>Tanggal Dikembalikan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($history as $key => $loan)
                            <tr class="text-center">
                                <td>{{ $key + 1 }}</td>
                                <td class="text-start">{{ $loan->book->title }}</td>
                                <td>{{ $loan->borrowed_at ? $loan->borrowed_at->format('d-m-Y') : 'Belum dipinjam' }}</td>
                                <td>{{ $loan->returned_at ? $loan->returned_at->format('d-m-Y') : 'Belum dikembalikan' }}</td>
                                <td>
                                    <form action="{{ route('user.loans.history.delete', $loan->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{-- {{ $history->links() }} --}}
            </div>
        @endif
    </div>
@endsection
