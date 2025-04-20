<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-center align-items-center">
                <div class="logo">
                    <a href="/"><img src="{{ asset('assets/image/logo-ajisaka.png') }}" alt="Logo"
                            style="max-width: 100px; height: auto;" /></a>
                </div>

                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                @php
                    $house_id = request('house_id') ?? ($house_id ?? null);
                @endphp

                @if ($house_id)
                    <li class="sidebar-item {{ request()->routeIs('expenses.index') ? 'active' : '' }}">
                        <a href="{{ route('expenses.index', ['house_id' => $house_id]) }}" class="sidebar-link">
                            <i class="bi bi-receipt"></i>
                            <span>Laporan Pengeluaran</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('progress.index') ? 'active' : '' }}">
                        <a href="{{ route('progress.index', ['house_id' => $house_id]) }}" class="sidebar-link">
                            <i class="bi bi-percent"></i>
                            <span>Laporan Progres</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-title">Sistem</li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
