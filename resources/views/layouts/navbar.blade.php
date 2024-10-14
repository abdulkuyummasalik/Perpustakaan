<nav class="navbar navbar-expand-lg navbar-dark bg-primary py-2">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
            <img src="{{ asset('img/logo/logo-perpus-km-11.png') }}" alt="Logo KM-28" width="50" height="40">
            <span class="ms-2" style="font-size: 1.7rem;">Perpustakaan KM-28</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                        <i class="bi bi-house-door-fill me-1"></i> Beranda
                    </a>
                </li>
                @if (Auth::check())
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/book*') ? 'active' : '' }}"
                                href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-book-half me-1"></i> Kelola Buku
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.book.index') }}">Daftar Buku</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.category.index') }}">Kelola
                                        Kategori</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/loans*') ? 'active' : '' }}"
                                href="#" id="loanDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-journal-bookmark me-1"></i> Peminjaman
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="loanDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.loans.index') }}">Peminjaman
                                        Aktif</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.loans.history') }}">Riwayat
                                        Peminjaman</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('user/book*') ? 'active' : '' }}"
                                href="{{ route('user.book.index') }}">
                                <i class="bi bi-book me-1"></i> Daftar Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('user/loans*') ? 'active' : '' }}"
                                href="{{ route('user.loans.index') }}">
                                <i class="bi bi-clock-history me-1"></i> Peminjaman
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        @if (Auth::user()->role == 'admin')
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/profile') ? 'active' : '' }}"
                                href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                        @else
                            <a class="nav-link dropdown-toggle {{ request()->is('user/profile') ? 'active' : '' }}"
                                href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                        @endif
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            @if (Auth::user()->role == 'admin')
                                <li>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route('admin.profile') }}">
                                        <i class="bi bi-person-circle me-2"></i>
                                        Profile
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route('user.profile') }}">
                                        <i class="bi bi-person-circle me-2"></i>
                                        Profil
                                    </a>
                                </li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
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
                        <a class="nav-link {{ request()->is('register') ? 'active' : '' }}"
                            href="{{ route('register') }}">
                            <i class="bi bi-pencil-square me-1"></i> Daftar
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
