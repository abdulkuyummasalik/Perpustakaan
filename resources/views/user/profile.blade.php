@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Profil Pengguna</h3>
                {{-- tombol ganti password --}}
                <a href="{{ route('user.profile.edit') }}" class="btn btn-sm btn-warning">Ganti Password</a>
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
        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Riwayat Peminjaman</h5>
            </div>
            <div class="card-body">
                @if ($loans->isEmpty())
                    <div class="alert alert-warning text-center">Tidak ada riwayat peminjaman.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-success">
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
                                        <td class="text-start">{{ $loan->book->title }}</td>
                                        <td>
                                            @if ($loan->returned_at)
                                                <button class="btn btn-success btn-sm rounded-lg">
                                                    <i class="fas fa-check-circle"></i> Dikembalikan
                                                </button>
                                            @else
                                                <button class="btn btn-danger btn-sm rounded-lg">
                                                    <i class="fas fa-times-circle"></i> Belum Dikembalikan
                                                </button>
                                            @endif
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
