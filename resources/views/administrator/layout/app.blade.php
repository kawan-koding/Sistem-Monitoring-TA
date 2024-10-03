@extends('administrator.layout.base')

@section('app')

    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">

            @include('administrator.layout.partials.top-nav')

            @include('administrator.layout.partials.side-nav')

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            
            @yield('main')

            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

    </div>
    <!-- end container-fluid -->

@endsection