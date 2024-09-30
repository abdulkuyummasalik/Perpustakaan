@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Riwayat Peminjaman (Admin)</h1>
        @if ($loans->isEmpty())
            <div class="alert alert-warning">Tidak ada riwayat peminjaman.</div>
        @else
        <table class="table table-striped table-hover align-middle">
            <thead class="thead-light table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Dipinjam</th>
                        <th>Tanggal Dikembalikan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $key => $loan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $loan->user->name }}</td>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ $loan->borrowed_at->format('d-m-Y') }}</td>
                            <td>{{ $loan->returned_at ? $loan->returned_at->format('d-m-Y') : 'Belum Dikembalikan' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{-- {{ $loans->links() }} --}}
            </div>
        @endif
    </div>
@endsection
