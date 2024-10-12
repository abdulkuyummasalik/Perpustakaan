@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar User</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah User
            </a>

            <form action="{{ route('admin.user.index') }}" method="GET" class="">
                <div class="input-group">
                    <input type="text" name="search" placeholder="Cari user ..." value="{{ request()->input('search') }}"
                        class="form-control">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary ms-2">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>

        

        @if ($users->isEmpty())
            <div class="alert alert-warning">
                @if (request()->input('search'))
                    Tidak ada user yang ditemukan untuk kata kunci "<strong>{{ request()->input('search') }}</strong>".
                @else
                    Tidak ada user yang tersedia.
                @endif
            </div>
        @else
        <table class="table table-striped table-hover align-middle">
            <thead class="thead-light table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Total Peminjaman</th>
                    <th class="text-center">Aksi</th>
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
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-sm me-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
        @endif
    </div>
@endsection
