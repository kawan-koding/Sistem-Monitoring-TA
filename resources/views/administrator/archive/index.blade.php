@extends('administrator.layout.main')
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <form action="" >
                        <div class="d-flex gap-2 flex-column flex-md-row">
                            <select name="program_studi" id="program_studi" class="form-control" onchange="this.form.submit()">
                                <option selected disabled hidden>Filter Program Studi</option>
                                <option value="semua" {{ request('program_studi') == 'semua' ? 'selected' : '' }}>Semua Program Studi</option>
                                @foreach($prodi as $p)
                                    <option value="{{ $p->id }}" {{ request('program_studi') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                @endforeach
                            </select>
                            <select name="periode" id="" class="form-control" onchange="this.form.submit()">
                                <option selected disabled hidden>Filter Periode</option>
                                <option value="semua" {{ request('periode') == 'semua'  ? 'selected' : '' }}>Semua</option>
                                @foreach ($periode as $item)
                                    <option value="">{{$item->programStudi->display}} - ({{ $item->nama }})</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    @if(auth()->user()->hasRole('Developer'))
                        <a href="{{ route('apps.download-all') }}" target="_blank" class="btn btn-primary">Download Dokumen Pemberkasan</a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Mahasiswa</th>
                                <th width="40%">Judul</th>
                                <th width="20%">Dosen</th>
                                <th width="10%">Periode</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <p class="m-0 badge rounded-pill bg-primary-subtle text-primary small">{{ $item->mahasiswa->programStudi->display }}</p>
                                        <a href="#" class="m-0" data-bs-toggle="modal" data-bs-target="#mahasiswaModal{{ $key }}">
                                            <p class="fw-bold m-0">{{ $item->mahasiswa->nama_mhs }}</p>
                                        </a>
                                        <div class="modal fade" id="mahasiswaModal{{ $key }}" tabindex="-1" aria-labelledby="mahasiswaModalLabel{{ $key }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="mahasiswaModalLabel{{ $key }}">Biodata Mahasiswa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-4 text-center">
                                                                <img src="{{ $item->mahasiswa->user->image == null ? 'https://ui-avatars.com/api/?background=random&name=' . $item->mahasiswa->user->name : asset('storage/images/users/' . $item->mahasiswa->user->image) }}"
                                                                    alt="Foto Mahasiswa" class="img-fluid rounded">
                                                            </div>
                                                            <div class="col-md-8">
                                                                <table class="table table-sm table-borderless">
                                                                    <tr>
                                                                        <th>Nama</th>
                                                                        <td>{{ $item->mahasiswa->nama_mhs ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>NIM</th>
                                                                        <td>{{ $item->mahasiswa->nim ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Kelas</th>
                                                                        <td>{{ $item->mahasiswa->kelas ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Prodi</th>
                                                                        <td>{{ $item->mahasiswa->programStudi->display ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Telepon</th>
                                                                        <td>{{ $item->mahasiswa->telp ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Email</th>
                                                                        <td>{{ $item->mahasiswa->email ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="m-0 p-0 text-muted small">NIM : {{$item->mahasiswa->nim}}</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-primary small mb-1 fw-bold">{{ isset($item->tipe) ? ($item->tipe == 'I' ? 'Individu' : 'Kelompok') : '-'   }}</span>
                                        <p class="m-0 small"><strong>{{ $item->judul ?? '-' }}</strong></p>
                                        <p class="m-0 text-muted font-size-12 small">{{ $item->topik->nama_topik ?? '-' }} - {{ $item->jenis_ta->nama_jenis ?? '-'}}</p>
                                    </td>
                                    <td>
                                        <p class="fw-bold small m-0">Pembimbing</p>
                                        <ol>
                                            @foreach ($item->bimbing_uji->where('jenis', 'pembimbing')->sortBy('urut') as $pembimbing)
                                                <li class="small">{{ $pembimbing->dosen->name }}</li>
                                            @endforeach
                                        </ol>
                                        <p class="fw-bold small m-0">Penguji</p>
                                        <ol>
                                            @foreach ($item->bimbing_uji->where('jenis', 'penguji')->sortBy('urut') as $penguji)
                                                <li class="small">{{ $penguji->dosen->name }}</li>
                                            @endforeach
                                        </ol>
                                        <p class="fw-bold small m-0">Pengganti</p>
                                        <ol>
                                            @for ($i = 0; $i < 2; $i++)
                                                @if (isset($item->tugas_akhir->bimbing_uji) && $item->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', $i + 1)->count() > 0)
                                                    @foreach ($item->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->get() as $peng)
                                                        @if ($peng->jenis == 'pengganti' && $peng->urut == 1 && $i == 0)
                                                            <li class="small">{{ $peng->dosen->name ?? '-' }}</li>
                                                        @endif
                                                        @if ($peng->jenis == 'pengganti' && $peng->urut == 2 && $i == 1)
                                                            <li class="small">{{ $peng->dosen->name ?? '-' }}</li>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <li class="small">-</li>
                                                @endif
                                            @endfor
                                        </ol>
                                    </td>
                                    <td><p class="small">{{ $item->periode_ta->nama ?? '-' }}</p></td>
                                    <td>
                                        <a href="{{ route('apps.archives.show', $item->id)}}" class="btn btn-sm btn-outline-warning mb-1" title="Detail"><i class="bx bx-show"></i></a>
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
