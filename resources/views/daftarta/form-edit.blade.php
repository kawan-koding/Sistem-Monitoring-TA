@extends('layout.admin-main')
@section('content')

<div class="row">
    <div class="col-md-8 col-sm-12 col-lg-8">
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
                <form action="{{route('admin.daftarta.update', ['id' => $data->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Pembimbing 1 <span class="text-danger">*</span></label>
                            <select name="pemb_1" id="pemb_1" class="form-control select2" required>
                                <option value="">Pilih Pembimbing</option>
                                @foreach ($dataDosen as $item)
                                <option value="{{$item->id}}" {{$bimbingUji->dosen_id == $item->id ? "selected='selected'" : ''}}>{{$item->nidn}} - {{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Pembimbing 2 <span class="text-danger">*</span></label>
                            <select name="pemb_2" id="pemb_2" class="form-control select2" required>
                                <option value="">Pilih Pembimbing</option>
                                @foreach ($dataDosen as $item)
                                <option value="{{$item->id}}" {{$bimbingUji2->dosen_id == $item->id ? "selected='selected'" : ''}}>{{$item->nidn}} - {{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Penguji 1 <span class="text-danger">*</span></label>
                            <select name="peng_1" id="peng_1" class="form-control select2" required>
                                <option value="">Pilih Penguji</option>
                                @foreach ($dataDosen as $item)
                                <option value="{{$item->id}}" {{$bimbingUji3->dosen_id == $item->id ? "selected='selected'" : ''}}>{{$item->nidn}} - {{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Penguji 2 <span class="text-danger">*</span></label>
                            <select name="peng_2" id="peng_2" class="form-control select2" required>
                                <option value="">Pilih Penguji</option>
                                @foreach ($dataDosen as $item)
                                <option value="{{$item->id}}" {{$bimbingUji4->dosen_id == $item->id ? "selected='selected'" : ''}}>{{$item->nidn}} - {{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Jenis TA <span class="text-danger">*</span></label>
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option value="">Pilih Jenis</option>
                                @foreach ($dataJenis as $item)
                                <option value="{{$item->id}}" {{$data->jenis_ta_id == $item->id ? "selected='selected'" : ''}}>{{$item->nama_jenis}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Topik <span class="text-danger">*</span></label>
                            <select name="topik" id="topik" class="form-control" required>
                                <option value="">Pilih Topik</option>
                                @foreach ($dataTopik as $item)
                                <option value="{{$item->id}}" {{$data->topik_id == $item->id ? "selected='selected'" : ''}}>{{$item->nama_topik}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="judul" id="judul" placeholder="Masukkan Judul ..." required class="form-control" value="{{$data->judul}}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Tipe <span class="text-danger">*</span></label>
                            <select name="tipe" id="tipe" class="form-control" required>
                                <option value="">Pilih Tipe</option>
                                <option value="K" {{$data->tipe == 'K' ? "selected='selected'" : ''}}>Kelompok</option>
                                <option value="I" {{$data->tipe == 'I' ? "selected='selected'" : ''}}>Individu</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Dokumen Pembimbing 1 <span class="text-danger">*</span></label>
                            <input type="file" name="dokumen_pembimbing_1" id="dokumen_pembimbing_1" class="form-control" >
                            @if ($errors->has('dokumen_pembimbing_1'))
                            <span class="text-danger">{{ $errors->first('dokumen_pembimbing_1') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Dokumen Ringkasan <span class="text-danger">*</span></label>
                            <input type="file" name="dokumen_ringkasan" id="dokumen_ringkasan" class="form-control">
                            @if ($errors->has('dokumen_ringkasan'))
                            <span class="text-danger">{{ $errors->first('dokumen_ringkasan') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Periode Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="periode_mulai" id="periode_mulai" class="form-control" value="{{$data->periode_mulai}}" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Periode Akhir <span class="text-danger">*</span></label>
                            <input type="date" name="periode_akhir" id="periode_akhir" class="form-control" value="{{$data->periode_akhir}}" required>
                        </div>
                    </div>
                </div>
                <hr>
                <a href="{{route('mahasiswa.pengajuan-ta')}}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="">
                        <thead>
                            <tr>
                                <th colspan="5">Kuota Dosen</th>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <th>Pemb 1</th>
                                <th>Pemb 2</th>
                                <th>Penguji 1</th>
                                <th>Penguji 2</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dosenKuota as $item)
                            <tr>
                                <td>{{$item->nidn}}-{{$item->nama}}</td>
                                <td>
                                    {{$item->total_pemb_1}}/{{$item->kuota_pemb_1}}
                                </td>
                                <td>
                                    {{$item->total_pemb_2}}/{{$item->kuota_pemb_2}}
                                </td>
                                <td>
                                    {{$item->total_peng_1}}/{{$item->kuota_peng_1}}
                                </td>
                                <td>
                                    {{$item->total_peng_2}}/{{$item->kuota_peng_2}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- @include('user.form')
<script>
    const formUrlCreate = "{{route('admin.user.store')}}"
    const formUrlUpdate = "{{route('admin.user.update')}}"
</script> --}}
@endsection
