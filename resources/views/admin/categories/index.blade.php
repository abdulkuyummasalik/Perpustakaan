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

            <form action="{{ route('admin.category.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" placeholder="Cari kategori..." value="{{ request()->input('search') }}"
                        class="form-control">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary ms-2">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if ($categories->isEmpty())
            <div class="alert alert-warning">
                @if (request()->input('search'))
                    Tidak ada category yang ditemukan untuk kata kunci "<strong>{{ request()->input('search') }}</strong>".
                @else
                    Tidak ada category yang tersedia.
                @endif
            </div>
        @else
            <table class="table table-striped table-hover align-middle">
                <thead class="thead-light table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Buku</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $index => $category)
                        <tr>
                            <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + ($index + 1) }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->books_count }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.category.edit', $category->id) }}"
                                        class="btn btn-warning btn-sm me-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST"
                                        style="display:inline;">
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
                {{ $categories->links() }}
            </div>
        @endif
    </div>
@endsection
