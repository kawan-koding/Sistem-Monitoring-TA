@extends('administrator.layout.main')

@section('content')
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
            <div class="d-flex">
                <div class="w-100">
                    <h5 class="fw-bold mb-1">{{ isset($data->judul) ? $data->judul : '-' }}</h5>
                    <div class="d-flex gap-2 small text-muted">
                        <div
                            class="badge rounded-pill font-size-12 px-2 {{ isset($data->status) ? ($data->status == 'acc' ? 'badge-soft-success' : ($data->status == 'draft' ? 'bg-dark-subtle text-body' : 'badge-soft-danger')) : '' }}">
                            {{ isset($data->status) ? $data->status : '-' }}</div>
                        |
                        <span><strong>{{ isset($data->topik->nama_topik) ? $data->topik->nama_topik : '-' }}</strong> -
                            {{ isset($data->jenis_ta->nama_jenis) ? $data->jenis_ta->nama_jenis : '-' }}</span>
                    </div>
                </div>
            </div>
            <hr>
            <table class="ms-3" cellpadding="4">
                @forelse ($pembimbing as $key => $item)
                    <tr>
                        <th>Pembimbing {{ $key + 1 }}</th>
                        <td>:</td>
                        <td>{{ isset($item) ? $item->dosen->name : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <th>Pembimbing</th>
                        <th>:</th>
                        <th>-</th>
                    </tr>
                @endforelse
                @forelse ($penguji as $key => $item)
                    <tr>
                        <th>Penguji {{ $key + 1 }}</th>
                        <td>:</td>
                        <td>{{ isset($item) ? $item->dosen->name : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <th>Penguji</th>
                        <th>:</th>
                        <th>-</th>
                    </tr>
                @endforelse
                <tr>
                    <th>Tipe</th>
                    <td>:</td>
                    <td>{{ isset($data->tipe) ? ($data->tipe == 'I' ? 'Individu' : 'Kelompok') : '-' }}</td>
                </tr>
                <tr>
                    <th>Periode TA</th>
                    <td>:</td>
                    <td>{{ isset($data->periode_ta_id) ? $data->periode_ta->nama : '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ $action }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="">Pembimbing 1 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pembimbing_1" value="{{ $pembimbing->first()->dosen->name ?? '' }}" readonly> 
                            <input type="hidden" class="form-control form-pemb_1" name="pemb_1" value="{{$bimbingUji->dosen_id}}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="">Pembimbing 2 <span class="text-danger">*</span></label>
                            <select name="pembimbing_2" id="pembimbing_2" onchange="updateOptions()" class="form-control dosen-select select2">
                                <option value="">Pilih Pembimbing</option>
                                @foreach($dosen as $item)
                                    <option value="{{ $item->id }}" {{ (isset($bimbingUji2->dosen_id) && $bimbingUji2->dosen_id == $item->id) ? 'selected' : '' }}>
                                        {{ $item->nama }} (Sisa: {{ $item->sisa_pemb_2 }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="">Penguji 1 <span class="text-danger">*</span></label>
                            <select name="penguji_1" id="penguji_1" onchange="updateOptions()" class="form-control dosen-select select2">
                                <option value="">Pilih Penguji</option>
                                @foreach($dosen as $item)
                                    <option value="{{ $item->id }}" {{ (isset($bimbingUji3->dosen_id) && $bimbingUji3->dosen_id == $item->id) ? 'selected' : '' }}>
                                        {{ $item->nama }} (Sisa: {{ $item->sisa_peng_1 }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="">Penguji 2 <span class="text-danger">*</span></label>
                            <select name="penguji_2" id="penguji_2" onchange="updateOptions()" class="form-control dosen-select select2">
                                <option value="">Pilih Penguji</option>
                                @foreach($dosen as $item)
                                    <option value="{{ $item->id }}" {{ (isset($bimbingUji4->dosen_id) && $bimbingUji4->dosen_id == $item->id) ? 'selected' : '' }}>
                                        {{ $item->nama }} (Sisa: {{ $item->sisa_peng_2 }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        <div class="text-end">
                            <a href="{{ route('apps.pembagian-dosen')}}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
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
