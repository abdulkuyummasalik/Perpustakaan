@extends('layouts.app')

@section('content')
    @if (session('canAccess'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Peringatan: </strong> {{ session('canAccess') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Belum Login -->
    @guest
        <section class="hero d-flex align-items-center">
            <div class="container text-center py-5">
                <h1 class="display-3 fw-bold text-primary">Selamat Datang di Perpustakaan KM-28</h1>
                <p class="lead text-secondary mt-4">
                    Eksplorasi dunia literasi dengan koleksi buku terbaik kami. Mulai perjalanan membaca Anda sekarang juga!
                </p>
                <a href="{{ route('login') }}" class="btn btn-lg btn-primary px-5 mt-4 shadow-sm rounded-pill">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login Sekarang
                </a>
            </div>
        </section>
    @endguest

    <!-- Sudah Login -->
    @auth
        @if (Auth::user()->role == 'admin')
            <section class="admin-dashboard py-5">
                <div class="container text-center">
                    <h1 class="display-4 text-primary fw-bold">Selamat Datang, {{ Auth::user()->name }}</h1>
                    <p class="lead text-secondary">Kelola buku dan fitur lainnya dengan kemudahan di ujung jari Anda.</p>
                    <a href="{{ route('admin.book.index') }}" class="btn btn-lg btn-primary px-5 mt-3 shadow-sm rounded-pill">
                        <i class="bi bi-book me-2"></i> Lihat Koleksi Buku
                    </a>
                </div>
                <div class="container mt-5">
                    <div class="row text-center">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 text-dark shadow-lg">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <i class="bi bi-book-half display-4 text-primary mb-3"></i>
                                    <h5 class="card-title fw-bold">Buku Terbaru</h5>
                                    <p class="card-text">Telusuri koleksi buku terbaru di perpustakaan kami.</p>
                                    <a href="{{ route('admin.book.index') }}"
                                        class="btn btn-outline-primary rounded-pill mt-auto">
                                        Lihat Buku
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 text-dark shadow-lg">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <i class="bi bi-tags display-4 text-primary mb-3"></i>
                                    <h5 class="card-title fw-bold">Kategori Buku</h5>
                                    <p class="card-text">Telusuri buku berdasarkan kategori tertentu.</p>
                                    <a href="{{ route('admin.category.index') }}"
                                        class="btn btn-outline-primary rounded-pill mt-auto">
                                        Eksplorasi Kategori
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 text-dark shadow-lg">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <i class="bi bi-bar-chart-line display-4 text-primary mb-3"></i>
                                    <h5 class="card-title fw-bold">Statistik Peminjaman</h5>
                                    <p class="card-text">Pantau statistik peminjaman buku dengan mudah.</p>
                                    <a href="{{ route('admin.loans.history') }}"
                                        class="btn btn-outline-primary rounded-pill mt-auto">
                                        Lihat Statistik
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <section class="user-dashboard py-5">
                <div class="container text-center">
                    <h1 class="display-4 text-primary fw-bold">Selamat Datang, {{ Auth::user()->name }}</h1>
                    <p class="lead text-secondary">Eksplorasi koleksi buku kami dan mulai pinjam buku favorit Anda.</p>
                    <a href="{{ route('user.book.index') }}" class="btn btn-lg btn-primary px-5 mt-3 shadow-sm rounded-pill">
                        <i class="bi bi-book me-2"></i> Lihat Koleksi Buku
                    </a>
                </div>
                <div class="container mt-5">
                    <div class="row text-center">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 text-dark shadow-sm">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <i class="bi bi-person-lines-fill display-4 text-primary mb-3"></i>
                                    <h5 class="card-title fw-bold">Profil Saya</h5>
                                    <p class="card-text">Kelola informasi akun dan lihat riwayat peminjaman Anda.</p>
                                    <a href="{{ route('user.profile.index') }}" class="btn btn-outline-primary rounded-pill mt-auto">
                                        Lihat Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 text-dark shadow-sm">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <i class="bi bi-clock-history display-4 text-primary mb-3"></i>
                                    <h5 class="card-title fw-bold">Riwayat Peminjaman</h5>
                                    <p class="card-text">Lihat riwayat buku yang pernah Anda pinjam.</p>
                                    <a href="{{ route('user.loans.index') }}"
                                        class="btn btn-outline-primary rounded-pill mt-auto">
                                        Lihat Riwayat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endauth
@endsection
