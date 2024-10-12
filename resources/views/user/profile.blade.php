@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Profil Pengguna</h1>
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5>Biodata Pribadi</h5>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Nomor Telepon:</strong> {{ $user->phone ?? 'Tidak tersedia' }}</p>
                <p><strong>Tanggal Bergabung:</strong> {{ $user->created_at->format('d-m-Y') }}</p>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5>Riwayat Peminjaman</h5>
            </div>
            <div class="card-body">
                @if ($loans->isEmpty())
                    <div class="alert alert-warning">Tidak ada riwayat peminjaman.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nama Buku</th>
                                    <th>Status</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                    <tr>
                                        <td>{{ $loan->book->title }}</td>
                                        <td>
                                            <strong>
                                                @if ($loan->returned_at)
                                                    Dikembalikan pada: {{ $loan->returned_at->format('d-m-Y') }}
                                                @else
                                                    <span class="text-danger">Belum dikembalikan</span>
                                                @endif
                                            </strong>
                                        </td>
                                        <td>{{ $loan->borrowed_at->format('d-m-Y') }}</td>
                                        <td>
                                            @if ($loan->returned_at)
                                                {{ $loan->returned_at->format('d-m-Y') }}
                                            @else
                                                <span class="text-danger">Belum Kembali</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
