@extends('administrator.layout.main')
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                @if (in_array(session('switchRoles'), ['Admin','Developer','Kajur','Kaprodi']))
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    @if(in_array(session('switchRoles'), ['Admin','Developer']))
                    <div class="btn-group" role="group">
                        <button id="btnGroupVerticalDrop1" type="button" class="btn btn-primary dropdown-toggle mb-2" style="max-width: 150px;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-file-excel me-2"></i> Export Data <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                            @foreach ($prodi as $item)
                                <a class="dropdown-item" target="_blank" href="{{ route('apps.daftar-ta.export', ['prodi' => $item->id]) }}">{{ $item->display }}</a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <form action="" >
                        <div class="d-flex gap-2 flex-column flex-md-row">
                            @if(in_array(session('switchRoles'), ['Admin','Developer']))
                            <select name="program_studi" id="program_studi" class="form-control" onchange="this.form.submit()">
                                <option selected disabled hidden>Filter Program Studi</option>
                                <option value="semua" {{ request('program_studi') == 'semua' ? 'selected' : '' }}>Semua Program Studi</option>
                                @foreach($prodi as $p)
                                    <option value="{{ $p->id }}" {{ request('program_studi') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                @endforeach
                            </select>
                            @endif
                            <select name="mahasiswa" id="mahasiswa" class="form-control" onchange="this.form.submit()">
                                <option selected disabled hidden>Filter Mahasiswa</option>
                                <option value="semua" {{ request('mahasiswa') == 'semua' ? 'selected' : '' }}>Semua</option>
                                <option value="tanpa_ta" {{ request('mahasiswa') == 'tanpa_ta' ? 'selected' : '' }}>Belum Mengajukan TA</option>
                                <option value="belum_sempro" {{ request('mahasiswa') == 'belum_sempro' ? 'selected' : '' }}>Belum Sempro</option>
                                <option value="belum_sidang" {{ request('mahasiswa') == 'belum_sidang' ? 'selected' : '' }}>Belum Sidang</option>
                                <option value="belum_pemberkasan" {{ request('mahasiswa') == 'belum_pemberkasan' ? 'selected' : '' }}>Belum Pemberkasan Akhir</option>
                            </select>
                            <select name="filter" id="" class="form-control" onchange="this.form.submit()">
                                <option selected disabled hidden>Filter Jenis Penyelesaian</option>
                                <option value="semua" {{ request('filter') == 'semua'  ? 'selected' : '' }}>Semua</option>
                                <option value="I" {{ $filter == 'I' ? 'selected' : '' }}>Individu</option>
                                <option value="K" {{ $filter == 'K' ? 'selected' : '' }}>Kelompok</option>
                            </select>
                        </div>
                    </form>
                </div>
                <hr>
                @endif
                
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
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Mahasiswa</th>
                                <th width="40%">Judul</th>
                                <th width="20%">Dosen</th>
                                <th width="10%">Periode</th>
                                <th width="10%">Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <p class="m-0 badge rounded-pill bg-primary-subtle text-primary small">{{ $item->programStudi->display }}</p> 
                                        <a href="#" class="m-0" data-bs-toggle="modal" data-bs-target="#mahasiswaModal{{ $key }}"> 
                                            <p class="fw-bold m-0">{{ $item->nama_mhs }}</p>
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
                                                                <img src="{{ $item->user->image == null ? 'https://ui-avatars.com/api/?background=random&name=' . $item->mahasiswa->name : asset('storage/images/users/' . $item->user->image) }}"
                                                                    alt="Foto Mahasiswa" class="img-fluid rounded">
                                                            </div>
                                                            <div class="col-md-8">
                                                                <table class="table table-sm table-borderless">
                                                                    <tr>
                                                                        <th>Nama</th>
                                                                        <td>{{ $item->nama_mhs ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>NIM</th>
                                                                        <td>{{ $item->nim ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Kelas</th>
                                                                        <td>{{ $item->kelas ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Prodi</th>
                                                                        <td>{{ $item->programStudi->display ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Telepon</th>
                                                                        <td>{{ $item->telp ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Email</th>
                                                                        <td>{{ $item->email ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="m-0 p-0 text-muted small">NIM : {{$item->nim}}</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-primary small mb-1 fw-bold">{{ isset($item->tugas_akhir->first()->tipe) ? ($item->tugas_akhir->first()->tipe == 'I' ? 'Individu' : 'Kelompok') : '-'   }}</span>
                                        <p class="m-0 small"><strong>{{ $item->tugas_akhir->first()->judul ?? '-' }}</strong></p>
                                        <p class="m-0 text-muted font-size-15 small">{{ $item->tugas_akhir->first()->topik->nama_topik ?? '-' }} - {{ $item->tugas_akhir->first()->jenis_ta->nama_jenis ?? '-'}}</p>
                                    </td>
                                    <td>
                                        <p class="fw-bold small m-0">Pembimbing</p>
                                        <ol>
                                            @if (isset($item->tugas_akhir) && isset($item->tugas_akhir->first()->bimbing_uji))
                                                @foreach ($item->tugas_akhir->first()->bimbing_uji->where('jenis', 'pembimbing')->sortBy('urut') as $pembimbing)
                                                    <li class="small">{{ $pembimbing->dosen->name }}</li>
                                                @endforeach
                                            @else
                                                <li class="small">-</li>
                                            @endif
                                        </ol>
                                        <p class="fw-bold small m-0">Penguji</p>
                                        <ol>
                                            @if (isset($item->tugas_akhir) && isset($item->tugas_akhir->first()->bimbing_uji))
                                                @foreach ($item->tugas_akhir->first()->bimbing_uji->where('jenis', 'penguji')->sortBy('urut') as $penguji)
                                                    <li class="small">{{ $penguji->dosen->name }}</li>
                                                @endforeach
                                            @else
                                                <li class="small">-</li>
                                            @endif

                                        </ol>
                                    </td>
                                    <td><p class="small">{{ $item->tugas_akhir->first()->periode_ta->nama ?? '-' }}</p></td>
                                    <td>
                                        <span class="badge {{ isset($item->tugas_akhir->first()->status) ? ($item->tugas_akhir->first()->status == 'acc' ? 'badge-soft-success' : (in_array($item->tugas_akhir->first()->status, ['draft', 'pengajuan ulang']) ? 'bg-dark-subtle text-body' : ($item->tugas_akhir->first()->status == 'revisi' ? 'badge-soft-warning' : 'badge-soft-danger'))) : ''}} small mb-1"> {{ ucfirst($item->tugas_akhir->first()->status ?? '-')}} </span>
                                    </td>
                                    <td>
                                        @if(isset($item->tugas_akhir) && isset($item->tugas_akhir->first()->id))
                                            @can('update-daftar-ta')
                                            <a href="{{ route('apps.daftar-ta.edit', $item->tugas_akhir->first()->id)}}" class="btn btn-sm btn-outline-primary mb-1" title="Edit"><i class="bx bx-edit-alt"></i></a>
                                            @endcan
                                            @can('read-daftar-ta')
                                            <a href="{{ route('apps.daftar-ta.show', $item->tugas_akhir->first()->id)}}" class="btn btn-sm btn-outline-warning mb-1" title="Detail"><i class="bx bx-show"></i></a>
                                            @endcan
                                            @can('delete-daftar-ta')
                                            <button onclick="hapusDaftarTa('{{ $item->tugas_akhir->first()->id }}', '{{ route('apps.daftar-ta.delete', $item->tugas_akhir->first()->id) }}')" class="btn btn-sm btn-outline-dark mb-3" title="Hapus"><i class="bx bx-trash"></i></button>
                                            @endcan
                                        @else 
                                            -
                                        @endif
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
