<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/">
            <img src="img/logo/logo-perpus-km-22.png" alt="Logo KM-28" width="50" height="50">
            Perpustakaan KM-28</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                        <i class="bi bi-house-door me-1"></i> Beranda
                    </a>
                </li>
                @if (Auth::check())
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-menu-button-wide me-1"></i> Menu Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.book.index') }}"><i class="bi bi-book me-1"></i> Kelola Buku</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.user.index') }}"><i class="bi bi-people me-1"></i> Kelola Pengguna</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.category.index') }}"><i class="bi bi-tags me-1"></i> Kelola Kategori</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.loans.index') }}"><i class="bi bi-clock-history me-1"></i> Peminjaman Aktif</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.loans.history') }}"><i class="bi bi-archive me-1"></i> Riwayat Peminjaman</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-menu-button-wide me-1"></i> Menu Pengguna
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('user.book.index') }}"><i class="bi bi-book-half me-1"></i> Daftar Buku</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.loans.index') }}"><i class="bi bi-clock-history me-1"></i> Peminjaman Aktif</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.loans.history') }}"><i class="bi bi-archive me-1"></i> Riwayat Peminjaman</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-1"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">
                            <i class="bi bi-pencil-square me-1"></i> Daftar
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
