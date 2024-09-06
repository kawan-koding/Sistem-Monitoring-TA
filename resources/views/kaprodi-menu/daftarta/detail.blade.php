@extends('layout.admin-main')
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('kaprodi.daftar-ta')}}" class="btn btn-sm btn-secondary">Kembali</a>
                <hr>
                <div class="row">
                    <div class="col-sm-12 col-lg-4 col-md-4">
                        <strong>NIM</strong>
                        <br>
                        <p>{{$data->mahasiswa->nim}}</p>
                    </div>
                    <div class="col-sm-12 col-lg-4 col-md-4">
                        <strong>Nama</strong>
                        <br>
                        <p>{{$data->mahasiswa->nama_mhs}}</p>
                    </div>
                    <div class="col-sm-12 col-lg-4 col-md-4">
                        <strong>Kelas</strong>
                        <br>
                        <p>{{$data->mahasiswa->kelas}}</p>
                    </div>
                    <div class="col-sm-12 col-lg-4 col-md-4">
                        <strong>Telp</strong>
                        <br>
                        <p>{{$data->mahasiswa->telp}}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Judul</strong>
                        <br>
                        <p>{{$data->judul}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Jenis</strong>
                        <br>
                        <p>{{$data->jenis_ta->nama_jenis}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Topik</strong>
                        <br>
                        <p>{{$data->topik->nama_topik}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Periode TA</strong>
                        <br>
                        <p>{{$data->periode_ta->nama}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Pembimbing 1</strong>
                        <br>
                        <p>{{$pembimbing1->dosen->name ?? '='}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Pembimbing 2</strong>
                        <br>
                        <p>{{$pembimbing2->dosen->name ?? '='}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Penguji 1</strong>
                        <br>
                        <p>{{$penguji1->dosen->name ?? '-'}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Penguji 2</strong>
                        <br>
                        <p>{{$penguji2->dosen->name ?? '-'}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Tipe</strong>
                        <br>
                        <p>{{$data->tipe == 'K' ? 'Kelompok' : 'Individu'}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Status</strong>
                        <br>
                        <p>{{$data->status}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Periode Mulai</strong>
                        <br>
                        <p>{{$data->periode_mulai}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Periode Akhir</strong>
                        <br>
                        <p>{{$data->periode_akhir}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Dokumen Pembimbing 1</strong>
                        <br>
                        @if (isset($data->dokumen_pemb_1))
                            <a href="{{asset('dokumen/'.$data->dokumen_pemb_1)}}" class="btn btn-secondary btn-sm"><i class="fas fa-download"></i> Download</a>
                        @else
                            <p>*)Belum memiliki dokumen</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Dokumen Pembimbing 2</strong>
                        <br>
                        @if (isset($data->file_persetujuan_pemb_2))
                            <a href="{{asset('dokumen/'.$data->file_persetujuan_pemb_2)}}" class="btn btn-secondary btn-sm"><i class="fas fa-download"></i> Download</a>
                        @else
                            <p>*)Belum memiliki dokumen</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Dokumen Ringkasan</strong>
                        <br>
                        @if (isset($data->dokumen_ringkasan))
                            <a href="{{asset('dokumen/'.$data->dokumen_ringkasan)}}" class="btn btn-secondary btn-sm"><i class="fas fa-download"></i> Download</a>
                        @else
                            <p>*)Belum memiliki dokumen</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Dokumen Proposal</strong>
                        <br>
                        @if (isset($data->file_proposal))
                            <a href="{{asset('dokumen/'.$data->file_proposal)}}" class="btn btn-secondary btn-sm"><i class="fas fa-download"></i> Download</a>
                        @else
                            <p>*)Belum memiliki dokumen</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <strong>Dokumen Pengesahan</strong>
                        <br>
                        @if (isset($data->file_pengesahan))
                            <a href="{{asset('dokumen/'.$data->file_pengesahan)}}" class="btn btn-secondary btn-sm"><i class="fas fa-download"></i> Download</a>
                        @else
                            <p>*)Belum memiliki dokumen</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <strong>Catatan :</strong>
                        <br>
                        <p>{{$data->catatan ?? 'Belum diisi'}}</p>
                    </div>
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
