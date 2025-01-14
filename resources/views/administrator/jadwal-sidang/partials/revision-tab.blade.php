@if (getInfoLogin()->hasRole('Dosen') && $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->jenis == 'pembimbing' || getInfoLogin()->hasRole('Mahasiswa'))
    <div class="row align-items-center">
        <div class="col-md-8 col-12">
            <h5 class="fw-bold mb-0">Lembar Revisi</h5>
            <p class="text-muted small m-0">Lihat uraian revisi yang telah diberikan oleh dosen penguji.</p>
        </div>
        @if (getInfoLogin()->hasRole('Mahasiswa'))

            <div class="col-md-4 col-12 text-center">
                <a href="{{ route('apps.jadwal-sidang.revisi', $data->id) }}" target="_blank"
                    class="btn btn-outline-dark btn-sm"><i class="bx bx-printer"></i> Cetak Lembar Revisi</a>
            </div>
            
        @endif
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
                    <td>{{ $loop->iteration }}</td>
                    <td style="white-space: nowrap">
                        <strong>{{ $item->dosen->name }}</strong>
                        <p class="m-0 text-muted small">Penguji {{ $item->urut }}</p>
                    </td>
                    <td>
                        {!! is_null($item->revisi()->where('type', 'Sidang')->first())
                            ? '-'
                            : $item->revisi()->where('type', 'Sidang')->first()->catatan !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="row align-items-center">
        <h5 class="fw-bold mb-0">Lembar Revisi</h5>
        <strong class="mb-0">{{ getInfoLogin()->userable->name }} (Penguji
            {{ $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->urut }})</strong>
        <p class="text-muted small m-0">Tuliskan revisi untuk:
            <strong>{{ $data->tugas_akhir->mahasiswa->nama_mhs }}</strong></p>
    </div>
    <hr>
    <div class="">
        <form action="{{ route('apps.jadwal-sidang.revisi', $data->id) }}" method="POST">
            @csrf
            <textarea name="revisi" id="elm1">{{ !is_null($data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Sidang')->first())? $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Sidang')->first()->catatan: '' }}</textarea>
            <br>
            <div class="text-end">
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
@endif
