@extends('administrator.layout.main')
@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-8">
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
                    @if ($errors->any())
                        <div class="alert alert-error alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('apps.pengajuan-ta.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="pembimbing_1">Pembimbing 1 <span class="text-danger">*</span></label>
                            <select name="pembimbing_1" class="form-control" required>
                                <option value="">Pilih Dosen Pembimbing 1</option>
                                @foreach ($dataDosen as $item)
                                <option value="{{$item->id}}" {{ isset($editedData) ? $editedData->bimbing_uji()->where('tugas_akhir_id', $editedData->id)->first()->dosen->id == $item->id ? "selected" : '' : ''}}>({{($item->kuota_pembimbing_1-$item->total_pembimbing_1)}}) {{$item->nidn}} - {{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="jenis_ta_id">Jenis TA <span class="text-danger">*</span></label>
                                    <select name="jenis_ta_id" class="form-control" required>
                                        <option value="">Pilih Jenis TA</option>
                                        @foreach ($dataJenis as $item)
                                            <option value="{{$item->id}}" {{ isset($editedData) ? $editedData->jenis_ta_id == $item->id ? "selected" : '' : ''}}>{{$item->nama_jenis}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="judul">Judul <span class="text-danger">*</span></label>
                                    <input type="text" name="judul" class="form-control" value="{{isset($editedData) ? $editedData->judul : ''}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="">Dokumen Dosen Pembimbing 1 <span class="text-danger">*</span></label>
                                    <input type="file" name="dokumen_pembimbing_1" class="form-control" required>
                                    @if(isset($editedData) && !is_null($editedData->document_pembimbing_1))
                                        <a href="{{ asset('assets/dokumen/'.$editedData->document_pembimbing_1) }}" target="_blank" class="nav-link">Lihat Dokumen Dosen Pembimbing 1</a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="topik">Topik <span class="text-danger">*</span></label>
                                    <select name="topik" class="form-control" required>
                                        <option value="">Pilih Topik</option>
                                        @foreach ($dataTopik as $item)
                                            <option value="{{$item->id}}" {{ isset($editedData) ? $editedData->topik_id == $item->id ? "selected" : '' : ''}}>{{$item->nama_topik}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tipe">Tipe <span class="text-danger">*</span></label>
                                    <select name="tipe" class="form-control" required>
                                        <option value="">Pilih tipe</option>
                                        <option value="K" {{isset($editedData) && $editedData->tipe ? "selected" : ''}}>Kelompok</option>
                                        <option value="I" {{isset($editedData) && $editedData->tipe ? "selected" : ''}}>Individu</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dokumen_ringkasan">Dokumen Ringkasan <span class="text-danger">*</span></label>
                                    <input type="file" name="dokumen_ringkasan" class="form-control" required>
                                    @if(isset($editedData) && !is_null($editedData->dokumen_ringkasan))
                                        <a href="{{ asset('assets/dokumen/'.$editedData->dokumen_ringkasan) }}" target="_blank" class="nav-link">Lihat Dokumen Ringkasan</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-secondary">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <th colspan="2">Kuota Dosen</th>
                            </thead>
                            <thead>
                                <th>Nama</th>
                                <th>Kuota</th>
                            </thead>
                            <tbody>
                                {{-- {{dd($dosenKuota)}} --}}
                                @foreach ($dosenKuota as $item)
                                <tr>
                                        <td>{{$item->nidn}}-{{$item->nama}}</td>    
                                        <td>{{$item->total_pembimbing_1}}/{{$item->kuota_pembimbing_1}}</td>
                                </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection