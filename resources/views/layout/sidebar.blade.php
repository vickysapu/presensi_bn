<aside class="main-sidebar sidebar-dark-primary elevation-4" style="overflow-y: scroll; overflow-x : hidden;">
    <a href="#" class="brand-link">
        <span class="brand-text text-left font-weight-light text-center ml-1">
            @if (session('datawalikelas'))
            {{ implode(' ', array_slice(explode(' ', session('datawalikelas')->nama_walikelas), 0, 2)) }}
            @elseif (session('username') == "Kesiswaan")
            KESISWAAN
            @elseif (session('username') == "Guru Piket")
            Guru Piket
            @elseif (session('username') == "Kepala Sekolah")
            Kepala Sekolah
            @else
            <span>Tidak ada pengguna yang login</span>
            @endif
        </span>
    </a>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            @if (session('datawalikelas'))
            <li class="nav-header">PRESENSI</li>

            <li class="nav-item">
                <a href="{{ route('absensi.absenkelas', session('datawalikelas')->id) }}" class="nav-link {{ request()->routeIs('absensi.absenkelas') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Data Presensi
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('absenrekapan') }}" class="nav-link {{ request()->routeIs('absenrekapan') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>
                        Rekap Presensi
                    </p>
                </a>
            </li>
            @else
            <li class="nav-header">PRESENSI</li>

            <li class="nav-item">
                <a href="{{ route('absensi.index') }}" class="nav-link {{ request()->routeIs('absensi.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>
                       Data Presensi
                    </p>
                </a>
            </li>
            @if (session('username') == 'Guru Piket')

            @else
            <li class="nav-item">
                <a href="{{ route('absenrekapan') }}" class="nav-link {{ request()->routeIs('absenrekapan') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>
                        Rekap Presensi
                    </p>
                </a>
            </li>
            @endif
            @endif

            @if (session('username') == "Guru Piket")
            <li class="nav-header">SURAT IZIN</li>

            <li class="nav-item">
                <a href="{{ route('suratizin.index') }}" class="nav-link {{ request()->routeIs('suratizin.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>
                        Buat Surat
                    </p>
                </a>
            </li>
            @endif

            @if (session('username') == 'Guru Piket')

            @else
            <li class="nav-header">BIO DATA</li>

            <li class="nav-item">
                <a href="{{ route('datasiswa.index') }}" class="nav-link {{ request()->routeIs('datasiswa.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Siswa</p>
                </a>
            </li>
            @endif
            @if (session('datawalikelas'))

            @elseif (session('username') == 'Guru Piket')

            @else
            <li class="nav-item">
                <a href="{{ route('walikelas.index') }}" class="nav-link {{ request()->routeIs('walikelas.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Wali Kelas</p>
                </a>
            </li>
            @endif
            @if (session('datawalikelas'))

            @else
            <li class="nav-item">
                <a href="{{ route('datapiket.index') }}" class="nav-link {{ request()->routeIs('datapiket.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Piket</p>
                </a>
            </li>
            @endif
            @if (session('datawalikelas'))
            <li class="nav-header">PELANGGARAN</li>

            <li class="nav-item">
                <a href="{{ route('pelanggaransiswa.index') }}" class="nav-link {{ request()->routeIs('pelanggaransiswa.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pelanggaran Siswa</p>
                </a>
            </li>

            @elseif (session('username') == 'Guru Piket')
            <li class="nav-item">
                <a href="{{ route('pelanggaransiswa.index') }}" class="nav-link {{ request()->routeIs('pelanggaransiswa.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pelanggaran Siswa</p>
                </a>
            </li>
            @else
            <li class="nav-header">PELANGGARAN</li>

            <li class="nav-item">
                <a href="{{ route('pelanggaransiswa.index') }}" class="nav-link {{ request()->routeIs('pelanggaransiswa.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pelanggaran Siswa</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('datapelanggaran.index') }}" class="nav-link {{ request()->routeIs('datapelanggaran.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Jenis Pelanggaran</p>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a href="{{ route('pelanggaransiswa.rekap') }}" class="nav-link {{ request()->routeIs('pelanggaransiswa.rekap') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rekap Pelanggaran</p>
                </a>
            </li> --}}

            @if (session('username') == "Kesiswaan")
            <li class="nav-header">PROFILE</li>

            <li class="nav-item">
                <a href="{{ route('datapengguna.index') }}" class="nav-link {{ request()->routeIs('datapengguna.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Profile</p>
                </a>
            </li>
            @endif
            @if (session('username') == "Kepala Sekolah")
            <li class="nav-header">PROFILE</li>

            <li class="nav-item">
                <a href="{{ route('datapengguna.index') }}" class="nav-link {{ request()->routeIs('datapengguna.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Profile</p>
                </a>
            </li>
            @endif

            @if (session('datawalikelas'))

            @elseif (session('username') == 'Guru Piket')

            @else
            <li class="nav-header">ADMINISTRASI</li>


            <li class="nav-item">
                <a href="{{ route('jurusan.index') }}" class="nav-link {{ request()->routeIs('jurusan.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Jurusan</p>
                </a>
            </li>
            @endif

            <li class="nav-item">
                <a href="{{ route('tahunpelajaran.index') }}" class="nav-link {{ request()->routeIs('tahunpelajaran.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Tahun Pelajaran</p>
                </a>
            </li>
            @endif
            @if (session('datawalikelas'))

            @elseif (session('username') == 'Guru Piket')

            @else
            <li class="nav-item">
                <a href="{{ route('sekolah.index') }}" class="nav-link {{ request()->routeIs('sekolah.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Sekolah</p>
                </a>
            </li>
            @endif
            <li class="nav-item" style="background-color: black;">
                <a href="{{ route('logout') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </nav>
</aside>
