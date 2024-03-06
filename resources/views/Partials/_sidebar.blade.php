<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('/storage') }}/profile/{{ $user->image }}" alt="profile">
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2 text-truncate">{{ $user->name }}</span>
                    <span class="text-secondary text-small">{{ $user->role }}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('Dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('Piket') }}">
                <span class="menu-title">Piket</span>
                <i class="mdi mdi-calendar-multiple menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('Talangan') }}">
                <span class="menu-title">Talangan</span>
                <i class="mdi mdi-cash-100 menu-icon"></i>
            </a>
        </li>

        @if ($user->role == 'Developer')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Developer') }}">
                    <span class="menu-title">Developer</span>
                    <i class="mdi mdi-clipboard-account menu-icon"></i>
                </a>
            </li>
        @endif

        @if ($user->role == 'Bendahara' || $user->role == 'Developer')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Bendahara') }}">
                    <span class="menu-title">Pengeluaran</span>
                    <i class="mdi mdi-cart menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Bendahara.Lain') }}">
                    <span class="menu-title">Pemasukan Lain</span>
                    <i class="mdi mdi-plus-circle menu-icon"></i>
                </a>
            </li>
        @endif

        @if (!$kasLunas || (!$donePiket && $isPiket))
            <li class="nav-item sidebar-actions">
                <span class="nav-link">
                    <div class="border-bottom">
                        <h6 class="font-weight-normal mb-3">Tombol Instan</h6>
                    </div>
                    @if (!$kasLunas)
                        <a href="{{ route('BayarKas') }}" class="btn btn-block btn-lg btn-gradient-primary mt-4">+
                            Bayar Kas</a>
                    @endif
                    <br>
                    @if (!$donePiket && $isPiket)
                        <a href="{{ route('Piket') }}" class="btn btn-block btn-lg btn-gradient-primary mt-4">+ Laporan
                            Piket</a>
                    @endif

                </span>
            </li>
        @endif
    </ul>
</nav>
