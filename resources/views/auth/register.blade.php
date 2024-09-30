@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-success text-white">
                        <h3>Registrasi Akun Baru</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="@error('name') is-invalid @enderror form-control"
                                    id="name" name="name" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="@error('password') is-invalid @enderror form-control"
                                    id="password" name="password" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="password-confirm">Konfirmasi Password</label>
                                <input type="password" class="@error('password') is-invalid @enderror form-control"
                                    id="password-confirm" name="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Registrasi</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}">Sudah punya akun? Login disini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
