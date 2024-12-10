@if(getInfoLogin()->hasRole('Mahasiswa'))
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-8">
                <h5 class="m-0">Cetak Lembar Penilaian</h5>
                <p class="text-muted small m-0">Lakukan cetak seluruh lembar penilaian.</p>
            </div>
            <div class="col-4 text-end">
                <a href="{{ route('apps.jadwal-sidang.nilai', $data->id) }}" target="_blank" class="btn btn-outline-dark btn-sm"><i class="bx bx-printer"></i> Cetak Lembar Penilaian</a>
            </div>
        </div>

    </div>
</div>

@foreach($bimbingUjis as $bimbingUji)
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="col-12 text-center mb-4">
            <h5 class="mb-0 fw-bold">Lembar Penilaian</h5>
            <strong>({{$bimbingUji->dosen->name}})</strong>
            <p class="text-muted small">{{ ucfirst($bimbingUji->jenis) }} {{ $bimbingUji->urut }}</p>
        </div>
        <table class="table" width="100%">
            <thead class="bg-light">
                <th>No.</th>
                <th>Aspek</th>
                <th>Angka</th>
                <th>Huruf</th>
            </thead>
            <tbody>
                @foreach($kategoriNilais as $key => $category)
                <tr>
                    <td width="25">{{ $key + 1 }}.</td>
                    <td>{{ $category->nama }}</td>
                    <td>{{ $bimbingUji->penilaian->where('kategori_nilai_id', $category->id)->where('type', 'Sidang')->first()->nilai ?? '0' }}</td>
                    <td>{{ grade($bimbingUji->penilaian->where('kategori_nilai_id', $category->id)->where('type', 'Sidang')->first()->nilai ?? 0) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-light">
                <tr>
                    <td colspan="2">Total Nilai Angka</td>
                    <td colspan="2">{{ number_format($bimbingUji->penilaian->sum('nilai') > 0 ? $bimbingUji->penilaian->where('type', 'Sidang')->sum('nilai') / $bimbingUji->penilaian->count() : 0, 2, '.', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="2">Total Nilai Huruf</td>
                    <td colspan="2">{{ grade($bimbingUji->penilaian->sum('nilai') > 0 ? $bimbingUji->penilaian->where('type', 'Sidang')->sum('nilai') / $bimbingUji->penilaian->count() : 0) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endforeach
@else
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="col-12 mb-4">
            <h5 class="mb-0 fw-bold">Lembar Penilaian</h5>
            <strong>{{ getInfoLogin()->userable->name }} ({{ ucfirst($data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->jenis) }} {{ $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->urut }})</strong>
            <p class="text-muted small">Berikan nilai untuk : <strong>{{ $data->tugas_akhir->mahasiswa->nama_mhs }}</strong></p>
        </div>
        <form action="{{ route('apps.jadwal-sidang.nilai', $data->id) }}" method="post">
            @csrf
            <table class="table" width="100%">
                <thead class="bg-light">
                    <th>No.</th>
                    <th>Aspek</th>
                    <th>Angka</th>
                    <th>Huruf</th>
                </thead>
                <tbody>
                    @if($kategoriNilais->count() > 0)
                        @foreach ($kategoriNilais as $item)
                            <tr>
                                <td width="25">{{ $loop->iteration }}.</td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    <input type="text" name="nilai_{{ $item->id }}" data-grade-display="#grade-display-{{ $item->id }}" class="form-control numberOnly text-center w-25" value="{{ $nilais->where('kategori_nilai_id', $item->id)->first()->nilai ?? '' }}">
                                </td>
                                <td id="grade-display-{{ $item->id }}">{{ grade($nilais->where('kategori_nilai_id', $item->id)->first()->nilai ?? 0) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">Belum ada aspek nilai.</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="2">Total Nilai Angka</td>
                        <td colspan="2" class="average-display">{{ number_format($nilais->sum('nilai') > 0 ? $nilais->sum('nilai') / $nilais->count() : 0, 2, '.', ',') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Nilai Huruf</td>
                        <td colspan="2" class="average-grade-display">{{ grade($nilais->sum('nilai') > 0 ? $nilais->sum('nilai') / $nilais->count() : 0) }}</td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endif