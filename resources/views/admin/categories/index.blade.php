@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Kategori</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
        </div>
        @if ($categories->isEmpty())
            <div class="alert alert-warning">Tidak ada kategori yang tersedia.</div>
        @else
        <table class="table table-striped table-hover align-middle">
            <thead class="thead-light table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $index => $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-warning btn-sm me-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display:inline;">
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
                {{-- {{ $categories->links() }} --}}
            </div>
        @endif
    </div>
@endsection
