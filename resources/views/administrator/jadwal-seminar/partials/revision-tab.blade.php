<div class="row align-items-center">
    <div class="col-md-8 col-12">
        <h5 class="fw-bold mb-0">Lembar Revisi</h5>
        <p class="text-muted small m-0">Lihat uraian revisi yang telah diberikan oleh dosen penguji.</p>
    </div>
    <div class="col-md-4 col-12 text-center">
        @php
            $revisi = $data->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->with('revisi')->get()->flatMap(function($bimbingUji) {
                return $bimbingUji->revisi;
            });

            $revisi = $revisi->where('type', 'Seminar');
            $allValid = $revisi->isNotEmpty() && $revisi->every(fn($rev) => $rev->is_valid == true);
        @endphp

        @if($allValid)
            <a href="{{ route('apps.cetak.revisi', $data->id )}}" target="_blank" class="btn btn-outline-dark btn-sm"><i class="bx bx-printer"></i> Cetak Lembar Revisi</a>
        @endif
    </div>
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
                <td>{{$loop->iteration  }}</td>
                <td style="white-space: nowrap">
                    <strong>{{ $item->dosen->name }}</strong>
                    <p class="m-0 text-muted small">Penguji {{ $item->urut }}</p>
                    @php
                        $revisi = $item->revisi()->where('type', 'Seminar')->first();
                    @endphp
                    <span class="badge small {{ isset($revisi->is_valid) ? ($revisi->is_valid ? 'badge-soft-success' : 'badge-soft-danger') : 'badge-soft-secondary' }} ">
                        {{ isset($revisi->is_valid) ? ($revisi->is_valid ? 'Sudah Divalidasi' : 'Belum Divalidasi') : '-' }}
                    </span>

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