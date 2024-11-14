@extends('administrator.layout.main')
@section('content')

<div class="row">
    <div class="col-lg-8 col-md-12 col-sm-12">
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
                <form action="{{ $action }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="">Judul TA <span class="text-danger">*</span></label>
                        <textarea name="judul" class="form-control" id="judul">{{ isset($data->judul) ? $data->judul : '' }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label for="">Pembimbing 1 <span class="text-danger">*</span></label>
                                <select name="pembimbing_1" id="pemb_1"  onchange="updateOptions()" class="form-control dosen-select select2">
                                    <option value="">Pilih Pembimbing</option>
                                    @foreach($dosen as $item)
                                    <option value="{{ $item->id }}" {{ (isset($pemb1->dosen_id) && $pemb1->dosen_id == $item->id) ? 'selected' : '' }}>
                                        {{ $item->nama }} (Sisa: {{ $item->sisa_pemb_1 }})
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label for="">Pembimbing 2 <span class="text-danger">*</span></label>
                                <select name="pembimbing_2" id="pemb_2"  onchange="updateOptions()" class="form-control dosen-select  select2">
                                    <option value="">Pilih Pembimbing</option>
                                    @foreach($dosen as $item)
                                    <option value="{{ $item->id }}" {{ (isset($pemb2->dosen_id) && $pemb2->dosen_id == $item->id) ? 'selected' : '' }}>
                                        {{ $item->nama }} (Sisa: {{ $item->sisa_pemb_2 }})
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label for="">Penguji 1 <span class="text-danger">*</span></label>
                                <select name="penguji_1" id="peng_1"  onchange="updateOptions()" class="form-control dosen-select  select2">
                                    <option value="">Pilih Penguji</option>
                                    @foreach($dosen as $item)
                                    <option value="{{ $item->id }}" {{ (isset($peng1->dosen_id) && $peng1->dosen_id == $item->id) ? 'selected' : '' }}>
                                        {{ $item->nama }} (Sisa: {{ $item->sisa_peng_1 }})
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label for="">Penguji 2 <span class="text-danger">*</span></label>
                                <select name="penguji_2" id="peng_2"  onchange="updateOptions()" class="form-control dosen-select  select2">
                                    <option value="">Pilih Penguji</option>
                                    @foreach($dosen as $item)
                                    <option value="{{ $item->id }}" {{ (isset($peng2->dosen_id) && $peng2->dosen_id == $item->id) ? 'selected' : '' }}>
                                        {{ $item->nama }} (Sisa: {{ $item->sisa_peng_2 }})
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-3">
                                <label for="">Jenis TA <span class="text-danger">*</span></label>
                                <select name="jenis_ta_id" id="jenis" class="form-control ">
                                    <option value="">Pilih Jenis</option>
                                    @foreach ($jenis as $item)
                                    <option value="{{$item->id}}" {{ isset($data) && $data->jenis_ta_id == $item->id ? 'selected' : ' ' }}>{{$item->nama_jenis}}</option>
                                    @endforeach
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-3" id="new_jenis" style="display: none;">
                                <label for="">Masukkan Jenis</label>
                                <input type="text" class="form-control" id="jenis_ta_new" name="jenis_ta_new" placeholder="Masukkan jenis topik">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-3">
                                <label for="">Topik <span class="text-danger">*</span></label>
                                <select name="topik_id" id="topik" class="form-control">
                                    <option value="">Pilih Topik</option>
                                    @foreach ($topik as $item)
                                    <option value="{{$item->id}}" {{ isset($data) && $data->topik_id == $item->id ? 'selected' : ' ' }}>{{$item->nama_topik}}</option>
                                    @endforeach
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-3" id="new_topik" style="display: none;">
                                <label for="">Masukkan Topik</label>
                                <input type="text" class="form-control" id="topik_ta_new" name="topik_ta_new" placeholder="Masukkan nama topik">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-3">
                                <label for="">Tipe <span class="text-danger">*</span></label>
                                <select name="tipe" id="tipe" class="form-control">
                                    <option value="">Pilih Tipe</option>
                                    <option value="K" {{ isset($data) && $data->tipe ? 'selected' : '' }}>Kelompok</option>
                                    <option value="I" {{ isset($data) && $data->tipe ? 'selected' : '' }}>Individu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($doc as $item)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">{{ ucwords(strtolower(ucfirst($item->nama))) }} <span class="text-danger">*</span></label>
                                <input type="file" name="dokumen_{{ $item->id }}" class="form-control filepond">
                                @if(isset($editedData) && !is_null($item->pemberkasan()->where('tugas_akhir_id', $editedData->id)->first()))
                                    <a href="{{ asset('storage/files/pemberkasan/'. $item->pemberkasan()->where('tugas_akhir_id', $editedData->id)->first()->filename) }}" target="_blank" class="nav-link small text-primary mt-1" accept=".docx, .pdf"><i>Lihat {{ strtolower($item->nama) }}</i></a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="text-end">
                        <a href="{{route('apps.daftar-ta')}}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-sm-12">
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
                                @foreach ($dosen as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->total_pemb_1 }}/{{ $item->kuota_pemb_1 }}</td>
                                <td>{{ $item->total_pemb_2 }}/{{ $item->kuota_pemb_2 }}</td>
                                <td>{{ $item->total_peng_1 }}/{{ $item->kuota_peng_1 }}</td>
                                <td>{{ $item->total_peng_2 }}/{{ $item->kuota_peng_2 }}</td>
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