
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="container-fluid">
                    <div class="float-end">

                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                <i class="mdi mdi-fullscreen"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="{{ asset('storage/images/users/' . getInfoLogin()->image )}}" alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1">{{ ucfirst(getInfoLogin()->name) }}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                @if(!getInfoLogin()->hasAnyRole(['Admin', 'Developer','Teknisi']))
                                <a class="dropdown-item" href="{{route('apps.profile')}}"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                                    Profile</a>
                                @endif
                                @if(getInfoLogin()->hasAnyRole(['Admin', 'Developer']))
                                    <a class="dropdown-item" href="{{ route('apps.settings')}}"><i class="bx bx-cog font-size-16 align-middle me-1"></i>Pengaturan</a>
                                @endif
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{route('logout')}}"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="#" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{asset('storage/images/settings/'. getSetting('app_logo'))}}" alt="" height="40">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{asset('storage/images/settings/'. getSetting('app_logo'))}}" alt="" height="40">
                                </span>
                            </a>

                            <a href="#" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{asset('storage/images/settings/'. getSetting('app_logo'))}}" alt="" height="40">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{asset('storage/images/settings/'. getSetting('app_logo'))}}" alt="" height="40">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                            id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>



                    </div>

                </div>
            </div>
        </header> <!-- ========== Left Sidebar Start ========== -->
