<div class="vertical-menu">
    <div class="h-100">
        <div class="user-wid text-center py-4">
            <div class="user-img">
                <img src="{{asset('storage/images/users/'. getInfoLogin()->image)}}" alt="" class="avatar-md mx-auto rounded-circle">
            </div>

            <div class="mt-3">

                <a href="#" class="text-reset fw-medium font-size-16">{{ ucfirst(getInfoLogin()->name) }}</a>
                <p class="text-muted mt-1 mb-0 font-size-13 mb-2">{{ucfirst(session('switchRoles'))}}
                    @if (session('switchRoles') === 'Kaprodi' && session('program_studi'))
                        {{ session('program_studi') }}
                    @endif
                </p>
                <div class="dropdown dropend">
                    {{-- <center> --}}
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-lock"></i>
                        </button>
                    {{-- </center> --}}
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach (getAvailableRoles() as $role)
                            @if (userHasRole($role))
                                <li>
                                    <a class="dropdown-item" href="{{ route('apps.switcher', ['role' => $role]) }}">{{ ucfirst($role) }}</a>
                                </li>
                            @endif
                        @endforeach
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
                    <a href="{{route('apps.dashboard')}}" class=" waves-effect">
                        <i class="mdi mdi-airplay"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @endcan
                @can(['read-rekomendasi-topik'])
                <li>
                    <a href="{{route('apps.rekomendasi-topik')}}" class=" waves-effect">
                        <i class="mdi mdi-book-open"></i>
                        <span>Tawaran Tugas Akhir</span>
                    </a>
                </li>
                @endcan
                @if(session('switchRoles') === 'Dosen')
                    @can(['read-daftar-bimbingan'])
                    <li>
                        <a href="{{route('apps.daftar-bimbingan')}}" class=" waves-effect">
                            <i class="mdi mdi-file-edit-outline"></i>
                            <span>Daftar Bimbingan</span>
                        </a>
                    </li>
                    @endcan
                    @can(['read-jadwal-seminar'])
                    <li>
                        <a href="{{route('apps.jadwal')}}" class=" waves-effect">
                            <i class="bx bx-calendar"></i>
                            <span>Jadwal Seminar</span>
                        </a>
                    </li>
                    @endcan
                    @can(['read-daftar-sidang'])
                    <li>
                        <a href="{{ route('apps.jadwal-sidang')}}" class=" waves-effect">
                            <i class="bx bx-calendar-event"></i>
                            <span>Jadwal Sidang</span>
                        </a>
                    </li>
                    @endcan
                @endif

                @if(in_array(session('switchRoles'), ['Mahasiswa','Developer']))
                    @can(['read-pengajuan-tugas-akhir'])
                    <li>
                        <a href="{{ route('apps.pengajuan-ta')}}" class=" waves-effect">
                            <i class="mdi mdi-calendar-text"></i>
                            <span>Tugas akhir</span>
                        </a>
                    </li>
                    @endcan
                    @can(['read-jadwal-seminar'])
                    <li>
                        <a href="{{ route('apps.jadwal-seminar')}}" class=" waves-effect">
                            <i class="bx bx-calendar"></i>
                            <span>Jadwal Seminar</span>
                        </a>
                    </li>
                    @endcan
                    @can(['read-daftar-sidang'])
                    <li>
                        <a href="{{ route('apps.jadwal-sidang')}}" class=" waves-effect">
                            <i class="bx bx-calendar-event"></i>
                            <span>Jadwal Sidang</span>
                        </a>
                    </li>
                    @endcan
                @endif

                @if(in_array(session('switchRoles'), ['Mahasiswa','Kaprodi','Kajur']))
                <li>
                    <a href="{{ route('apps.profile-dosen') }}" class=" waves-effect">
                        <i class="mdi mdi-account-details"></i>
                        <span>Pofile Dosen</span>
                    </a>
                </li>
                @endcan

                @if (in_array(session('switchRoles'), ['Admin','Developer','Kajur','Kaprodi','Teknisi']))
                    @canany(['read-mahasiswa', 'read-dosen', 'read-ruangan', 'read-topik', 'read-topik', 'read-jurusan', 'read-program-studi', 'read-jenis', 'read-kuota', 'read-kategori-nilai', 'read-jenis-dokumen'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-inbox-full"></i>
                            <span>Master Data</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can(['read-jurusan'])
                            <li><a href="{{route('apps.jurusan')}}">Jurusan</a></li>
                            @endcan
                            @can(['read-program-studi'])
                            <li><a href="{{route('apps.program-studi')}}">Program Studi</a></li>
                            @endcan
                            @can(['read-mahasiswa'])
                            <li><a href="{{route('apps.mahasiswa')}}">Mahasiswa</a></li>
                            @endcan
                            @can(['read-dosen'])
                            <li><a href="{{route('apps.dosen')}}">Dosen</a></li>
                            @endcan
                            @can(['read-topik'])
                            <li><a href="{{route('apps.topik')}}">Topik</a></li>
                            @endcan
                            @can(['read-ruangan'])
                            <li><a href="{{ route('apps.ruangan')}}">Ruangan</a></li>
                            @endcan
                            @can(['read-jenis'])
                            <li><a href="{{route('apps.jenis-ta')}}">Jenis TA</a></li>
                            @endcan
                            @can(['read-kuota'])
                            <li><a href="{{ route('apps.kuota-dosen')}}">Kuota Dosen</a></li>
                            @endcan
                            @can(['read-kategori-nilai'])
                            <li><a href="{{ route('apps.kategori-nilai')}}">Kategori Nilai</a></li>
                            @endcan
                            @can(['read-jenis-dokumen'])
                            <li><a href="{{ route('apps.jenis-dokumen')}}">Jenis Dokumen</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany
                    @can(['read-periode'])
                        <li>
                            <a href="{{route('apps.periode')}}" class=" waves-effect">
                                <i class="mdi mdi-calendar-text"></i>
                                <span>Periode TA</span>
                            </a>
                        </li>
                    @endcan
                @endif

                @if (in_array(session('switchRoles'), ['Admin','Kaprodi','Developer','Kajur']))
                    @canany(['read-daftar-ta', 'read-pengajuan-tugas-akhir', 'read-pembagian-dosen'])
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-clipboard-list-outline"></i>
                                <span>Tugas Akhir</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @can(['read-daftar-ta'])
                                <li><a href="{{route('apps.daftar-ta')}}">Daftar TA</a></li>
                                @endcan
                                @if (getInfoLogin()->hasRole('Kaprodi') || getInfoLogin()->hasRole('Developer'))
                                    @can(['read-pengajuan-tugas-akhir'])
                                    <li><a href="{{route('apps.pengajuan-ta')}}">Pengajuan TA</a></li>
                                    @endcan
                                @endif
                                @can(['read-pembagian-dosen'])
                                <li><a href="{{route('apps.pembagian-dosen')}}">Pembagian Dosen</a></li>
                                @endcan
                                @if ((getInfoLogin()->hasRole('Admin') && (session('switchRoles') == 'Admin') || getInfoLogin()->hasRole('Mahasiswa')))
                                    @can('read-jadwal-seminar')
                                    <li><a href="{{route('apps.jadwal-seminar')}}">Jadwal Seminar</a></li>
                                    @endcan
                                    @can('read-jadwal-seminar')
                                    <li><a href="{{route('apps.jadwal-sidang')}}">Jadwal Sidang</a></li>
                                    @endcan
                                @endif
                            </ul>
                        </li>
                    @endcanany
                @endif

                @if (in_array(session('switchRoles'), ['Admin','Developer','Teknisi']))
                    @canany(['read-users', 'read-roles'])
                        <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-circle-outline"></i>
                            <span>Manajemen Pengguna</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can(['read-users'])
                            <li><a href="{{route('apps.users')}}">Pengguna</a></li>
                            @endcan
                            @can(['read-roles'])
                            <li><a href="{{route('apps.roles')}}">Role</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany
                    @canany(['read-kuota', 'read-settings'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-settings"></i>
                            <span>Pengaturan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can(['read-setting'])
                            <li><a href="{{ route('apps.settings')}}">Aplikasi</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany
                @endif
                @if(session('switchRoles') == 'Admin' || session('switchRoles') == 'Developer')
                <li>
                    <a href="{{route('apps.archives')}}" class=" waves-effect">
                        <i class="mdi mdi-archive"></i>
                        <span>Arsip</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{route('apps.guide')}}" class=" waves-effect">
                        <i class="mdi mdi-television-guide"></i>
                        <span>Panduan</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

