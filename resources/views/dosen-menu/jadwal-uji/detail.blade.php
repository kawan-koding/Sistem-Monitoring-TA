@extends('layout.admin-main')
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Revisi</button>
              <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Nilai</button>
            </div>
        </nav>
        <div class="card">
            <div class="card-body">

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

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                        @if ($timer == 'berlangsung' && $dataBimbingan->jenis == 'penguji')
                        <form action="{{route('dosen.jadwal-uji.create_revisi')}}" method="post">
                            @csrf
                            <input type="hidden" name="tugas_akhir_id" value="{{$dataBimbingan->tugas_akhir_id ?? ''}}">
                            <input type="hidden" name="dosen_id" value="{{$dataDosen->id ?? ''}}">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <label for="">Uraian Revisi</label>
                                    <div class="form-group">
                                        <textarea name="uraian" id="" cols="10" rows="3" class="form-control"></textarea>
                                        {{-- <input type="text" name="uraian" class="form-control" id=""> --}}
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <br>
                                    <button type="submit" class="btn btn=sm btn-primary mt-2" for="">Simpan</button>
                                </div>
                            </div>
                        </form>
                        @endif

                        <hr>

                        <h5>Revisi Penguji</h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td width="3%">No</td>
                                        <td>Uraian</td>
                                        @if ($timer == 'berlangsung' && $dataBimbingan->jenis == 'penguji')
                                        <td>Aksi</td>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($revisi as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->uraian}}</td>
                                            @if ($timer == 'berlangsung' && $dataBimbingan->jenis == 'penguji')
                                            <td>
                                                <button class="btn btn-sm btn-primary update-uraian" data-revisi="{{$item->uraian}}" data-id="{{$item->id}}"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-danger delete-uraian" data-url="{{route('dosen.jadwal-uji.delete', ['id' => $item->id])}}"><i class="fas fa-trash"></i></button>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                        @if ($timer == 'berlangsung')
                        <form action="" method="post">
                            @csrf
                            <input type="hidden" id="tugas_akhir_id" value="{{$dataBimbingan->tugas_akhir_id ?? ''}}">
                            <input type="hidden" id="dosen_id" value="{{$dataDosen->id ?? ''}}">
                            <input type="hidden" id="jenis" value="{{$tipeDosen ?? ''}}">
                            <input type="hidden" id="urut" value="{{$urutDosen ?? ''}}">

                        </form>
                        @endif
                        @php
                            foreach ($nilai as $key) {
                                if($key->aspek == 'Penguasaan Materi'){
                                    $aspek1 = $key->angka;
                                    $hur1 = $key->huruf;
                                }
                                if($key->aspek == 'Ketepatan Menjawab Pertanyaan'){
                                    $aspek2 = $key->angka;
                                    $hur2 = $key->huruf;
                                }
                                if($key->aspek == 'Ketepatan Menjawab Pertanyaan'){
                                    $aspek3 = $key->angka;
                                    $hur3 = $key->huruf;
                                }
                                if($key->aspek == 'Kedalaman Materi'){
                                    $aspek4 = $key->angka;
                                    $hur4 = $key->huruf;
                                }
                                if($key->aspek == 'Etika'){
                                    $aspek5 = $key->angka;
                                    $hur5 = $key->huruf;
                                }
                                if($key->aspek == 'Kedisiplinan'){
                                    $aspek6 = $key->angka;
                                    $hur6 = $key->huruf;
                                }
                            }
                        @endphp

                        <hr>
                        <h5>Nilai {{ucfirst($tipeDosen)}}</h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Aspek</td>
                                        <td>Nilai</td>
                                        <td>Huruf</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Penguasaan Materi</td>
                                        <td>
                                            @if ($timer == 'berlangsung')
                                            <input type="hidden" id="aspek_nilai1" class="form-control" value="Penguasaan Materi">
                                            <input type="number" max="100" onchange="makeNilai('aspek_nilai1', 'nilai1', 'angkaNilai1')" id="nilai1" class="form-control" value="{{$aspek1 ?? 0}}">
                                            @else
                                            {{$aspek1 ?? 0}}
                                            @endif
                                        </td>
                                        <td>
                                            <span id="angkaNilai1">{{$hur1 ?? '-'}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Tinjauan Pustaka</td>
                                        <td>
                                            @if ($timer == 'berlangsung')
                                            <input type="hidden" id="aspek_nilai2" class="form-control" value="Tinjauan Pustaka">
                                            <input type="number" max="100" onchange="makeNilai('aspek_nilai2', 'nilai2', 'angkaNilai2')" id="nilai2" class="form-control" value="{{$aspek2 ?? 0}}">
                                            @else
                                            {{$aspek2 ?? 0}}
                                            @endif
                                        </td>
                                        <td>
                                            <span id="angkaNilai2">{{$hur2 ?? '-'}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Ketepatan Menjawab Pertanyaan</td>
                                        <td>
                                            @if ($timer == 'berlangsung')
                                            <input type="hidden" id="aspek_nilai3" class="form-control" value="Ketepatan Menjawab Pertanyaan">
                                            <input type="number" max="100" onchange="makeNilai('aspek_nilai3', 'nilai3', 'angkaNilai3')" id="nilai3" class="form-control" value="{{$aspek3 ?? 0}}">
                                            @else
                                            {{$aspek3 ?? 0}}
                                            @endif
                                        </td>
                                        <td>
                                            <span id="angkaNilai3">{{$hur3 ?? '-'}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Kedalaman Materi</td>
                                        <td>
                                            @if ($timer == 'berlangsung')
                                            <input type="hidden" id="aspek_nilai4" class="form-control" value="Kedalaman Materi">
                                            <input type="number" max="100" onchange="makeNilai('aspek_nilai4', 'nilai4', 'angkaNilai4')" id="nilai4" class="form-control" value="{{$aspek4 ?? 0}}">
                                            @else
                                            {{$aspek4 ?? 0}}
                                            @endif
                                        </td>
                                        <td>
                                            <span id="angkaNilai4">{{$hur4 ?? '-'}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Etika</td>
                                        <td>
                                            @if ($timer == 'berlangsung')
                                            <input type="hidden" id="aspek_nilai5" class="form-control" value="Etika">
                                            <input type="number" max="100" onchange="makeNilai('aspek_nilai5', 'nilai5', 'angkaNilai5')" id="nilai5" class="form-control" value="{{$aspek5 ?? 0}}">
                                            @else
                                            {{$aspek5 ?? 0}}
                                            @endif
                                        </td>
                                        <td>
                                            <span id="angkaNilai5">{{$hur5 ?? '-'}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Kedisiplinan</td>
                                        <td>
                                            @if ($timer == 'berlangsung')
                                            <input type="hidden" id="aspek_nilai6" class="form-control" value="Kedisiplinan">
                                            <input type="number" max="100" onchange="makeNilai('aspek_nilai6', 'nilai6', 'angkaNilai6')" id="nilai6" class="form-control" value="{{$aspek6 ?? 0}}">
                                            @else
                                            {{$aspek6 ?? 0}}
                                            @endif
                                        </td>
                                        <td>
                                            <span id="angkaNilai6">{{$hur6 ?? '-'}}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('dosen-menu.jadwal-uji.update-revisi')
<script>
    const formUrlChangeOrCreate = "{{route('dosen.jadwal-uji.create_nilai')}}"
</script>
@endsection
