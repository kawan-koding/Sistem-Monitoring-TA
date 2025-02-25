@if (getInfoLogin()->hasRole('Dosen') && $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->jenis == 'pembimbing' || getInfoLogin()->hasRole('Mahasiswa'))
    <div class="row align-items-center">
        <div class="col-md-8 col-12">
            <h5 class="fw-bold mb-0">Lembar Revisi</h5>
            <p class="text-muted small m-0">Lihat uraian revisi yang telah diberikan oleh dosen penguji.</p>
        </div>
        @if (getInfoLogin()->hasRole('Mahasiswa'))        
            @php
                $penguji1 = $data->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->with('revisi')->first();
                $penguji2 = $data->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->with('revisi')->first();
                $pengganti1 = $data->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 1)->with('revisi')->first();
                $pengganti2 = $data->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 2)->with('revisi')->first();
                $revisi1 = optional($pengganti1 ?? $penguji1)->revisi->where('type', 'Sidang')->first();
                $revisi2 = optional($pengganti2 ?? $penguji2)->revisi->where('type', 'Sidang')->first();

                $validRevisions = collect([$revisi1, $revisi2])->filter();
                $allValid = $validRevisions->every(fn($rev) => $rev->is_valid == true);
            @endphp

            @if($validRevisions->isNotEmpty() && $allValid) 
                <div class="col-md-4 col-12 text-center">
                    <a href="{{ route('apps.jadwal-sidang.revisi', $data->id) }}" target="_blank"
                        class="btn btn-outline-dark btn-sm"><i class="bx bx-printer"></i> Cetak Lembar Revisi</a>
                </div>
            @endif
            
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
                        @if(!is_null($item->revisi()->where('type', 'Sidang')->first()) && $item->revisi()->where('type', 'Sidang')->first()->is_mentor_validation)
                            <span class="badge badge-soft-primary text-primary small">Sudah Divalidasi</span>
                        @endif
                    </td>
                    <span class="badge small {{ isset($revisi->is_valid) ? ($revisi->is_valid ? 'badge-soft-success' : 'badge-soft-danger') : 'badge-soft-secondary' }} ">
                        {{ isset($revisi->is_valid) ? ($revisi->is_valid ? 'Sudah Divalidasi' : 'Belum Divalidasi') : '-' }}
                    </span>
                    <td>
                        {!! is_null($item->revisi()->where('type', 'Sidang')->first())
                            ? '-'
                            : $item->revisi()->where('type', 'Sidang')->first()->catatan !!}
                    </td>
                    <td>
                        @if(!is_null($item->revisi()->where('type', 'Sidang')->first()) && $item->revisi()->where('type', 'Sidang')->first()->is_mentor_validation)
                            <button class="btn btn-success btn-small">Sudah Divalidasi</button>
                        @endif
                        @if(!is_null($item->revisi()->where('type', 'Sidang')->first()) && !$item->revisi()->where('type', 'Sidang')->first()->is_mentor_validation)
                        <a href="{{ route('apps.jadwal-sidang.mentor-validation', $item->revisi()->where('type', 'Sidang')->first()->id) }}"
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
                $revisiSidang = $bimbingUji ? $bimbingUji->revisi()->where('type', 'Sidang')->first() : null;
            @endphp
            <strong>{{ $data->tugas_akhir->mahasiswa->nama_mhs }}</strong>
            @if($revisiSidang && !$revisiSidang->is_mentor_validation)
                <span class="badge badge-soft-secondary">Belum divalidasi pembimbing</span>
            @elseif($revisiSidang && $revisiSidang->is_valid)
                <span class="badge badge-soft-success">Sudah Revisi</span>
            @endif
    </div>
    <hr>
    <div class="">
        <form action="{{ route('apps.jadwal-sidang.revisi', $data->id) }}" method="POST">
            @csrf
            <textarea name="revisi" id="elm1">{{ !is_null($data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Sidang')->first())? $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Sidang')->first()->catatan: '' }}</textarea>
            <br>
            <div class="text-end">
                @if(!is_null($data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Sidang')->first()) && $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Sidang')->first()->is_mentor_validation && !$data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Sidang')->first()->is_valid)
                    <a href="{{ route('apps.jadwal-sidang.revision-valid', $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->revisi()->where('type', 'Sidang')->first()->id) }}" class="btn btn-success">Sudah Revisi</a>
                @endif
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
@endif
