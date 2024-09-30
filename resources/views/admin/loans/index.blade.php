@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Daftar Peminjaman Aktif</h1>
        @if ($loans->isEmpty())
            <div class="alert alert-warning">Tidak ada peminjaman aktif.</div>
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
                            <td>{{ $key + 1 }}</td>
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
    </div>
@endsection
