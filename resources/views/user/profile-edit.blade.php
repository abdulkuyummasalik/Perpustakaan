@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Ubah Profil</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <!-- Nama -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    name="name" value="{{ old('name', Auth::user()->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ old('email', Auth::user()->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Lama -->
            <div class="mb-3">
                <label for="current_password" class="form-label">Password Lama</label>
                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                    id="current_password" name="current_password">
                @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Baru -->
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                    id="new_password" name="new_password">
                @error('new_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Konfirmasi Password Baru -->
            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="new_password_confirmation"
                    name="new_password_confirmation">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('user.profile.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-warning text-white">
                    <i class="fas fa-save"></i> Perbarui Profil
                </button>
            </div>
        </form>
    </div>
@endsection
