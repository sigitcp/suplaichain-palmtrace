<aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all" style="background-color: #2F4924;">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="/" class="navbar-brand">
            <div class="logo-main">
                <div class="logo-normal">
                    <!-- logo disini -->
                </div>
            </div>
            <h4 class="logo-title text-white">Palm Trace</h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>

    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <ul class="navbar-nav iq-main-menu mt-5" id="sidebar-menu">

                {{-- =====================================
                     SIDEBAR UNTUK PETANI (role_id = 2)
                ===================================== --}}
                @if (Auth::user()->role_id == 2)
                <li class="nav-item">
                    <a class="nav-link active" href="/">
                        <i class="icon"><i class="bi bi-house"></i></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <i class="icon"><i class="bi bi-arrow-left-right"></i></i>
                        <span class="item-name">Transaksi</span>
                    </a>
                </li>

                @php
                $lahans = auth()->check()
                ? \App\Models\Lahan::where('user_id', auth()->id())->get()
                : collect();
                @endphp

                <li class="nav-item">
                    <a class="nav-link text-white" data-bs-toggle="collapse" href="#sidebar-kebun" role="button" aria-expanded="false" aria-controls="sidebar-kebun">
                        <i class="icon"><i class="bi bi-arrow-repeat"></i></i>
                        <span class="item-name">Monitoring hasil Panen</span>
                    </a>
                    <ul class="sub-nav collapse" id="sidebar-kebun" data-bs-parent="#sidebar-menu">
                        @forelse ($lahans as $lahan)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('petani.monitoring.index', $lahan->id) }}">
                                <i class="icon">
                                    <svg class="icon-10" width="10" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="12" r="8" />
                                    </svg>
                                </i>
                                <span class="item-name">{{ $lahan->nama_lahan }}</span>
                            </a>
                        </li>
                        @empty
                        <li class="nav-item">
                            <span class="nav-link text-muted">
                                <i class="icon">
                                    <svg class="icon-10" width="10" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="12" r="8" />
                                    </svg>
                                </i>
                                <span class="item-name">Belum ada lahan</span>
                            </span>
                        </li>
                        @endforelse
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <i class="icon"><i class="bi bi-person"></i></i>
                        <span class="item-name">Profil</span>
                    </a>
                </li>
                @endif


                {{-- =====================================
                     SIDEBAR UNTUK ADMIN (role_id = 1)
                ===================================== --}}
                @if (Auth::user()->role_id == 1)
                <li class="nav-item">
                    <a class="nav-link active" href="/">
                        <i class="icon"><i class="bi bi-house"></i></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <span class="item-name">Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <span class="item-name">Kelola Detail Kebun</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <span class="item-name">Profil Pengepul</span>
                    </a>
                </li>
                @endif

                {{-- =====================================
                     SIDEBAR UNTUK PENGEPUL (role_id = 3)
                ===================================== --}}
                @if (Auth::user()->role_id == 3)
                <li class="nav-item">
                    <a class="nav-link active" href="/">
                        <i class="icon"><i class="bi bi-house"></i></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <span class="item-name">Pemasok</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <span class="item-name">Penimbang</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <span class="item-name">Logistik</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <span class="item-name">Transaksi</span>
                    </a>
                </li>
                @endif

                <li>
                    <hr class="hr-horizontal" />
                </li>

            </ul>
        </div>
    </div>
</aside>