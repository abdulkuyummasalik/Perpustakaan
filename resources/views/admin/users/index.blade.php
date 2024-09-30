@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Pengguna</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Tambah Pengguna
            </a>
        </div>
        @if ($users->isEmpty())
            <div class="alert alert-warning">Tidak ada pengguna yang tersedia.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="thead-light table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.user.edit', $user->id) }}"
                                            class="btn btn-warning btn-sm me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
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
            <div class="d-flex justify-content-center">
                {{-- {{ $users->links() }} --}}
            </div>
        @endif
    </div>
@endsection
