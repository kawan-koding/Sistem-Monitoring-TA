@extends('layout.admin-main')
@section('content')
<style>
    .hidden-option {
    display: none;
}
</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <strong>Kelas</strong>
                        <br>
                        <p>{{$data->mahasiswa->kelas}}</p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <strong>NIM</strong>
                        <br>
                        <p>{{$data->mahasiswa->nim}}</p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <strong>Nama</strong>
                        <br>
                        <p>{{$data->mahasiswa->nama_mhs}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <strong>Judul</strong>
                        <br>
                        <p>{{$data->judul}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <strong>Tipe TA</strong>
                        <br>
                        <p>{{$data->tipe == 'I' ? 'Individu' : "Kelompok"}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                <form action="{{route('kaprodi.pembagian-dosen.update', ['id' => $data->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Pembimbing 1 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name_pemb_1" value="{{$bimbingUji->dosen->name}}" readonly>
                            <input type="hidden" class="form-control form-pemb_1" name="pemb_1" value="{{$bimbingUji->dosen_id}}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Pembimbing 2 <span class="text-danger">*</span></label>
                            <select name="pemb_2" onchange="updateOptions()" id="pemb_2" class="form-control select2-1 dosen-select" required>
                                <option value="">Pilih Pembimbing</option>
                                @foreach ($dataDosen as $item)
                                <option value="{{$item->id}}" {{($bimbingUji2->dosen_id ?? null) == $item->id ? "selected='selected'" : ''}}>({{($item->kuota_pemb_2-$item->total_pemb_2)}}) {{$item->nidn}} - {{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Penguji 1 <span class="text-danger">*</span></label>
                            <select name="peng_1" onchange="updateOptions()" id="peng_1" class="form-control dosen-select select2-2" required>
                                <option value="">Pilih Penguji</option>
                                @foreach ($dataDosen as $item)
                                <option value="{{$item->id}}" {{($bimbingUji3->dosen_id ?? null) == $item->id ? "selected='selected'" : ''}}>({{($item->kuota_peng_1-$item->total_peng_1)}}) {{$item->nidn}} - {{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="">Penguji 2 <span class="text-danger">*</span></label>
                            <select name="peng_2" onchange="updateOptions()" id="peng_2" class="form-control dosen-select select2-3" required>
                                <option value="">Pilih Penguji</option>
                                @foreach ($dataDosen as $item)
                                <option value="{{$item->id}}" {{($bimbingUji4->dosen_id ?? null) == $item->id ? "selected='selected'" : ''}}>({{($item->kuota_peng_2-$item->total_peng_2)}}) {{$item->nidn}} - {{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <a href="{{route('kaprodi.pembagian-dosen')}}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 col-lg-6">
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



@endsection
