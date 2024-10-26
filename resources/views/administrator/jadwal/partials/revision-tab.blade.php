@if ($data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->jenis == 'pembimbing')
    <div class="row align-items-center">
        <h5 class="fw-bold mb-0">Lembar Revisi</h5>
        <strong class="mb-0">{{ getInfoLogin()->userable->name }} (Pembimbing
            {{ $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->urut }})</strong>
        <p class="text-muted small m-0">Revisi untuk: <strong>{{ $data->tugas_akhir->mahasiswa->nama_mhs }}</strong></p>
    </div>
    <hr>
    <table class="table" width="100%">
        <thead class="bg-light">
            <th width="25">No.</th>
            <th>Penguji</th>
            <th>Uraian</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($data->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->orderBy('urut', 'asc')->get() as $item)
                <tr>
                    <td>1.</td>
                    <td style="white-space: nowrap">
                        <strong>{{ $item->dosen->name }}</strong>
                        <p class="m-0 text-muted small">Penguji {{ $item->urut }}</p>
                    </td>
                    <td>
                        {!! is_null($item->revisi()->where('type', 'Seminar')->first())
                            ? '-'
                            : $item->revisi()->where('type', 'Seminar')->first()->catatan !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
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
    <div class="row align-items-center">
        <h5 class="fw-bold mb-0">Lembar Revisi</h5>
        <strong class="mb-0">{{ getInfoLogin()->userable->name }} (Penguji {{ $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->urut }})</strong>
        <p class="text-muted small m-0">Tuliskan revisi untuk: <strong>{{ $data->tugas_akhir->mahasiswa->nama_mhs }}</strong></p>
    </div>
    <hr>
    <div class="">
        <form action="{{ route('apps.jadwal.revisi', $data->id) }}" method="POST">
            @csrf
            {{-- {{dd($data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi)}} --}}
            <textarea name="revisi" id="elm1">{{ !is_null($data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Seminar')->first()) ? $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Seminar')->first()->catatan : '' }}</textarea>
            <br>
            <div class="text-end">
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
@endif
