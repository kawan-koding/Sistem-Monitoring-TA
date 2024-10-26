<div class="row align-items-center">
    <div class="col-md-9 col-12">
        <h5 class="fw-bold mb-0">Lembar Revisi</h5>
        <p class="text-muted small m-0">Lihat uraian revisi yang telah diberikan oleh dosen penguji.</p>
    </div>
    <div class="col-md-3 col-12 text-center">
        <button class="btn btn-outline-dark btn-sm"><i class="bx bx-printer"></i> Cetak Lembar Revisi</button>
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