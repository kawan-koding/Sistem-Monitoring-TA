@extends('layout.admin-main')
@section('content')

<div class="row">
    <div class="col-md-6 col-sm-12 col-lg-6">
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
                <form action="{{route('admin.jadwal-seminar.store', ['id' => $data->id])}}" method="post">
                    @csrf
                    
                    <div class="form-group mb-3" style="display: none;">
                        <label for="">Hari <span class="text-danger">*</span></label>
                        <select name="hari" id="hari" class="form-control" required>
                            {{-- <option value="">Pilih Hari</option> --}}
                            @foreach ($hari as $item)
                            <option {{($jadwalSeminar->hari_id ?? null) == $item->id ? "selected='selected'" : ''}} value="{{$item->id}}">{{$item->nama_hari}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" value="{{$jadwalSeminar->tanggal ?? ''}}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Jam Mulai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="jam_mulai" id="jam_mulai" value="{{$jadwalSeminar->jam_mulai ?? ''}}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Jam Selesai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="jam_selesai" id="jam_selesai" value="{{$jadwalSeminar->jam_selesai ?? ''}}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Ruangan <span class="text-danger">*</span></label>
                        <select name="ruangan" id="ruangan" class="form-control" onchange="checkRuangan()" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach ($ruangan as $item)
                                <option {{($jadwalSeminar->ruangan_id ?? null) == $item->id ? "selected='selected'" : ''}} value="{{$item->id}}">{{$item->nama_ruangan}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4>Jadwal Terdaftar</h4>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <tr>
                            <th colspan="3">{{$pembimbing_1}}</th>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                        </tr>
                        @foreach ($jadwalSeminarTerdaftarPembimbing1 as $item)

                        <tr>
                            <td>{{$item['tanggal']}}</td>
                            <td>{{$item['jam_mulai']}}</td>
                            <td>{{$item['jam_selesai']}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <tr>
                            <th colspan="3">{{$pembimbing_2}}</th>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                        </tr>
                        @foreach ($jadwalSeminarTerdaftarPembimbing2 as $item)

                        <tr>
                            <td>{{$item['tanggal']}}</td>
                            <td>{{$item['jam_mulai']}}</td>
                            <td>{{$item['jam_selesai']}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <tr>
                            <th colspan="3">{{$penguji_1}}</th>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                        </tr>
                        @foreach ($jadwalSeminarTerdaftarPenguji1 as $item)

                        <tr>
                            <td>{{$item['tanggal']}}</td>
                            <td>{{$item['jam_mulai']}}</td>
                            <td>{{$item['jam_selesai']}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <tr>
                            <th colspan="3">{{$penguji_2}}</th>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                        </tr>
                        @foreach ($jadwalSeminarTerdaftarPenguji2 as $item)

                        <tr>
                            <td>{{$item['tanggal']}}</td>
                            <td>{{$item['jam_mulai']}}</td>
                            <td>{{$item['jam_selesai']}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const urlCheckRuangan = `{{route("admin.jadwal-seminar.chekRuangan")}}`;
</script>
@endsection
