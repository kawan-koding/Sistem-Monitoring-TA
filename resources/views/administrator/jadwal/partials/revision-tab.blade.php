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
                        @if(!is_null($item->revisi()->where('type', 'Seminar')->first()) && $item->revisi()->where('type', 'Seminar')->first()->is_mentor_validation)
                            <span class="badge badge-soft-primary text-primary small">Sudah Divalidasi</span>
                        @endif
                    </td>
                    <td>
                        {!! is_null($item->revisi()->where('type', 'Seminar')->first())
                            ? '-'
                            : $item->revisi()->where('type', 'Seminar')->first()->catatan !!}
                    </td>
                    <td>
                        @if(!is_null($item->revisi()->where('type', 'Seminar')->first()) && $item->revisi()->where('type', 'Seminar')->first()->is_mentor_validation)
                            <button class="btn btn-success btn-small">Sudah Divalidasi</button>
                        @endif
                        @if(!is_null($item->revisi()->where('type', 'Seminar')->first()) && !$item->revisi()->where('type', 'Seminar')->first()->is_mentor_validation)
                            <a href="{{ route('apps.jadwal.mentor-validation', $item->revisi()->where('type', 'Seminar')->first()->id) }}"
                                class="btn btn-outline-primary btn-sm"><i class="bx bx-check"></i> Validasi Revisi</a>
                        @endif
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
            @php
                $bimbingUji = $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first();
                $revisiSeminar = $bimbingUji ? $bimbingUji->revisi()->where('type', 'Seminar')->first() : null;
            @endphp
            <strong>{{ $data->tugas_akhir->mahasiswa->nama_mhs }}</strong>
            @if($revisiSeminar && !$revisiSeminar->is_mentor_validation)
                <span class="badge badge-soft-secondary">Belum divalidasi pembimbing</span>
            @elseif($revisiSeminar && $revisiSeminar->is_valid)
                <span class="badge badge-soft-success">Sudah Revisi</span>
            @endif

    </div>
    <hr>
    <div class="">
        <form action="{{ route('apps.jadwal.revisi', $data->id) }}" method="POST">
            @csrf
            <textarea name="revisi" id="elm1">{{ !is_null($data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Seminar')->first())? $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Seminar')->first()->catatan: '' }}</textarea>
            <br>
            <div class="text-end">
                @if(!is_null($data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Seminar')->first()) && $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Seminar')->first()->is_mentor_validation && !$data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Seminar')->first()->is_valid)
                    <a href="{{ route('apps.jadwal.revision-valid', $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Seminar')->first()->id) }}" class="btn btn-success">Sudah Revisi</a>
                @endif
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
@endif
