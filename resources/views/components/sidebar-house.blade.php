<div id="sidebar">
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
    @endphp
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
                    $project_id = request('project_id');
                @endphp

                @if ($project_id)
                    <li
                        class="sidebar-item {{ request()->routeIs('houses.index', ['project_id' => $project_id]) ? 'active' : '' }}">
                        <a href="{{ route('houses.index', ['project_id' => $project_id]) }}" class="sidebar-link">
                            <i class="bi bi-receipt"></i>
                            <span>Daftar Rumah</span>
                        </a>
                    </li>
                    @role('keuangan')
                        <li
                            class="sidebar-item {{ request()->routeIs('role-access.index', ['project_id' => $project_id]) ? 'active' : '' }}">
                            <a href="{{ route('role-access.index', ['project_id' => $project_id]) }}" class="sidebar-link">
                                <i class="bi bi-universal-access-circle"></i>
                                <span>Kelola Akses</span>
                            </a>
                        </li>
                    @endrole
                @endif
                <li class="sidebar-title">Sistem</li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>
                @role('keuangan')
                    <li class="sidebar-item text-end items-end" style="position: absolute; bottom: 20px; width: 78%;">
                        <hr>
                        <a href="#" class="sidebar-link d-flex align-items-center">
                            <img src="{{ asset('assets/image/pic-cewe.png') }}" alt="Account Icon"
                                style="width: 35px; height: 35px; margin-right: 10px;">
                            <span>{{ $user->name }}</span>
                        </a>
                    </li>
                @endrole
                @role('site-admin')
                    <li class="sidebar-item text-end items-end" style="position: absolute; bottom: 20px; width: 78%;">
                        <hr>
                        <a href="#" class="sidebar-link d-flex align-items-center dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('assets/image/site-admin.png') }}" alt="Account Icon"
                                style="width: 35px; height: 35px; margin-right: 10px;">
                            <span>{{ $user->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Edit Akun</a></li>
                            <li><a class="dropdown-item" href="#">Lihat Profil</a></li>
                        </ul>
                    </li>
                @endrole
            </ul>
        </div>
    </div>
</div>
