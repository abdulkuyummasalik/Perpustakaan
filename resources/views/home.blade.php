@extends('layouts.app')

@section('content')
    @guest
        <div class="container mt-5 text-center">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h1 class="display-3 fw-bold text-primary">Selamat Datang di Perpustakaan KM-28</h1>
                    <p class="lead text-secondary mt-3">
                        Nikmati koleksi buku terbaik kami dan akses fitur eksklusif perpustakaan.
                        Silakan login atau daftar terlebih dahulu untuk memulai petualangan literasi Anda.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-lg btn-primary px-5 mt-4 shadow-sm rounded-pill">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Login
                    </a>
                </div>
            </div>
            <div class="mt-5">
                {{-- <img src="path_to_welcome_image.jpg" alt="Welcome" class="img-fluid rounded-3 shadow-lg"> --}}
            </div>
        </div>
    @endguest
    @auth
        @if (Auth::user()->role == 'admin')
            <div class="container mt-5 text-center">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <h1 class="display-4 text-primary fw-bold">Selamat Datang, {{ Auth::user()->name }}</h1>
                        <p class="lead text-secondary">Kelola koleksi buku dan nikmati fitur eksklusif perpustakaan kami.</p>
                        <a href="{{ route('admin.book.index') }}"
                            class="btn btn-lg btn-primary px-5 mt-3 shadow-sm rounded-pill">
                            <i class="bi bi-book me-2"></i> Lihat Koleksi Buku
                        </a>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title text-primary fw-bold">Buku Terbaru</h5>
                                <p class="card-text text-muted">Telusuri buku-buku terbaru yang ditambahkan di perpustakaan
                                    kami.</p>
                                <a href="{{ route('admin.book.index') }}" class="btn btn-outline-primary rounded-pill">
                                    <i class="bi bi-book-half me-2"></i> Lihat Buku
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title text-primary fw-bold">Kategori Buku</h5>
                                <p class="card-text text-muted">Temukan buku berdasarkan kategori seperti fiksi, edukasi, dan
                                    lainnya.</p>
                                <a href="{{ route('admin.category.index') }}" class="btn btn-outline-primary rounded-pill">
                                    <i class="bi bi-tags me-2"></i> Eksplorasi Kategori
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container mt-5 text-center">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <h1 class="display-4 text-primary fw-bold">Selamat Datang, {{ Auth::user()->name }}</h1>
                        <p class="lead text-secondary">Eksplorasi koleksi buku kami dan manfaatkan fitur perpustakaan yang kami
                            sediakan.</p>
                        <a href="{{ route('user.book.index') }}"
                            class="btn btn-lg btn-primary px-5 mt-3 shadow-sm rounded-pill">
                            <i class="bi bi-book me-2"></i> Lihat Koleksi Buku
                        </a>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title text-primary fw-bold">Buku Rekomendasi</h5>
                                <p class="card-text text-muted">Temukan buku-buku yang direkomendasikan pembaca lain.</p>
                                <a href="{{ route('user.book.index') }}" class="btn btn-outline-primary rounded-pill">
                                    <i class="bi bi-star-fill me-2"></i> Lihat Rekomendasi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth
@endsection
