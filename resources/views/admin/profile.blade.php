@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg rounded-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-0">
                <h3 class="mb-0">Profile Admin</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5><strong>Nama:</strong> {{ $user->name }}</h5>
                        <h5><strong>Email:</strong> {{ $user->email }}</h5>
                        <h5><strong>Nomor Telepon:</strong> {{ $user->phone ?? 'Tidak tersedia' }}</h5>
                        <h5><strong>Tanggal Bergabung:</strong> {{ $user->created_at->format('d-m-Y') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 rounded-0">
            <div class="col-md-4">
                <div class="card shadow-sm text-center bg-primary text-white rounded-0">
                    <div class="card-body">
                        <h5>Total Pengguna</h5>
                        <p class="fs-4">{{ $totalUsers }}</p>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-light rounded-0">Lihat Pengguna</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center bg-success text-white rounded-0">
                    <div class="card-body">
                        <h5>Total Peminjaman</h5>
                        <p class="fs-4">{{ $totalLoans }}</p>
                        <a href="{{ route('admin.loans.index') }}" class="btn btn-light rounded-0">Lihat Peminjaman</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center bg-warning text-white rounded-0">
                    <div class="card-body">
                        <h5>Total Buku</h5>
                        <p class="fs-4">{{ $totalBooks }}</p>
                        <a href="{{ route('admin.book.index') }}" class="btn btn-light rounded-0">Lihat Buku</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4 shadow-sm  rounded-0">
            <div class="card-header bg-secondary text-white rounded-0">
                <h5 class="mb-0">Riwayat Peminjaman</h5>
            </div>
            <div class="card-body">
                @if ($loans->isEmpty())
                    <div class="alert alert-warning text-center">Tidak ada riwayat peminjaman.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nama Pengguna</th>
                                    <th>Nama Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                    <tr>
                                        <td class="text-start">{{ $loan->user->name }}</td>
                                        <td class="text-start">{{ $loan->book->title }}</td>
                                        <td>{{ $loan->borrowed_at->format('d-m-Y') }}</td>
                                        <td>
                                            @if ($loan->returned_at)
                                                {{ $loan->returned_at->format('d-m-Y') }}
                                            @else
                                                <span class="text-danger">Belum Kembali</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($loan->returned_at)
                                                <button class="btn btn-success btn-sm rounded-0">
                                                    <i class="fas fa-check-circle"></i> Dikembalikan
                                                </button>
                                            @else
                                                <button class="btn btn-danger btn-sm rounded-0">
                                                    <i class="fas fa-times-circle"></i> Belum Dikembalikan
                                                </button>
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
