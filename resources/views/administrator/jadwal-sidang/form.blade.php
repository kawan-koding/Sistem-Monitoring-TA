@extends('administrator.layout.main')
@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                    @endif
                    <form action="{{route('apps.jadwal-sidang.update', ['jadwalSidang' => $jadwalSidang->id])}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="">Ruangan<span class="text-danger"> *</span></label>
                            <select name="ruangan" class="form-control">
                                <option value="">Pilih Ruangan</option>
                                @foreach ($ruangan as $item)
                                    <option value="{{ $item->id }}" {{isset($editedData) ? $editedData->ruangan_id == $item->id ? "selected" : '' : ''}}>{{ $item->kode }}-{{ $item->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Tanggal<span class="text-danger"> *</span></label>
                            <input type="date" name="tanggal" class="form-control" value="{{isset($editedData) ? $editedData->tanggal : ''}}">
                        </div>
                        <div class="mb-3">
                            <label for="">Jam Mulai<span class="text-danger"> *</span></label>
                            <input type="time" name="jam_mulai" class="form-control" value="{{isset($editedData) ? $editedData->jam_mulai : ''}}">
                        </div>
                        <div class="mb-3">
                            <label for="">Jam Selesai<span class="text-danger"> *</span></label>
                            <input type="time" name="jam_selesai" class="form-control" value="{{isset($editedData) ? $editedData->jam_selesai : ''}}">
                        </div>
                        <a href="{{route('apps.jadwal-seminar')}}" class="btn btn-secondary">Kembali</a>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4>Jadwal Dosen Terdaftar</h4>
                    <hr class="mb-3">
                    <div class="accordion" id="accordion">
                        @foreach ($jadwalSidang->tugas_akhir->bimbing_uji as $item)
                            @if ($item->jenis == 'pembimbing' && $item->urut == 1)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsePembimbing{{ $item->urut }}" aria-expanded="true"
                                            aria-controls="collapsePembimbing{{ $item->urut }}">
                                            {{ $item->dosen->name }}
                                        </button>
                                    </h2>
                                    <div id="collapsePembimbing{{ $item->urut }}" class="accordion-collapse collapse show"
                                        data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Jam Mulai</th>
                                                        <th>Jam Sesai</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($jadwalPembimbing1->count() > 0)
                                                        @foreach ($jadwalPembimbing1 as $p1)
                                                            <tr>
                                                                <td>{{ $p1->tanggal }}</td>
                                                                <td>{{ $p1->jam_mulai }}</td>
                                                                <td>{{ $p1->jam_selesai }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class="text-center">
                                                            <td colspan="3">Tidak ada data</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($item->jenis == 'pembimbing' && $item->urut == 2)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsePembimbing{{  $item->urut }}" aria-expanded="false"
                                            aria-controls="collapsePembimbing{{  $item->urut }}">
                                            {{ $item->dosen->name }}
                                        </button>
                                    </h2>
                                    <div id="collapsePembimbing{{  $item->urut }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Jam Mulai</th>
                                                        <th>Jam Sesai</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($jadwalPembimbing2->count() > 0)
                                                        @foreach ($jadwalPembimbing2 as $p2)
                                                            <tr>
                                                                <td>{{ $p2->tanggal }}</td>
                                                                <td>{{ $p2->jam_mulai }}</td>
                                                                <td>{{ $p2->jam_selesai }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class="text-center">
                                                            <td colspan="3">Tidak ada data</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($item->jenis == 'penguji' && $item->urut == 1)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsePenguji1{{ $item->urut }}" aria-expanded="false"
                                            aria-controls="collapsePenguji1{{ $item->urut }}">
                                            {{ $item->dosen->name }}
                                        </button>
                                    </h2>
                                    <div id="collapsePenguji1{{ $item->urut }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Jam Mulai</th>
                                                        <th>Jam Sesai</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($jadwalPenguji1->count() > 0)
                                                        @foreach ($jadwalPenguji1 as $p1)
                                                            <tr>
                                                                <td>{{ $p1->tanggal }}</td>
                                                                <td>{{ $p1->jam_mulai }}</td>
                                                                <td>{{ $p1->jam_selesai }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class="text-center">
                                                            <td colspan="3">Tidak ada data</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($item->jenis == 'penguji' && $item->urut == 2)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsePenguji1{{ $item->urut }}" aria-expanded="false"
                                            aria-controls="collapsePenguji1{{ $item->urut }}">
                                            {{ $item->dosen->name }}
                                        </button>
                                    </h2>
                                    <div id="collapsePenguji1{{ $item->urut }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Jam Mulai</th>
                                                        <th>Jam Sesai</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($jadwalPenguji2->count() > 0)
                                                        @foreach ($jadwalPenguji2 as $p2)
                                                            <tr>
                                                                <td>{{ $p2->tanggal }}</td>
                                                                <td>{{ $p2->jam_mulai }}</td>
                                                                <td>{{ $p2->jam_selesai }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class="text-center">
                                                            <td colspan="3">Tidak ada data</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4>Jadwal Mahasiswa Terdaftar</h4>
                    <hr class="mb-0">
                    <table class="table table-responsive">
                        <thead style="color: steelblue">
                            <th>Nama Mahasiswa</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                        </thead>
                        <tbody>
                            @foreach($mahasiswaTerdaftar as $item)
                            <tr>
                                <td>{{ $item->tugas_akhir->mahasiswa->nama_mhs }}</td>
                                <td>{{ $item->tugas_akhir->tipe == 'K' ? 'Kelompok' : 'Individu' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->jam_mulai)->locale('id')->translatedFormat('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->locale('id')->translatedFormat('H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div>
@endsection
