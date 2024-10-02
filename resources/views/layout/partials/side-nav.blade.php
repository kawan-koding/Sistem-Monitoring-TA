<div class="vertical-menu">
    @php
        $myMultiRole = Auth::guard('web')->user()->getRoleNames();
    @endphp

    <div class="h-100">

        <div class="user-wid text-center py-4">
            <div class="user-img">
                <img src="{{asset('images/'.Auth::guard('web')->user()->picture)}}" alt="" class="avatar-md mx-auto rounded-circle">
            </div>

            <div class="mt-3">

                <a href="#" class="text-reset fw-medium font-size-16">{{ ucfirst(Auth::guard('web')->user()->name) }}</a>
                <p class="text-muted mt-1 mb-0 font-size-13 mb-2">{{ucfirst(session('switchRoles'))}}</p>
                <div class="dropdown dropend">
                    {{-- <center> --}}
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-lock"></i>
                        </button>
                    {{-- </center> --}}
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <!-- Replace with dynamic user roles or accounts -->
                      @if ((isset($myMultiRole[0])) && $myMultiRole[0] == 'admin' || (isset($myMultiRole[1])) && $myMultiRole[1] == 'admin' || (isset($myMultiRole[2])) && $myMultiRole[2] == 'admin' || (isset($myMultiRole[3])) && $myMultiRole[3] == 'admin')
                      <li><a class="dropdown-item" href="{{ route('admin.switcher', ['role' => 'admin']) }}">Admin</a></li>
                      @endif
                      @if ((isset($myMultiRole[0])) && $myMultiRole[0] == 'dosen' || (isset($myMultiRole[1])) && $myMultiRole[1] == 'dosen' || (isset($myMultiRole[2])) && $myMultiRole[2] == 'dosen' || (isset($myMultiRole[3])) && $myMultiRole[3] == 'dosen')
                      <li><a class="dropdown-item" href="{{ route('admin.switcher', ['role' => 'dosen']) }}">Dosen</a></li>
                      @endif
                      @if ((isset($myMultiRole[0])) && $myMultiRole[0] == 'kaprodi' || (isset($myMultiRole[1])) && $myMultiRole[1] == 'kaprodi' || (isset($myMultiRole[2])) && $myMultiRole[2] == 'kaprodi' || (isset($myMultiRole[3])) && $myMultiRole[3] == 'kaprodi')
                      <li><a class="dropdown-item" href="{{ route('admin.switcher', ['role' => 'kaprodi']) }}">Kaprodi</a></li>
                      @endif
                      @if ((isset($myMultiRole[0])) && $myMultiRole[0] == 'mahasiswa' || (isset($myMultiRole[1])) && $myMultiRole[1] == 'mahasiswa' || (isset($myMultiRole[2])) && $myMultiRole[2] == 'mahasiswa' || (isset($myMultiRole[3])) && $myMultiRole[3] == 'mahasiswa')
                      <li><a class="dropdown-item" href="{{ route('admin.switcher', ['role' => 'mahasiswa']) }}">Mahasiswa</a></li>
                      @endif
                    </ul>
                  </div>

            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                @can(['read-dashboard'])
                <li>
                    <a href="{{route('admin.dashboard')}}" class=" waves-effect">
                        <i class="mdi mdi-airplay"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @endcan

                {{-- Administrator --}}
                @if (session('switchRoles') == 'admin')
              
                @canany(['read-mahasiswa', 'read-dosen', 'read-ruangan', 'read-topik', 'read-topik'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-inbox-full"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can(['read-mahasiswa'])
                        <li><a href="{{route('admin.mahasiswa')}}">Mahasiswa</a></li>
                        @endcan
                        @can(['read-dosen'])
                        <li><a href="{{route('admin.dosen')}}">Dosen</a></li>
                        @endcan
                        @can(['read-ruangan'])
                        <li><a href="{{route('admin.ruangan')}}">Ruangan</a></li>
                        @endcan
                        @can(['read-topik'])
                        <li><a href="{{route('admin.topik')}}">Topik</a></li>
                        @endcan
                        @can(['read-jenis'])
                        <li><a href="{{route('admin.jenis_ta')}}">Jenis TA</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @can(['read-periode'])
                <li>
                    <a href="{{route('admin.periode')}}" class=" waves-effect">
                        <i class="mdi mdi-calendar-text"></i>
                        <span>Periode TA</span>
                    </a>
                </li>
                @endcan

                @canany(['read-daftarta-admin', 'read-seminar-admin'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-clipboard-list-outline"></i>
                        <span>Tugas Akhir</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can(['read-daftarta-admin'])
                        <li><a href="{{route('admin.daftarta')}}">Daftar TA</a></li>
                        @endcan
                        @can(['read-seminar-admin'])
                        <li><a href="{{route('admin.jadwal-seminar')}}">Jadwal Seminar</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                <li>
                    <a href="{{route('admin.rekapitulasi')}}" class=" waves-effect">
                        <i class="mdi mdi-calendar-text"></i>
                        <span>Rekapitulasi</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.monitoring')}}" class=" waves-effect">
                        <i class="mdi mdi-calendar-text"></i>
                        <span>Monitoring TA</span>
                    </a>
                </li>

                @can(['read-users'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-account-circle-outline"></i>
                        <span>Manajemen User</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.user')}}">User</a></li>
                    </ul>
                </li>
                @endcan

                @canany(['read-kuota', 'read-settings'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-settings"></i>
                        <span>Setting</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can(['read-settings'])
                        <li><a href="{{route('admin.settings')}}">Umum</a></li>
                        @endcan
                        @can(['read-kuota'])
                        <li><a href="{{route('admin.kuotadosen')}}">Kuota Dosen</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                @endif

                @if (session('switchRoles') == 'kaprodi')
                {{-- Kaprodi --}}
                @canany(['read-pengajuanta-kaprodi', 'read-daftarta-kaprodi', 'read-bagidosen-kaprodi'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-clipboard-list-outline"></i>
                        <span>Tugas Akhir</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('read-pengajuanta-kaprodi')
                        <li><a href="{{route('kaprodi.pengajuan-ta')}}">Pengajuan TA</a></li>
                        @endcan
                        @can(['read-daftarta-kaprodi'])
                        {{-- <li><a href="{{route('kaprodi.daftar-ta')}}">Daftar TA</a></li> --}}
                        @endcan
                        @can(['read-bagidosen-kaprodi'])
                        <li><a href="{{route('kaprodi.pembagian-dosen')}}">Pembagian Dosen</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                @endif


                @if (session('switchRoles') == 'dosen')
                {{-- Dosen --}}
                @can(['read-daftar-bimbingan'])
                <li>
                    <a href="{{route('dosen.daftar_bimbingan')}}" class=" waves-effect">
                        <i class="mdi mdi-calendar-text"></i>
                        <span>Daftar Bimbingan</span>
                    </a>
                </li>
                @endcan
                @can(['read-jadwaluji'])
                <li>
                    <a href="{{route('dosen.jadwal-uji')}}" class=" waves-effect">
                        <i class="mdi mdi-calendar-text"></i>
                        <span>Jadwal Uji</span>
                    </a>
                </li>
                @endcan
                @can(['read-rumpunilmu'])
                <li>
                    <a href="{{route('dosen.rumpun-ilmu')}}" class=" waves-effect">
                        <i class="mdi mdi-calendar-text"></i>
                        <span>Rumpun Ilmu</span>
                    </a>
                </li>
                @endcan
                @endif


                @if (session('switchRoles') == 'mahasiswa')
                {{-- Mahasiswa  --}}
                @can(['read-pengajuanta-mahasiswa'])
                <li>
                    <a href="{{route('mahasiswa.pengajuan-ta')}}" class=" waves-effect">
                        <i class="mdi mdi-calendar-text"></i>
                        <span>Pengajuan TA</span>
                    </a>
                </li>
                @endcan
                @can(['read-jadwalseminar-mahasiswa'])
                <li>
                    <a href="{{route('mahasiswa.jadwal-seminar')}}" class=" waves-effect">
                        <i class="mdi mdi-calendar-text"></i>
                        <span>Jadwal Seminar</span>
                    </a>
                </li>
                @endcan
                @endif



            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

