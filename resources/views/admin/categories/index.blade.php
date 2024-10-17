@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg rounded-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Manajemen Kategori</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('admin.category.create') }}" class="btn btn-primary me-2 rounded-0">
                        <i class="fas fa-plus-circle"></i> Tambah Kategori
                    </a>
                    <form action="{{ route('admin.category.index') }}" method="GET" class="flex-grow-1">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-0" placeholder="Cari kategori..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary rounded-0" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('deleted'))
                    <div class="alert alert-danger">{{ session('deleted') }}</div>
                @endif

                @if ($categories->isEmpty())
                    <div class="alert alert-warning">
                        @if (request()->input('search'))
                            Tidak ada kategori yang ditemukan untuk kata kunci
                            "<strong>{{ request()->input('search') }}</strong>".
                        @else
                            Tidak ada kategori yang tersedia.
                        @endif
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Jumlah Buku</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $index => $category)
                                    <tr>
                                        <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + ($index + 1) }}
                                        </td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->books_count }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Aksi Kategori">
                                                <a href="{{ route('admin.category.edit', $category->slug) }}"
                                                    class="btn btn-warning btn-sm rounded-0 me-2" title="Edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.category.destroy', $category->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-0"
                                                        title="Hapus">
                                                        <i class="fas fa-trash"></i> Hapus
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
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
