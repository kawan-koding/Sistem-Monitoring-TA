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
                @if(getInfoLogin()->hasRole('Dosen') && $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->jenis == 'pembimbing' && $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->urut == 1 || getInfoLogin()->hasRole('Mahasiswa'))
                <a href="javascript:void(0)" data-toggle="tab" data-target="#ratingRecapTab"
                    class="nav-link d-block px-3 py-2">Rekapitulasi Nilai</a>
                @endif
            </div>
            @if (
                    $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->where('jenis', 'pembimbing')->where('urut', 1)->count() > 0 &&
                    $data->tugas_akhir->status_sidang != 'acc' &&
                    $data->tugas_akhir->status_sidang != 'reject' &&
                        (!is_null($data->tugas_akhir->sidang) && $data->tugas_akhir->sidang->status == 'sudah_sidang'))
                    <button class="btn btn-primary btn-sm mb-1 w-100 mt-0" type="button" data-bs-toggle="modal" data-bs-target="#myModal{{$data->id}}">Setujui?</button>
                    <div class="modal fade" id="myModal{{$data->id}}">
                        <div class="modal-dialog text-start">
                            <div class="modal-content">
                                <form action="{{ route('apps.jadwal-sidang.update-status', $data->tugas_akhir->sidang->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header d-block">
                                        <h5 class="mb-0">Update status sidang akhir</h5>
                                        <p class="text-muted small mb-0">Berikan keputusan terkait status sidang akhir</p>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="">Status Sidang Akhir <span class="text-danger">*</span></label><br>
                                            <label for="acc{{$data->id}}" class="me-2"><input type="radio" name="status" id="acc{{$data->id}}" value="acc" {{$data->tugas_akhir->status_sidang == 'acc' ? 'checked' : ''}}> Setujui</label>
                                            <label for="revisi{{$data->id}}" class="me-2"><input type="radio" name="status" id="revisi{{$data->id}}" value="revisi" {{$data->tugas_akhir->status_sidang == 'revisi' ? 'checked' : ''}}> Disetujui dengan revisi</label>
                                            <label for="repeat{{$data->id}}" class="me-2"><input type="radio" name="status" id="repeat{{$data->id}}" value="repeat" {{$data->tugas_akhir->status_sidang == 'repeat' ? 'checked' : ''}}> Sidang Ulang</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-light" type="button" data-bs-dismiss="modal">Batal</button>
                                        <button class="btn btn-primary" type="submit"><i class="bx bx-save"></i> Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                        @include('administrator.jadwal-sidang.partials.revision-tab')
                    </div>
                </div>
            </div>
            <div id="ratingTab" class="tab-item d-none">
                @include('administrator.jadwal-sidang.partials.rating-tab')
            </div>
            <div id="ratingRecapTab" class="tab-item d-none">
                @include('administrator.jadwal-sidang.partials.recap-rating-tab')
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
