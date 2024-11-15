@extends('administrator.layout.app')

@section('main')
    <div class="main-content">

        <div class="page-content">
            <div class="row mb-5 mb-lg-0">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="page-title mb-0 font-size-18">{{ $title }}</h4>

                            @if (isset($breadcrumbs))
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    @foreach ($breadcrumbs as $item)
                                        @if (isset($item['is_active']) && $item['is_active'])
                                            <li class="breadcrumb-item active">{{ $item['title'] }}</li>
                                        @else
                                            <li class="breadcrumb-item"><a
                                                    href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
                                        @endif
                                    @endforeach
                                </ol>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="mdi mdi-alert-circle-outline me-2"></i> 
                <strong>Pemberitahuan:</strong> 
                <br>Aplikasi akan dilakukan pembaruan pada pukul <strong>18:30</strong> hingga <strong>21:00</strong>. 
                Mohon untuk tidak melakukan aktivitas apa pun selama waktu tersebut untuk menghindari gangguan pada data dan proses kerja. 
            </div> --}}

            @yield('content')

        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        {{ getSetting('app_copyright') }}
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection
