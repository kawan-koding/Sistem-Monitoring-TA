@extends('administrator.layout.main')
@section('content')
    <style>
        .nav-link:hover {
            transition: .3s ease-in-out;
            padding-left: 1.5rem !important;
        }
    </style>
    <div class="row">
        <div class="col-md-3 col-sm-12 col-12">
            <div class="card shadow-sm m-0 p-0 mb-3" style="position: relative;z-index: 99999!important">
                <a href="javascript:void(0)" data-toggle="tab" data-target="#revisionTab"
                    class="nav-link d-block border-start border-primary text-primary px-4 py-2 fw-bold"
                    style="border-width: 3px!important">Revisi</a>
                <a href="javascript:void(0)" data-toggle="tab" data-target="#ratingTab" class="nav-link d-block px-3 py-2">Penilaian</a>
                <a href="javascript:void(0)" data-toggle="tab" data-target="#ratingRecapTab"
                    class="nav-link d-block px-3 py-2">Rekapitulasi Nilai</a>
            </div>
        </div>
        <div class="col-md-9 col-sm-12 col-12">
            <div id="revisionTab" class="tab-item active">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        @include('administrator.jadwal-seminar.partials.revision-tab')
                    </div>
                </div>
            </div>
            <div id="ratingTab" class="tab-item d-none">
                @include('administrator.jadwal-seminar.partials.rating-tab')
            </div>
            <div id="ratingRecapTab" class="tab-item d-none">
                @include('administrator.jadwal-seminar.partials.recap-rating-tab')
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.tab-item.d-none').hide()
        $('.tab-item.d-none').removeClass('d-none')

        $('[data-toggle="tab"]').unbind().on('click', function(e) {
            e.preventDefault()
            var target = $(this).data('target')
            $('a[data-toggle="tab"]').attr('class', 'nav-link d-block px-3 py-2').removeAttr('style')
            $(this).attr('class', 'nav-link d-block border-start border-primary text-primary px-4 py-2 fw-bold')
                .attr('style', 'border-width: 3px!important')
            $('.tab-item.active').removeClass('active')
            $(target).addClass('active')
            refreshTab()
        })

        function refreshTab() {
            $('.tab-item').hide()
            $('.tab-item.active').show('fade')
        }
    </script>
@endsection
