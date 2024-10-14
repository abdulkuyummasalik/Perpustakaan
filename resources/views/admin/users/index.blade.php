@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Daftar Akun</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('deleted'))
                    <div class="alert alert-danger">{{ session('deleted') }}</div>
                @endif
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary me-2">
                        <i class="fas fa-plus-circle"></i> Tambah Akun
                    </a>
                    <form action="{{ route('admin.user.index') }}" method="GET" class="flex-grow-1">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari akun ..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
                @if ($users->isEmpty())
                    <div class="alert alert-warning">
                        @if (request()->input('search'))
                            Tidak ada akun yang ditemukan untuk kata kunci
                            "<strong>{{ request()->input('search') }}</strong>".
                        @else
                            Tidak ada akun yang tersedia.
                        @endif
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Akun</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Total Peminjaman</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + ($index + 1) }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>
                                            @if ($user->role === 'admin')
                                                Admin tidak dapat meminjam buku
                                            @else
                                                @if ($user->loans_count > 0)
                                                    {{ $user->loans_count }} kali
                                                @else
                                                    <span class="text-muted">Belum ada peminjaman</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Aksi User">
                                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                                    class="btn btn-warning btn-sm rounded-0 me-2" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-0"
                                                        title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
