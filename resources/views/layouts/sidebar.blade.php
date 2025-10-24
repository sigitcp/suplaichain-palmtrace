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
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('petani.dashboard.index') ? 'active' : '' }}"
                        href="{{ route('petani.dashboard.index') }}">
                        <i class="icon"><i class="bi bi-house"></i></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>

                {{-- ================= Transaksi ================= --}}
                @php
                $transaksiActive = request()->routeIs('petani.penawaran.*') ||
                request()->routeIs('petani.penerimaantbs.*') ||
                request()->routeIs('petani.riwayattransaksi.*');
                @endphp
                <li class="nav-item">
                    <a class="nav-link text-white {{ $transaksiActive ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                        href="#sidebar-transaksi" role="button" aria-expanded="{{ $transaksiActive ? 'true' : 'false' }}"
                        aria-controls="sidebar-transaksi">
                        <i class="icon"><i class="bi bi-arrow-left-right"></i></i>
                        <span class="item-name">Transaksi</span>
                    </a>
                    <ul class="sub-nav collapse {{ $transaksiActive ? 'show' : '' }}" id="sidebar-transaksi"
                        data-bs-parent="#sidebar-menu">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('petani.penawaran.*') ? 'active' : '' }}"
                                href="{{ route('petani.penawaran.index') }}">
                                <i class="bi bi-bag-plus"></i>
                                <span class="item-name">Penawaran TBS</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('petani.penerimaantbs.*') ? 'active' : '' }}"
                                href="{{ route('petani.penerimaantbs.index') }}">
                                <i class="bi bi-bag-check"></i>
                                <span class="item-name">Penerimaan TBS</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('petani.riwayattransaksi.*') ? 'active' : '' }}"
                                href="{{ route('petani.riwayattransaksi.index') }}">
                                <i class="bi bi-clock-history"></i>
                                <span class="item-name">Riwayat Transaksi</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ================= Monitoring Hasil Panen ================= --}}
                @php
                $monitoringActive = request()->routeIs('petani.monitoring.*');
                $lahans = auth()->check()
                ? \App\Models\Lahan::where('user_id', auth()->id())->get()
                : collect();
                @endphp
                <li class="nav-item">
                    <a class="nav-link text-white {{ $monitoringActive ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                        href="#sidebar-kebun" role="button" aria-expanded="{{ $monitoringActive ? 'true' : 'false' }}"
                        aria-controls="sidebar-kebun">
                        <i class="icon"><i class="bi bi-arrow-repeat"></i></i>
                        <span class="item-name">Monitoring Hasil Panen</span>
                    </a>
                    <ul class="sub-nav collapse {{ $monitoringActive ? 'show' : '' }}" id="sidebar-kebun"
                        data-bs-parent="#sidebar-menu">
                        @forelse ($lahans as $lahan)
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->is("petani/monitoring/$lahan->id") ? 'active' : '' }}"
                                href="{{ route('petani.monitoring.index', $lahan->id) }}">
                                <i class="bi bi-tree"></i>
                                <span class="item-name">{{ $lahan->nama_lahan }}</span>
                            </a>
                        </li>
                        @empty
                        <li class="nav-item">
                            <span class="nav-link text-muted">
                                <i class="bi bi-exclamation-circle"></i>
                                <span class="item-name">Belum ada lahan</span>
                            </span>
                        </li>
                        @endforelse
                    </ul>
                </li>

                {{-- ================= Peta PKS & Pengepul ================= --}}
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('petani.peta.*') ? 'active' : '' }}"
                        href="{{ route('petani.peta.index') }}">
                        <i class="icon"><i class="bi bi-geo-alt"></i></i>
                        <span class="item-name">Peta PKS & Pengepul</span>
                    </a>
                </li>

                {{-- ================= Profil ================= --}}
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('profil*') ? 'active' : '' }}"
                        href="{{ route('profil.index') }}">
                        <i class="icon"><i class="bi bi-person"></i></i>
                        <span class="item-name">Profil</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('artikelpetani*') ? 'active' : '' }}"
                        href="{{ route('artikel.index.petani') }}">
                        <i class="icon"><i class="bi bi-book"></i></i>
                        <span class="item-name">Artikel</span>
                    </a>
                </li>


                @endif


                {{-- =====================================
SIDEBAR UNTUK ADMIN (role_id = 1)
===================================== --}}
                @if (Auth::user()->role_id == 1)
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard.index') }}">
                        <i class="icon"><i class="bi bi-house-door"></i></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('users*') ? 'active' : '' }}"
                        href="{{ route('users.index') }}">
                        <i class="icon"><i class="bi bi-people"></i></i>
                        <span class="item-name">Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('lahan.index') ? 'active' : '' }}"
                        href="{{ route('lahan.index') }}">
                        <i class="icon"><i class="bi bi-tree"></i></i>
                        <span class="item-name">Kelola Lahan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('daftar-profil-petani') ? 'active' : '' }}"
                        href="{{ route('daftar-profil-petani') }}">
                        <i class="icon"><i class="bi bi-person-badge"></i></i>
                        <span class="item-name">Profil Petani</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('daftar-pengepul') ? 'active' : '' }}"
                        href="{{ route('daftar-pengepul') }}">
                        <i class="icon"><i class="bi bi-truck"></i></i>
                        <span class="item-name">Profil Pengepul</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('daftar-pks') ? 'active' : '' }}"
                        href="{{ route('daftar-pks') }}">
                        <i class="icon"><i class="bi bi-gear"></i></i>
                        <span class="item-name">Profil PKS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('refinery.index') ? 'active' : '' }}"
                        href="{{ route('refinery.index') }}">
                        <i class="icon"><i class="bi bi-droplet-half"></i></i>
                        <span class="item-name">Profil Refinery</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('harga-tbs.index') ? 'active' : '' }}"
                        href="{{ route('harga-tbs.index') }}">
                        <i class="icon"><i class="bi bi-cash-coin"></i></i>
                        <span class="item-name">Harga TBS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('harga-cpo.index') ? 'active' : '' }}"
                        href="{{ route('harga-cpo.index') }}">
                        <i class="icon"><i class="bi bi-moisture"></i></i>
                        <span class="item-name">Harga CPO</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('artikel.index') ? 'active' : '' }}"
                        href="{{ route('artikel.index') }}">
                        <i class="icon"><i class="bi bi-newspaper"></i></i>
                        <span class="item-name">Artikel</span>
                    </a>
                </li>
                @endif


                {{-- =====================================
     SIDEBAR UNTUK PENGEPUL (role_id = 3)
===================================== --}}
                @if (Auth::user()->role_id == 3)
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('dashboard.pengepul') ? 'active' : '' }}"
                        href="{{ route('pengepul.dashboard.index') }}">
                        <i class="bi bi-house-door-fill me-2"></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('pengepul.penawaran.index') ? 'active' : '' }}"
                        href="{{ route('pengepul.penawaran.index') }}">
                        <i class="bi bi-card-checklist me-2"></i>
                        <span class="item-name">Penawaran TBS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('pengepul.penimbangan.*') ? 'active' : '' }}"
                        href="{{ route('pengepul.penimbangan.index') }}">
                        <i class="bi bi-speedometer2 me-2"></i>
                        <span class="item-name">Penimbangan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('pengepul.penerimaantbs.*') ? 'active' : '' }}"
                        href="{{ route('pengepul.penerimaantbs.index') }}">
                        <i class="bi bi-box-seam me-2"></i>
                        <span class="item-name">Penerimaan TBS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('pengepul.penawaranpks.*') ? 'active' : '' }}"
                        href="{{ route('pengepul.penawaranpks.index') }}">
                        <i class="bi bi-building me-2"></i>
                        <span class="item-name">Penawaran PKS</span>
                    </a>
                </li>
                <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('pengepul.riwayattransaksi.*') ? 'active' : '' }}"
            href="{{ route('pengepul.riwayattransaksi.index') }}">
            <i class="bi bi-graph-up-arrow me-2"></i>
            <span class="item-name">Riwayat Transaksi</span>
        </a>
    </li>
                @endif

                {{-- =====================================
     SIDEBAR UNTUK PKS (role_id = 4)
===================================== --}}
@if (Auth::user()->role_id == 4)
    <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('pks.dashboard.*') ? 'active' : '' }}"
            href="{{ route('pks.dashboard.index') }}">
            <i class="bi bi-house"></i>
            <span class="item-name">Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('pks.penerimaantbs.*') ? 'active' : '' }}"
            href="{{ route('pks.penerimaantbs.index') }}">
            <i class="bi bi-box-arrow-in-down"></i>
            <span class="item-name">Penerimaan TBS</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('pks.penimbangantbs.*') ? 'active' : '' }}"
            href="{{ route('pks.penimbangantbs.index') }}">
            <i class="bi bi-basket"></i>
            <span class="item-name">Penimbangan TBS</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('pks.riwayattransaksi.*') ? 'active' : '' }}"
            href="{{ route('pks.riwayattransaksi.index') }}">
            <i class="bi bi-clock-history"></i>
            <span class="item-name">Riwayat Transaksi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('pks.cpooffer.*') ? 'active' : '' }}"
            href="{{ route('pks.cpooffer.index') }}">
            <i class="bi bi-droplet"></i>
            <span class="item-name">Penawaran CPO</span>
        </a>
    </li>
@endif


{{-- =====================================
     SIDEBAR UNTUK ROLE: REFINERY (role_id = 5)
===================================== --}}
@if (Auth::user()->role_id == 5)


    {{-- Peta Persebaran PKS --}}
    <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('refinery.peta.*') ? 'active' : '' }}"
            href="{{ route('refinery.peta.index') }}">
            <i class="bi bi-geo-alt"></i>
            <span class="item-name">Peta Persebaran PKS</span>
        </a>
    </li>

    {{-- Penawaran CPO --}}
    <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('penawaran.index') ? 'active' : '' }}"
            href="{{ route('penawaran.index') }}">
            <i class="bi bi-droplet-half"></i>
            <span class="item-name">Penawaran CPO</span>
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