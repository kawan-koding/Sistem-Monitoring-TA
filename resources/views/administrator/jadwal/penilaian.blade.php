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
            <div class="card shadow-sm m-0 p-0 mb-3" style="position: relative;z-index: 555!important">
                <a href="javascript:void(0)" data-toggle="tab" data-target="#revisionTab"
                    class="nav-link d-block border-start border-primary text-primary px-4 py-2 fw-bold"
                    style="border-width: 3px!important">Revisi</a>
                <a href="javascript:void(0)" data-toggle="tab" data-target="#ratingTab" class="nav-link d-block px-3 py-2">Penilaian</a>
                @if($data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->jenis == 'pembimbing' && $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->urut == 1)
                <a href="javascript:void(0)" data-toggle="tab" data-target="#ratingRecapTab"
                    class="nav-link d-block px-3 py-2">Rekapitulasi Nilai</a>
                @endif
            </div>
                @if (
                    $item->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->where('jenis', 'pembimbing')->where('urut', 1)->count() > 0 &&
                        $item->tugas_akhir->status_seminar != 'acc' &&
                        $item->tugas_akhir->status_seminar != 'reject' &&
                        (!is_null($item->tugas_akhir->jadwal_seminar) && $item->tugas_akhir->jadwal_seminar->status == 'telah_seminar'))
                    <button class="btn btn-primary btn-sm mb-1 w-100 mt-0" type="button" data-bs-toggle="modal"
                        data-bs-target="#myModal">Setujui?</button>
                    @include('administrator.jadwal.partials.modal')
                @endif
        </div>
        <div class="col-md-9 col-sm-12 col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-block-helper me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                @endif
                @if ($errors->any())
                <div class="alert alert-error alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
            <div id="revisionTab" class="tab-item active">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        @include('administrator.jadwal.partials.revision-tab')
                    </div>
                </div>
            </div>
            <div id="ratingTab" class="tab-item d-none">
                @include('administrator.jadwal.partials.rating-tab')
            </div>
            <div id="ratingRecapTab" class="tab-item d-none">
                @include('administrator.jadwal.partials.recap-rating-tab')
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

        // allow input for number only
        $('.numberOnly').bind('keyup mouseup', function() {
            // remove zero value in front
            $(this).val($(this).val().replace(/^0/, ''));
            $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
            // max value 100
            if ($(this).val() > 100) {
                $(this).val(100);
            }
        });

        // display average value for .numberOnly and render in .average-display 
        $('.numberOnly').bind('keyup mouseup', function() {
            var sum = 0;
            $('.numberOnly').each(function() {
                sum += +$(this).val();
            });
            var average = sum / $('.numberOnly').length;
            // if average NaN render "-"
            if (isNaN(average)) {
                average = "-";
            }
            $('.average-display').html(average.toFixed(2));

            // set grade where data-grade-display
            var grade = getGrade($(this).val() || 0);
            $($(this).data('grade-display')).html(grade);
            
            // set average grade in .average-grade-display
            var averageGrade = getGrade(average);
            $('.average-grade-display').html(averageGrade);
        })

        function getGrade(value) {
            var grade = "E";
            if (value > 80) {
                grade = "A";
            } else if (value > 75) {
                grade = "AB";
            } else if (value > 65) {
                grade = "B";
            } else if (value > 60) {
                grade = "BC";
            } else if (value > 55) {
                grade = "C";
            } else if (value > 40) {
                grade = "D";
            } else {
                grade = "E";
            }

            return grade
        }
    </script>
@endsection
